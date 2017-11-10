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

require_once(ROOT_DIR . 'Presenters/Admin/ManagePaymentsPresenter.php');

class ManagePaymentsPresenterTests extends TestBase
{
    /**
     * @var FakeManagePaymentsPage
     */
    private $page;
    /**
     * @var ManagePaymentsPresenter
     */
    private $presenter;
    /**
     * @var FakePaymentRepository
     */
    private $paymentRepository;

    public function setup()
    {
        parent::setup();

        $this->page = new FakeManagePaymentsPage();
        $this->paymentRepository = new FakePaymentRepository();
        $this->presenter = new ManagePaymentsPresenter($this->page, $this->paymentRepository);
    }

    public function testPageLoadSetsCurrentCreditValues()
    {
        $creditCost = new CreditCost(44.4, 'USD');
        $this->paymentRepository->_CreditCost = $creditCost;

        $this->presenter->PageLoad();

        $this->assertEquals($creditCost->Cost(), $this->page->_CreditCost);
        $this->assertEquals($creditCost->Currency(), $this->page->_CreditCurrency);
    }

    public function testPageLoadSetsGatewayValues()
    {
        $paypalGateway = new PayPalGateway(true, 'client', 'secret', 'environment');
        $stripeGateway = new StripeGateway(true, 'publishable', 'secret');

        $this->paymentRepository->_PayPal = $paypalGateway;
        $this->paymentRepository->_Stripe = $stripeGateway;

        $this->presenter->PageLoad();

        $this->assertEquals($paypalGateway->IsEnabled(), $this->page->_PayPalEnabled);
        $this->assertEquals($paypalGateway->ClientId(), $this->page->_PayPalClientId);
        $this->assertEquals($paypalGateway->Secret(), $this->page->_PayPalSecret);
        $this->assertEquals($paypalGateway->Environment(), $this->page->_PayPalEnvironment);

        $this->assertEquals($stripeGateway->IsEnabled(), $this->page->_StripeEnabled);
        $this->assertEquals($stripeGateway->PublishableKey(), $this->page->_StripePublishableKey);
        $this->assertEquals($stripeGateway->SecretKey(), $this->page->_StripeSecretKey);
    }

    public function testSettingCreditCost()
    {
        $this->page->_CreditCost = 30.5;
        $this->page->_CreditCurrency = 'USD';

        $this->presenter->UpdateCreditCost();

        $this->assertEquals(new CreditCost($this->page->_CreditCost, $this->page->_CreditCurrency), $this->paymentRepository->_LastCost);
    }

    public function testUpdatesPaymentGateways()
    {
        $this->page->_PayPalEnabled = true;
        $this->page->_PayPalClientId = 'clientid';
        $this->page->_PayPalSecret = 'secret';
        $this->page->_PayPalEnvironment = 'sandbox';
        $this->page->_StripeEnabled = false;
        $this->page->_StripePublishableKey = 'something to erase';
        $this->page->_StripeSecretKey = 'something else to erase';

        $this->presenter->UpdatePaymentGateways();

        $paypalGateway = new PayPalGateway($this->page->_PayPalEnabled, $this->page->_PayPalClientId, $this->page->_PayPalSecret, $this->page->_PayPalEnvironment);
        $stripeGateway = new StripeGateway($this->page->_StripeEnabled, $this->page->_StripePublishableKey, $this->page->_StripeSecretKey);
        $this->assertEquals($paypalGateway, $this->paymentRepository->_LastPayPal);
        $this->assertEquals($stripeGateway, $this->paymentRepository->_LastStripe);
    }
}

class FakeManagePaymentsPage extends ManagePaymentsPage
{
    public $_CreditCost;
    public $_CreditCurrency;
    public $_PayPalEnabled;
    public $_PayPalClientId;
    public $_PayPalSecret;
    public $_PayPalEnvironment;
    public $_StripeEnabled;
    public $_StripePublishableKey;
    public $_StripeSecretKey;

    public function __construct()
    {
        parent::__construct();
    }

    public function GetCreditCost()
    {
        return $this->_CreditCost;
    }

    public function GetCreditCurrency()
    {
        return $this->_CreditCurrency;
    }

    public function SetCreditCost($cost, $currency)
    {
        $this->_CreditCost = $cost;
        $this->_CreditCurrency = $currency;
    }

    public function GetPayPalIsEnabled()
    {
        return $this->_PayPalEnabled;
    }

    public function GetPayPalClientId()
    {
        return $this->_PayPalClientId;
    }

    public function GetPayPalSecret()
    {
        return $this->_PayPalSecret;
    }

    public function GetPayPalEnvironment()
    {
        return $this->_PayPalEnvironment;
    }

    public function GetStripeIsEnabled()
    {
        return $this->_StripeEnabled;
    }

    public function GetStripePublishableKey()
    {
        return $this->_StripePublishableKey;
    }

    public function GetStripeSecretKey()
    {
        return $this->_StripeSecretKey;
    }

    public function SetPayPalSettings($enabled, $clientId, $secret, $environment)
    {
        $this->_PayPalEnabled = $enabled;
        $this->_PayPalClientId = $clientId;
        $this->_PayPalSecret = $secret;
        $this->_PayPalEnvironment = $environment;
    }

    public function SetStripeSettings($enabled, $publishableKey, $secretKey)
    {
        $this->_StripeEnabled = $enabled;
        $this->_StripePublishableKey = $publishableKey;
        $this->_StripeSecretKey = $secretKey;
    }
}