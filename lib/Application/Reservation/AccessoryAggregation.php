<?php
/**
 * Copyright 2017-2018 Nick Korbel
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

class AccessoryAggregation
{
	private $knownAccessoryIds = array();
    /**
     * @var AccessoryAggregationTracker[]
     */
	private $trackers = array();

	/**
	 * @var \DateRange
	 */
	private $duration;

	/**
	 * @var string[]
	 */
	private $addedReservations = array();

	/**
	 * @param array|AccessoryToCheck[] $accessories
	 * @param DateRange $duration
	 */
	public function __construct($accessories, $duration)
	{
		foreach ($accessories as $a)
		{
            $this->knownAccessoryIds[$a->GetId()] = 1;
		}

		$this->duration = $duration;
	}

	/**
	 * @param AccessoryReservation $accessoryReservation
	 */
	public function Add(AccessoryReservation $accessoryReservation)
	{
		if ($accessoryReservation->GetStartDate()->Equals($this->duration->GetEnd()) || $accessoryReservation->GetEndDate()->Equals($this->duration->GetBegin()))
		{
			return;
		}

		$accessoryId = $accessoryReservation->GetAccessoryId();

		$key = $accessoryReservation->GetReferenceNumber() . $accessoryId;

		if (array_key_exists($key, $this->addedReservations))
		{
			return;
		}

		$this->addedReservations[$key] = true;

		if (array_key_exists($accessoryId, $this->knownAccessoryIds))
		{
            if ($this->ConflictsWithOtherReservations($accessoryReservation))
            {
                $this->AddQuantityToExistingTrackers($accessoryReservation);
            }
            else
            {
                $this->StartNewQuantityTracker($accessoryReservation);
            }
		}
	}

	/**
	 * @param int $accessoryId
	 * @return int
	 */
	public function GetQuantity($accessoryId)
	{
		$quantity = 0;

		foreach ($this->trackers as $tracker)
		{
            $q = $tracker->GetQuantity($accessoryId);
            if ($q > $quantity)
			{
				$quantity = $q;
			}
		}
		return $quantity;
	}

    private function ConflictsWithOtherReservations(AccessoryReservation $reservation)
    {
        foreach ($this->trackers as $tracker)
        {
            if ($tracker->Overlaps($reservation))
            {
                return true;
            }
        }

        return false;
    }

    private function AddQuantityToExistingTrackers(AccessoryReservation $accessoryReservation)
    {
        foreach ($this->trackers as $tracker)
        {
            if ($tracker->Overlaps($accessoryReservation))
            {
                $tracker->Add($accessoryReservation);
            }
        }
    }

    private function StartNewQuantityTracker(AccessoryReservation $accessoryReservation)
    {
        $this->trackers[] = new AccessoryAggregationTracker($accessoryReservation);
    }
}

class AccessoryAggregationTracker
{
    /** @var AccessoryReservation[] */
    private $reservations = array();
    /**
     * @var int
     */
    private $accessoryId;

    public function __construct(AccessoryReservation $accessoryReservation)
    {
        $this->reservations[] = $accessoryReservation;
        $this->accessoryId = $accessoryReservation->GetAccessoryId();
    }

    public function Overlaps(AccessoryReservation $reservation)
    {
        if ($reservation->GetAccessoryId() != $this->accessoryId)
        {
            return false;
        }

        foreach ($this->reservations as $r)
        {
            if ($reservation->GetDuration()->Overlaps($r->GetDuration()))
            {
                return true;
            }
        }

        return false;
    }

    public function Add(AccessoryReservation $accessoryReservation)
    {
        $this->reservations[] = $accessoryReservation;
    }

    public function GetQuantity($accessoryId)
    {
        if ($this->accessoryId != $accessoryId)
        {
            return 0;

        }
        $quantity = 0;
        foreach($this->reservations as $reservation)
        {
            $quantity += $reservation->QuantityReserved();
        }

        return $quantity;
    }
}