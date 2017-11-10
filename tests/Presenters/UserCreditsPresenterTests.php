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

require_once(ROOT_DIR . 'Presenters/Credits/UserCreditsPresenter.php');

class UserCreditsPresenterTests extends TestBase
{
    /**
     * @var FakeUserCreditsPage
     */
    private $page;
    /**
     * @var FakeUserRepository
     */
    private $userRepository;
    /**
     * @var FakePaymentRepository
     */
    private $paymentRepository;
    /**
     * @var UserCreditsPresenter
     */
    private $presenter;

    public function setup()
    {
        parent::setup();

        $this->page = new FakeUserCreditsPage();
        $this->userRepository = new FakeUserRepository();
        $this->paymentRepository = new FakePaymentRepository();
        $this->presenter = new UserCreditsPresenter($this->page, $this->userRepository, $this->paymentRepository);
    }

    public function testPageLoadsWithCurrentCredits()
    {
        $currentCredits = 10.5;
        $this->userRepository->_User = new FakeUser();
        $this->userRepository->_User->WithCredits($currentCredits);
        $this->paymentRepository->_PayPal = new PayPalGateway(true, 'client', 'secret', 'live');
        $this->paymentRepository->_Stripe = new StripeGateway(true, 'publish', 'secret');

        $this->presenter->PageLoad($this->fakeUser);

        $this->assertEquals($currentCredits, $this->page->_CurrentCredits);
        $this->assertEquals(true, $this->page->_PayPalEnabled);
        $this->assertEquals('client', $this->page->_PayPalClientId);
        $this->assertEquals('live', $this->page->_PayPalEnvironment);
        $this->assertEquals(true, $this->page->_StripeEnabled);
        $this->assertEquals('publish', $this->page->_StripePublishableKey);
    }

    public function testCreatesPayPalPayment()
    {
        $this->fakeServer->SetSession(SessionKeys::CREDIT_CART, new CreditCart());
        $this->presenter->CreatePayPalPayment();
    }
//    public function testSavesPayPalResult()
//    {
//        $this->page->_PaymentResult = "{\"id\":\"PAY-1WW82131WF352133WLH4QOUQ\",\"intent\":\"sale\",\"state\":\"approved\",\"cart\":\"5FD72329MG139642M\",\"create_time\":\"2017-10-31T23:29:38Z\",\"payer\":{\"payment_method\":\"paypal\",\"status\":\"VERIFIED\",\"payer_info\":{\"email\":\"lqqkout13-buyer@aol.com\",\"first_name\":\"test\",\"middle_name\":\"test\",\"last_name\":\"buyer\",\"payer_id\":\"3GTAL5H4LTHV6\",\"country_code\":\"US\",\"shipping_address\":{\"recipient_name\":\"test buyer\",\"line1\":\"1 Main St\",\"city\":\"San Jose\",\"state\":\"CA\",\"postal_code\":\"95131\",\"country_code\":\"US\"}}},\"transactions\":[{\"amount\":{\"total\":\"1.00\",\"currency\":\"USD\",\"details\":{}},\"item_list\":{},\"related_resources\":[{\"sale\":{\"id\":\"57031264LU207192J\",\"state\":\"completed\",\"payment_mode\":\"INSTANT_TRANSFER\",\"protection_eligibility\":\"ELIGIBLE\",\"parent_payment\":\"PAY-1WW82131WF352133WLH4QOUQ\",\"create_time\":\"2017-10-31T23:29:38Z\",\"update_time\":\"2017-10-31T23:29:38Z\",\"amount\":{\"total\":\"1.00\",\"currency\":\"USD\",\"details\":{\"subtotal\":\"1.00\"}}}}]}]}";
//        $this->presenter->SavePaypalResult();
//
//        $this->assertEquals(PayPalPaymentResult::FromJsonString($this->page->_PaymentResult), $this->paymentRepository->_LastSavedPayPalResult);
//    }
}

class FakeUserCreditsPage extends UserCreditsPage
{
    public $_CurrentCredits;
    public $_PayPalEnabled;
    public $_PayPalClientId;
    public $_PayPalEnvironment;
    public $_StripeEnabled;
    public $_StripePublishableKey;
    public $_PaymentResult;

    public function SetCurrentCredits($credits)
    {
        $this->_CurrentCredits = $credits;
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

    public function GetPaymentResult()
    {
        return $this->_PaymentResult;
    }
}