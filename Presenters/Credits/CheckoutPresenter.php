<?php
/**
 * Copyright 2017-2019 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'Pages/Credits/CheckoutPage.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'lib/Server/CreditCartSession.php');

class CheckoutPresenter extends ActionPresenter
{
    /**
     * @var ICheckoutPage
     */
    private $page;

    /**
     * @var IPaymentRepository
     */
    private $paymentRepository;

    /**
     * @var IUserRepository
     */
    private $userRepository;
    /**
     * @var IPaymentTransactionLogger
     */
    private $paymentLogger;

    public function __construct(ICheckoutPage $page, IPaymentRepository $paymentRepository, IUserRepository $userRepository, IPaymentTransactionLogger $paymentLogger)
    {
        parent::__construct($page);

        $this->page = $page;
        $this->paymentRepository = $paymentRepository;
        $this->userRepository = $userRepository;
        $this->paymentLogger = $paymentLogger;

        $this->AddAction('executePayPalPayment', 'ExecutePayPalPayment');
        $this->AddAction('createPayPalPayment', 'CreatePayPalPayment');
        $this->AddAction('executeStripePayment', 'ExecuteStripePayment');
    }

    public function PageLoad(UserSession $userSession)
    {
        $creditQuantity = floatval($this->page->GetCreditQuantity());

        $cost = $this->paymentRepository->GetCreditCost();
        $paypal = $this->paymentRepository->GetPayPalGateway();
        $stripe = $this->paymentRepository->GetStripeGateway();

        $total = $cost->GetTotal($creditQuantity);

        if ($creditQuantity == 0)
        {
            $this->page->SetEmptyCart(true);
        }
        else {
            $this->page->SetTotals($total, $cost, $creditQuantity);
            $this->page->SetPayPalSettings($paypal->IsEnabled(), $paypal->ClientId(), $paypal->Environment());
            $this->page->SetStripeSettings($stripe->IsEnabled(), $stripe->PublishableKey());

            ServiceLocator::GetServer()->SetSession(SessionKeys::CREDIT_CART, new CreditCartSession($creditQuantity, $cost->Cost(), $cost->Currency(), $userSession->UserId));
        }
    }

    public function CreatePayPalPayment()
    {
        $gateway = $this->paymentRepository->GetPayPalGateway();
        $baseUrl = new Url(Configuration::Instance()->GetScriptUrl());
        $returnUrl = $baseUrl->Copy()->Add(Pages::CHECKOUT)->AddQueryString(QueryStringKeys::PAYPAL_ACTION, PayPalGateway::ACTION_PAYMENT);
        $cancelUrl = $baseUrl->Copy()->Add(Pages::CHECKOUT)->AddQueryString(QueryStringKeys::PAYPAL_ACTION, PayPalGateway::ACTION_CANCEL);

        $cart = ServiceLocator::GetServer()->GetSession(SessionKeys::CREDIT_CART);
        $payment = $gateway->CreatePayment($cart, $returnUrl->ToString(), $cancelUrl->ToString());

        $this->page->SetPayPalPayment($payment);
    }

    public function ExecutePayPalPayment()
    {
        $gateway = $this->paymentRepository->GetPayPalGateway();

        /** @var $cart CreditCartSession */
        $cart = ServiceLocator::GetServer()->GetSession(SessionKeys::CREDIT_CART);
        $payment = $gateway->ExecutePayment($cart, $this->page->GetPaymentId(), $this->page->GetPayerId(), $this->paymentLogger);

        if ($payment->state == "approved")
        {
            $user = $this->userRepository->LoadById(ServiceLocator::GetServer()->GetUserSession()->UserId);
            $user->AddCredits($cart->Quantity, Resources::GetInstance()->GetString('NoteCreditsPurchased'));
            $this->userRepository->Update($user);
            ServiceLocator::GetServer()->SetSession(SessionKeys::CREDIT_CART, null);
        }

        $this->page->SetPayPalPayment($payment);
    }

    public function ExecuteStripePayment()
    {
        $token = $this->page->GetStripeToken();
        $userSession = ServiceLocator::GetServer()->GetUserSession();

        $gateway = $this->paymentRepository->GetStripeGateway();

        /** @var $cart CreditCartSession */
        $cart = ServiceLocator::GetServer()->GetSession(SessionKeys::CREDIT_CART);
        $result = $gateway->Charge($cart, $userSession->Email, $token, $this->paymentLogger);

        if ($result == true)
        {
            $user = $this->userRepository->LoadById($userSession->UserId);
            $user->AddCredits($cart->Quantity, Resources::GetInstance()->GetString('NoteCreditsPurchased'));
            $this->userRepository->Update($user);
            ServiceLocator::GetServer()->SetSession(SessionKeys::CREDIT_CART, null);
        }

        $this->page->SetStripeResult($result);
    }
}