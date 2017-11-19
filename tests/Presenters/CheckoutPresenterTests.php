<?php
/**
 * Copyright 2017 Nick Korbel
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

require_once(ROOT_DIR . 'Presenters/Credits/CheckoutPresenter.php');

class CheckoutPresenterTests extends TestBase
{
    /**
     * @var FakeCheckoutPage
     */
    private $page;
    /**
     * @var FakePaymentRepository
     */
    private $paymentRepository;
    /**
     * @var CheckoutPresenter
     */
    private $presenter;

    public function setup()
    {
        parent::setup();

        $this->page = new FakeCheckoutPage();
        $this->paymentRepository = new FakePaymentRepository();
        $this->presenter = new CheckoutPresenter($this->page, $this->paymentRepository);
    }

    public function testPageLoadCreatesCartAndPresentsPaymentOptions()
    {
        $this->page->_CreditQuantity = 10;
        $cost = new CreditCost(5);
        $this->paymentRepository->_CreditCost = $cost;
        $this->paymentRepository->_PayPal = new PayPalGateway(true, 'client', 'secret', 'live');
        $this->paymentRepository->_Stripe = new StripeGateway(true, 'publish', 'secret');

        $this->presenter->PageLoad($this->fakeUser);

        $this->assertEquals(50, $this->page->_Total);
        $this->assertEquals($cost, $this->page->_CreditCost);
        $this->assertEquals(10, $this->page->_NumberOfCreditsBeingPurchased);
        $this->assertEquals(new CreditCartSession(10, 5, 'USD'), $this->fakeServer->GetSession(SessionKeys::CREDIT_CART));
        $this->assertEquals(true, $this->page->_PayPalEnabled);
        $this->assertEquals('client', $this->page->_PayPalClientId);
        $this->assertEquals('live', $this->page->_PayPalEnvironment);
        $this->assertEquals(true, $this->page->_StripeEnabled);
        $this->assertEquals('publish', $this->page->_StripePublishableKey);
    }

    public function testCreatesPayPalPayment()
    {
        $creditCartSession = new CreditCartSession(5, 10, 'USD');
        $this->fakeServer->SetSession(SessionKeys::CREDIT_CART, $creditCartSession);

        $gateway = new FakePayPalGateway();
        $this->paymentRepository->_PayPal = $gateway;

        $this->presenter->CreatePayPalPayment();

        $this->assertEquals($creditCartSession, $gateway->_PaymentCreatedCart);
        $this->assertEquals($gateway->_Payment, $this->page->_PayPalPayment);
        $this->assertEquals('/checkout.php?paypalaction=payment', $gateway->_ReturnUrl);
        $this->assertEquals('/checkout.php?paypalaction=cancel', $gateway->_CancelUrl);
    }

    public function testExecutesPayPalPayment()
    {
        $creditCartSession = new CreditCartSession(5, 10, 'USD');
        $this->fakeServer->SetSession(SessionKeys::CREDIT_CART, $creditCartSession);

        $paymentId = "12323";
        $payerId = "23jksdlkf";

        $this->page->_PaymentId = $paymentId;
        $this->page->_PayerId = $payerId;

        $gateway = new FakePayPalGateway();
        $this->paymentRepository->_PayPal = $gateway;

        $this->presenter->ExecutePayPalPayment();

        $this->assertEquals($creditCartSession, $gateway->_PaymentCreatedCart);
        $this->assertEquals($gateway->_Payment, $this->page->_PayPalPayment);
        $this->assertEquals($paymentId, $gateway->_PaymentId);
        $this->assertEquals($payerId, $gateway->_PayerId);
    }
}

class FakeCheckoutPage extends CheckoutPage
{
    public $_CreditQuantity;
    public $_Total;
    public $_PayPalEnabled;
    public $_PayPalClientId;
    public $_PayPalEnvironment;
    public $_StripeEnabled;
    public $_StripePublishableKey;
    public $_CreditCost;
    public $_NumberOfCreditsBeingPurchased;
    public $_PayPalPayment;
    public $_PaymentId;
    public $_PayerId;

    public function GetCreditQuantity()
    {
        return $this->_CreditQuantity;
    }

    public function SetPayPalSettings($enabled, $clientId, $environment)
    {
        $this->_PayPalEnabled = $enabled;
        $this->_PayPalClientId = $clientId;
        $this->_PayPalEnvironment = $environment;
    }

    public function SetStripeSettings($enabled, $publishableKey)
    {
        $this->_StripeEnabled = $enabled;
        $this->_StripePublishableKey = $publishableKey;
    }

    public function SetTotals($total, $cost, $creditQuantity)
    {
        $this->_Total = $total;
        $this->_CreditCost = $cost;
        $this->_NumberOfCreditsBeingPurchased = $creditQuantity;
    }

    public function SetPayPalPayment($payment)
    {
        $this->_PayPalPayment = $payment;
    }

    public function GetPaymentId()
    {
        return $this->_PaymentId;
    }

    public function GetPayerId()
    {
        return $this->_PayerId;
    }
}