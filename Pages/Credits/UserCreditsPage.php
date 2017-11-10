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

require_once(ROOT_DIR . 'Pages/SecurePage.php');

interface IUserCreditsPage extends IPage, IActionPage
{
    /**
     * @param int $credits
     */
    public function SetCurrentCredits($credits);

    /**
     * @param bool $enabled
     * @param string $clientId
     * @param string $environment
     */
    public function SetPayPalSettings($enabled, $clientId, $environment);

    /**
     * @param string $enabled
     * @param string $publishableKey
     */
    public function SetStripeSettings($enabled, $publishableKey);

    /**
     * @return string
     */
    public function GetPaymentResult();

    public function SetPayPalPaymentResult();
}

class UserCreditsPage extends ActionPage implements IUserCreditsPage
{
    /**
     * @var UserCreditsPresenter
     */
    private $presenter;

    public function __construct()
    {
        parent::__construct('Credits');
        $this->Set('AllowPurchasingCredits', Configuration::Instance()->GetSectionKey(ConfigSection::CREDITS, ConfigKeys::CREDITS_ALLOW_PURCHASE, new BooleanConverter()));

        $this->presenter = new UserCreditsPresenter($this, new UserRepository(), new PaymentRepository());
    }

    public function ProcessAction()
    {
       $this->presenter->ProcessAction();
    }

    public function ProcessDataRequest($dataRequest)
    {
        // no-op
    }

    public function ProcessPageLoad()
    {
        $this->presenter->PageLoad(ServiceLocator::GetServer()->GetUserSession());
        $this->Display('Credits/user_credits.tpl');
    }

    public function SetCurrentCredits($credits)
    {
        $this->Set('CurrentCredits', $credits);
    }

    public function SetPayPalSettings($enabled, $clientId, $environment)
    {
       $this->Set('PayPalEnabled', $enabled);
       $this->Set('PayPalClientId', $clientId);
       $this->Set('PayPalEnvironment', $environment);
    }

    public function SetStripeSettings($enabled, $publishableKey)
    {
        $this->Set('StripeEnabled', $enabled);
        $this->Set('StripePublishableKey', $publishableKey);
    }

    public function GetPaymentResult()
    {
       return $this->GetForm(FormKeys::PAYMENT_RESPONSE_DATA);
    }

    public function SetPayPalPaymentResult()
    {
        $this->SetJson("foo");
    }
}