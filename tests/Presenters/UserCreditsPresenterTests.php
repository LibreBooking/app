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

    public function testPageLoad()
    {
        $currentCredits = 10.5;
        $this->userRepository->_User = new FakeUser();
        $this->userRepository->_User->WithCredits($currentCredits);
        $this->paymentRepository->_CreditCost = new CreditCost('10.11');

        $this->presenter->PageLoad($this->fakeUser);

        $this->assertEquals($currentCredits, $this->page->_CurrentCredits);
    }
}

class FakeUserCreditsPage extends UserCreditsPage
{
    public $_CurrentCredits;
    public $_PaymentResult;
    public $_CreditCost;

    public function SetCurrentCredits($credits)
    {
        $this->_CurrentCredits = $credits;
    }

    public function GetPaymentResult()
    {
        return $this->_PaymentResult;
    }

    public function SetCreditCost(CreditCost $cost)
    {
        $this->_CreditCost = $cost;
    }
}