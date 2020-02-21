<?php
/**
 * Copyright 2017-2020 Nick Korbel
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
    /**
     * @var FakeCreditRepository
     */
    private $creditRepository;

    public function setUp(): void
    {
        parent::setup();

        $this->page = new FakeUserCreditsPage();
        $this->userRepository = new FakeUserRepository();
        $this->paymentRepository = new FakePaymentRepository();
        $this->creditRepository = new FakeCreditRepository();

        $this->presenter = new UserCreditsPresenter($this->page,
            $this->userRepository,
            $this->paymentRepository,
            $this->creditRepository);
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

    public function testGetCreditLog()
    {
        $this->page->_CurrentPage = 10;
        $this->page->_PageSize = 50;

        $this->creditRepository->_UserCredits = new PageableData(array(new CreditLogView(Date::Now(), 'note', 10, 15)));

        $this->presenter->GetCreditLog($this->fakeUser);

        $this->assertEquals($this->creditRepository->_UserCredits, $this->page->_CreditLog);
        $this->assertEquals(10, $this->creditRepository->_LastPage);
        $this->assertEquals(50, $this->creditRepository->_LastPageSize);
        $this->assertEquals($this->fakeUser->UserId, $this->creditRepository->_LastUserId);
    }

    public function testGetTransactionLog()
    {
        $this->page->_CurrentPage = 10;
        $this->page->_PageSize = 50;

        $this->paymentRepository->_TransactionLogs = new PageableData(array(
            new TransactionLogView(
                Date::Now(),
                'status',
                'invoice',
                'txid',
                10.6,
                .33,
                'USD',
                'selfref',
                'refundref',
                'gatewaydate',
                'PayPal',
                10)
        ));

        $this->presenter->GetTransactionLog($this->fakeUser);

        $this->assertEquals($this->paymentRepository->_TransactionLogs, $this->page->_TransactionLog);
        $this->assertEquals(10, $this->paymentRepository->_LastPage);
        $this->assertEquals(50, $this->paymentRepository->_LastPageSize);
        $this->assertEquals($this->fakeUser->UserId, $this->paymentRepository->_LastUserId);
    }
}

class FakeUserCreditsPage extends UserCreditsPage
{
    public $_CurrentCredits;
    public $_PaymentResult;
    public $_CreditCost;
    public $_CurrentPage;
    public $_PageSize;
    public $_CreditLog;
    public $_TransactionLog;

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

    public function GetPageNumber()
    {
        return $this->_CurrentPage;
    }

    public function GetPageSize()
    {
        return $this->_PageSize;
    }

    public function BindCreditLog($creditLog)
    {
        $this->_CreditLog = $creditLog;
    }

    public function BindTransactionLog($transactionLog)
    {
        $this->_TransactionLog = $transactionLog;
    }
}