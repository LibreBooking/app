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
    public function SetCurrentCredits($credits);
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
        $this->Set('PayPalEnvironment', Configuration::Instance()->GetSectionKey(ConfigSection::PAYMENTS, ConfigKeys::PAYPAL_ENVIRONMENT));
        $this->Set('PayPalClientId', Configuration::Instance()->GetSectionKey(ConfigSection::PAYMENTS, ConfigKeys::PAYPAL_CLIENT_ID));

        $this->presenter = new UserCreditsPresenter($this, new UserRepository());
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
        $this->Display('Credits/user-credits.tpl');
    }

    public function SetCurrentCredits($credits)
    {
        $this->Set('CurrentCredits', $credits);
    }
}