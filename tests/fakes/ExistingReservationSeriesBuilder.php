<?php
/**
Copyright 2011-2020 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

class ExistingReservationSeriesBuilder
{
	/**
	 * @var ExistingReservationSeries
	 */
	public $series;

	/**
	 * @var Reservation
	 */
	public $currentInstance;

	/**
	 * @var IRepeatOptions
	 */
	private $repeatOptions;

	/**
	 * @var BookableResource
	 */
	private $resource;

	private $instances;
	private $events;
    private $id = 1;

	private $bookedBy;

	private $requiresNewSeries = false;
	/**
	 * @var ReservationAccessory[]
	 */
	private $accessories = [];

	public function __construct()
	{
		$series = new ExistingReservationSeries();

		$this->currentInstance = new Reservation($series, new DateRange(Date::Now()->AddMinutes(30), Date::Now()->AddMinutes(60)));
		$this->repeatOptions = new RepeatNone();
		$this->instances = array();
		$this->events = array();

		$series->WithDescription('description');
		$series->WithOwner(1);
		$this->resource = new FakeBookableResource(2);
		$series->WithResource(new FakeBookableResource(3));
		$series->WithTitle('title');
		$series->WithStatus(ReservationStatus::Created);

		$this->bookedBy = new FakeUserSession();
		$this->series = $series;
	}

    /**
     * @param int $id
     * @return ExistingReservationSeriesBuilder
     */
    public function WithId($id)
    {
        $this->id = $id;

        return $this;
    }

	/**
	 * @param Reservation $reservation
	 * @return ExistingReservationSeriesBuilder
	 */
	public function WithCurrentInstance($reservation)
	{
		$this->currentInstance = $reservation;

		return $this;
	}

	public function WithBookedBy(UserSession $user)
	{
		$this->bookedBy = $user;

		return $this;
	}

	/**
	 * @return ExistingReservationSeriesBuilder
	 */
	public function WithRepeatOptions(IRepeatOptions $repeatOptions)
	{
		$this->repeatOptions = $repeatOptions;

		return $this;
	}

	/**
	 * @param Reservation $reservation
	 * @return ExistingReservationSeriesBuilder
	 */
	public function WithInstance($reservation)
	{
		$this->instances[] = $reservation;

		return $this;
	}

	/**
	 * @return ExistingReservationSeriesBuilder
	 */
	public function WithEvent($event)
	{
		$this->events[] = $event;

		return $this;
	}

	/**
	 * @return ExistingReservationSeriesBuilder
	 */
	public function WithRequiresNewSeries($requiresNewSeries)
	{
		$this->requiresNewSeries = $requiresNewSeries;

		return $this;
	}

	/**
	 * @param BookableResource $resource
	 * @return ExistingReservationSeriesBuilder
	 */
	public function WithPrimaryResource(BookableResource $resource)
	{
		$this->resource = $resource;

		return $this;
	}

	/**
	 * @param BookableResource[] $resources
	 * @return ExistingReservationSeriesBuilder
	 */
	public function WithResources($resources)
	{
		$this->resources = $resources;

		return $this;
	}

	public function WithAccessory($accessory) {
		$this->accessories[] = $accessory;
	}

	/**
	 * @return ExistingReservationSeries
	 */
	public function Build()
	{
        $this->series->UpdateBookedBy($this->bookedBy);
        $this->series->WithId($this->id);
		$this->series->WithCurrentInstance($this->currentInstance);
		$this->series->WithRepeatOptions($this->repeatOptions);

		foreach ($this->instances as $reservation)
		{
			$this->series->WithInstance($reservation);
		}

		foreach ($this->events as $event)
		{
			$this->series->AddEvent($event);
		}

		$this->series->WithPrimaryResource($this->resource);
		$this->series->WithTitle('title');
		$this->series->WithDescription('description');
		foreach($this->accessories as $a)
		{
			$this->series->WithAccessory($a);
		}
//		$this->series->Update(1, $this->resource, 'title', 'description', $this->bookedBy);

		return $this->series;
	}

	/**
	 * @return TestHelperExistingReservationSeries
	 */
	public function BuildTestVersion()
	{
		$this->series = new TestHelperExistingReservationSeries();
		$this->Build();
		$this->series->SetRequiresNewSeries($this->requiresNewSeries);

		return $this->series;
	}
}

class TestHelperExistingReservationSeries extends ExistingReservationSeries
{
	public $requiresNewSeries = false;
	public $_creditsConsumed = 0;

	public $_WasDeleted = false;

    public $_DeleteReason;
    public $_WasCheckedIn = false;
    public $_CheckedInBy;

    public function __construct()
	{
		parent::__construct();
	    $this->WithPrimaryResource(new FakeBookableResource(2));
		$this->WithResource(new FakeBookableResource(3));
		$this->WithBookedBy(new FakeUserSession());
		$this->WithStatus(ReservationStatus::Created);
	}

	public function AddEvent(SeriesEvent $event)
	{
		parent::AddEvent($event);
	}

	public function SetRequiresNewSeries($requiresNewSeries)
	{
		$this->requiresNewSeries = $requiresNewSeries;
	}

	public function RequiresNewSeries()
	{
		return $this->requiresNewSeries;
	}

	public function Instances()
	{
		return $this->instances;
	}

	public function WithBookedBy($bookedBy)
	{
		$this->_bookedBy = $bookedBy;
	}

	/**
	 * @param int $credits
	 */
	public function TestSetCreditsConsumed($credits)
	{
		$this->_creditsConsumed = $credits;
	}

	public function GetCreditsConsumed()
	{
		return $this->_creditsConsumed;
	}

	public function Delete(UserSession $deletedBy, $reason = '')
	{
		$this->_WasDeleted = true;
		$this->_DeleteReason = $reason;
		parent::Delete($deletedBy);
	}

	public function Checkin(UserSession $checkedInBy)
    {
       $this->_WasCheckedIn = true;
       $this->_CheckedInBy = $checkedInBy;
    }

    public function WithUnusedCreditBalance($balance) {
		$this->unusedCreditBalance = $balance;
	}
}