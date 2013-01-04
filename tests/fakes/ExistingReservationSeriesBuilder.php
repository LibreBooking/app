<?php
/**
Copyright 2011-2013 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

class ExistingReservationSeriesBuilder
{
	/**
	 * @var TestHelperExistingReservationSeries
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
	
	private $requiresNewSeries = false;
	
	public function __construct()
	{
		$series = new ExistingReservationSeries();
		
		$this->currentInstance = new Reservation($series, new DateRange(Date::Now(), Date::Now()));
		$this->repeatOptions = new RepeatNone();
		$this->instances = array();
		$this->events = array();
		
		$series->WithDescription('description');
		$series->WithOwner(1);
		$this->resource = new FakeBookableResource(2);
		$series->WithResource(new FakeBookableResource(3));
		$series->WithTitle('title');
		$series->WithStatus(ReservationStatus::Created);
		
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
	 * @return ExistingReservationSeries
	 */
	public function Build()
	{
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

	public function __construct()
	{
	    $this->WithPrimaryResource(new FakeBookableResource(2));
		$this->WithResource(new FakeBookableResource(3));
		$this->WithBookedBy(new FakeUserSession());
		$this->WithStatus(ReservationStatus::Created);
	}

	public function AddEvent($event)
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

	private function WithBookedBy($bookedBy)
	{
		$this->_bookedBy = $bookedBy;
	}
}
?>