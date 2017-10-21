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

require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManagePaymentsPresenter.php');
require_once(ROOT_DIR . 'Domain/Access/PaymentRepository.php');

interface IManagePaymentsPage extends IActionPage
{

    /**
     * @return string
     */
    public function GetCreditCost();

    /**
     * @return string
     */
    public function GetCreditCurrency();

    /**
     * @param float $cost
     * @param string $currency
     */
    public function SetCreditCost($cost, $currency);

    /**
     * @return bool
     */
    public function GetPayPalIsEnabled();

    /**
     * @return string
     */
    public function GetPayPalClientId();

    /**
     * @return string
     */
    public function GetPayPalSecret();

    /**
     * @return string
     */
    public function GetPayPalEnvironment();

    /**
     * @return bool
     */
    public function GetStripeIsEnabled();

    /**
     * @return string
     */
    public function GetStripePublishableKey();

    /**
     * @return string
     */
    public function GetStripeSecretKey();

    /**
     * @param bool $enabled
     * @param string $clientId
     * @param string $secret
     * @param string $environment
     */
    public function SetPayPalSettings($enabled, $clientId, $secret, $environment);

    /**
     * @param string $enabled
     * @param string $publishableKey
     * @param string $secretKey
     */
    public function SetStripeSettings($enabled, $publishableKey, $secretKey);
}

class ManagePaymentsPage extends ActionPage implements IManagePaymentsPage
{
    /**
     * @var ManagePaymentsPresenter
     */
    private $presenter;

    public function __construct()
    {
        parent::__construct('ManagePayments', 1);
        $paymentRepository = new PaymentRepository();
        $this->presenter = new ManagePaymentsPresenter($this, $paymentRepository);
    }

    public function ProcessAction()
    {
        $this->presenter->ProcessAction();
    }

    public function ProcessDataRequest($dataRequest)
    {
        //$this->presenter->ProcessDataRequest();
    }

    public function ProcessPageLoad()
    {
        $paymentsEnabled = Configuration::Instance()->GetSectionKey(ConfigSection::CREDITS, ConfigKeys::CREDITS_ALLOW_PURCHASE, new BooleanConverter());

        $this->Set('PaymentsEnabled', $paymentsEnabled);
        $this->presenter->PageLoad();
        $this->Display('Admin/Payments/manage_payments.tpl');
    }

    public function GetCreditCost()
    {
        return $this->GetForm(FormKeys::CREDIT_COST);
    }

    public function GetCreditCurrency()
    {
        return $this->GetForm(FormKeys::CREDIT_CURRENCY);
    }

    public function SetCreditCost($cost, $currency)
    {
        $this->Set('CreditCost', $cost);
        $this->Set('CreditCurrency', $currency);
    }

    public function GetPayPalIsEnabled()
    {
        return $this->GetCheckbox(FormKeys::PAYPAL_ENABLED);
    }

    public function GetPayPalClientId()
    {
        return $this->GetForm(FormKeys::PAYPAL_CLIENT_ID);
    }

    public function GetPayPalSecret()
    {
        return $this->GetForm(FormKeys::PAYPAL_SECRET);
    }

    public function GetPayPalEnvironment()
    {
        return $this->GetForm(FormKeys::PAYPAL_ENVIRONMENT);
    }

    public function GetStripeIsEnabled()
    {
        return $this->GetCheckbox(FormKeys::STRIPE_ENABLED);
    }

    public function GetStripePublishableKey()
    {
        return $this->GetForm(FormKeys::STRIPE_PUBLISHABLE_KEY);
    }

    public function GetStripeSecretKey()
    {
        return $this->GetForm(FormKeys::STRIPE_SECRET_KEY);
    }

    public function SetPayPalSettings($enabled, $clientId, $secret, $environment)
    {
        $this->Set('PayPalEnabled', (int)$enabled);
        $this->Set('PayPalClientId', $clientId);
        $this->Set('PayPalSecret', $secret);
        $this->Set('PayPalEnvironment', $environment);
    }

    public function SetStripeSettings($enabled, $publishableKey, $secretKey)
    {
        $this->Set('StripeEnabled', (int)$enabled);
        $this->Set('StripePublishableKey', $publishableKey);
        $this->Set('StripeSecretKey', $secretKey);
    }
}