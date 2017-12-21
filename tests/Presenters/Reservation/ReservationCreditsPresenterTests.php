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

require_once(ROOT_DIR . 'Presenters/Reservation/ReservationCreditsPresenter.php');

class ReservationCreditsPresenterTests extends TestBase
{
    /**
     * @var FakeReservationCreditsPage
     */
    private $page;
    /**
     * @var ReservationCreditsPresenter
     */
    private $presenter;

    public function setup()
    {
        parent::setup();

        $this->page = new FakeReservationCreditsPage();
        $this->presenter = new ReservationCreditsPresenter($this->page, $this->repository);
    }

    public function testReturnsNumberOfCreditsConsumedForNewReservation()
    {
        $this->
        $this->presenter->PageLoad($this->fakeUser);

        $this->assertEquals(10, $this->page->_CreditsConsumed);
    }
    
    public function testReturnsNumberOfCreditsConsumedForExistingReservation()
    {
        
    }
}

class FakeReservationCreditsPage implements IReservationCreditsPage
{

    /**
     * @return string
     */
    public function GetRepeatType()
    {
        // TODO: Implement GetRepeatType() method.
    }

    /**
     * @return string|null
     */
    public function GetRepeatInterval()
    {
        // TODO: Implement GetRepeatInterval() method.
    }

    /**
     * @return int[]|null
     */
    public function GetRepeatWeekdays()
    {
        // TODO: Implement GetRepeatWeekdays() method.
    }

    /**
     * @return string|null
     */
    public function GetRepeatMonthlyType()
    {
        // TODO: Implement GetRepeatMonthlyType() method.
    }

    /**
     * @return string|null
     */
    public function GetRepeatTerminationDate()
    {
        // TODO: Implement GetRepeatTerminationDate() method.
    }

    /**
     * @return int
     */
    public function GetUserId()
    {
        // TODO: Implement GetUserId() method.
    }

    /**
     * @return int
     */
    public function GetResourceId()
    {
        // TODO: Implement GetResourceId() method.
    }

    /**
     * @return string
     */
    public function GetStartDate()
    {
        // TODO: Implement GetStartDate() method.
    }

    /**
     * @return string
     */
    public function GetEndDate()
    {
        // TODO: Implement GetEndDate() method.
    }

    /**
     * @return string
     */
    public function GetStartTime()
    {
        // TODO: Implement GetStartTime() method.
    }

    /**
     * @return string
     */
    public function GetEndTime()
    {
        // TODO: Implement GetEndTime() method.
    }

    /**
     * @return int[]
     */
    public function GetResources()
    {
        // TODO: Implement GetResources() method.
    }
}