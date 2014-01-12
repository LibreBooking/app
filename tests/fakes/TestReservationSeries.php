<?php
/**
Copyright 2011-2014 Nick Korbel

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

require_once ROOT_DIR . '/Domain/namespace.php';

class TestReservationSeries extends ReservationSeries
{
    private $_scheduleId;

	public function __construct()
	{
		parent::__construct();
		$this->_bookedBy = new FakeUserSession();
	}

	public function WithOwnerId($ownerId)
	{
		$this->_userId = $ownerId;
	}

	public function WithResource(BookableResource $resource)
	{
		$this->_resource = $resource;
	}

	public function WithDuration(DateRange $duration)
	{
		$this->UpdateDuration($duration);
	}

	public function WithRepeatOptions(IRepeatOptions $repeatOptions)
	{
		$this->Repeats($repeatOptions);
	}

	public function WithCurrentInstance(Reservation $currentInstance)
	{
		$this->SetCurrentInstance($currentInstance);
		$this->AddInstance($currentInstance);
	}

	public function WithBookedBy($bookedBy)
	{
		$this->_bookedBy = $bookedBy;
	}

	public function WithAccessory(ReservationAccessory $accessory)
	{
		$this->AddAccessory($accessory);
	}

	public function WithInstanceOn(DateRange $dateRange)
	{
		$this->AddNewInstance($dateRange);
	}

    public function WithScheduleId($scheudleId)
    {
        $this->_scheduleId = $scheudleId;
    }

    public function ScheduleId()
    {
        if (!empty($this->_scheduleId))
        {
            return $this->_scheduleId;
        }

        return parent::ScheduleId();
    }

	/**
	 * @param $attributeValue AttributeValue
	 */
	public function WithAttributeValue($attributeValue)
	{
		$this->AddAttributeValue($attributeValue);
	}
}