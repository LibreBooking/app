<?php
/**
Copyright 2011-2012 Nick Korbel

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


class SeriesEventPriority
{
	const Highest = 10;
	const High = 7;
	const Normal = 5;
	const Low = 3;
	const Lowest = 1;

}
abstract class SeriesEvent
{
	/**
	 * @var int
	 */
	private $priority;

	/**
	 * @var \ReservationSeries
	 */
	protected $series;

	/**
	 * @var string
	 */
	protected $id;

	/**
	 * @param int|SeriesEventPriority $priority
	 * @return void
	 */
	protected function SetPriority($priority)
	{
		$this->priority = $priority;
	}

	/**
	 * @return int|SeriesEventPriority
	 */
	public function GetPriority()
	{
		return $this->priority;
	}

	/**
	 * @return ReservationSeries
	 */
	public function Series()
	{
		return $this->series;
	}

	/**
	 * @return int
	 */
	public function SeriesId()
	{
		return $this->series->SeriesId();
	}

	/**
	 * @param ReservationSeries $series
	 * @param int|SeriesEventPriority $priority
	 */
	public function __construct(ReservationSeries $series, $priority = SeriesEventPriority::Normal)
	{
		$this->priority = $priority;
		$this->series = $series;
		$this->id = $this->series->SeriesId();
	}

	public function __toString()
	{
		return sprintf("%s-%s", get_class($this), $this->id);
	}

	public static function Compare(SeriesEvent $event1, SeriesEvent $event2)
	{
		if ($event1->GetPriority() == $event2->GetPriority())
		{
			return 0;
		}

		// higher priority should be at the top
		return ($event1->GetPriority() > $event2->GetPriority()) ? -1 : 1;
	}
}

class InstanceAddedEvent extends SeriesEvent
{
	/**
	 * @var Reservation
	 */
	private $instance;

	/**
	 * @return Reservation
	 */
	public function Instance()
	{
		return $this->instance;
	}

	public function __construct(Reservation $reservationInstance, ExistingReservationSeries $series)
	{
		$this->instance = $reservationInstance;
		parent::__construct($series, SeriesEventPriority::Lowest);
	}

	public function __toString()
	{
        return sprintf("%s%s", get_class($this), $this->instance->ReferenceNumber());
    }
}

class InstanceRemovedEvent extends SeriesEvent
{
	/**
	 * @var Reservation
	 */
	private $instance;

	/**
	 * @return Reservation
	 */
	public function Instance()
	{
		return $this->instance;
	}

	public function __construct(Reservation $reservationInstance, ExistingReservationSeries $series)
	{
		$this->instance = $reservationInstance;
		parent::__construct($series, SeriesEventPriority::Highest);
	}

	public function __toString()
	{
        return sprintf("%s%s", get_class($this), $this->instance->ReferenceNumber());
    }
}

class InstanceUpdatedEvent extends SeriesEvent
{
	/**
	 * @var Reservation
	 */
	private $instance;

	/**
	 * @return Reservation
	 */
	public function Instance()
	{
		return $this->instance;
	}

	public function __construct(Reservation $reservationInstance, ExistingReservationSeries $series)
	{
		$this->instance = $reservationInstance;
		parent::__construct($series, SeriesEventPriority::Low);
	}

	public function __toString()
	{
        return sprintf("%s%s", get_class($this), $this->instance->ReferenceNumber());
    }
}

class SeriesBranchedEvent extends SeriesEvent
{
	public function __construct(ReservationSeries $series)
	{
		parent::__construct($series);
	}

	public function __toString()
	{
        return sprintf("%s%s", get_class($this), $this->series->SeriesId());
    }
}

class SeriesDeletedEvent extends SeriesEvent
{
	public function __construct(ExistingReservationSeries $series)
	{
		parent::__construct($series, SeriesEventPriority::Highest);
	}

	/**
	 * @return ExistingReservationSeries
	 */
	public function Series()
	{
		return $this->series;
	}

	public function __toString()
	{
        return sprintf("%s%s", get_class($this), $this->series->SeriesId());
    }
}

class ResourceRemovedEvent extends SeriesEvent
{
	/**
	 * @var BookableResource
	 */
	private $resource;

	public function __construct(BookableResource $resource, ExistingReservationSeries $series)
	{
		$this->resource = $resource;

		parent::__construct($series, SeriesEventPriority::Highest);
	}

	/**
	 * @return BookableResource
	 */
	public function Resource()
	{
		return $this->resource;
	}

	/**
	 * @return int
	 */
	public function ResourceId()
	{
		return $this->resource->GetResourceId();
	}

	/**
	 * @return ExistingReservationSeries
	 */
	public function Series()
	{
		return $this->series;
	}

	public function __toString()
	{
        return sprintf("%s%s%s", get_class($this), $this->ResourceId(), $this->series->SeriesId());
    }
}

class ResourceAddedEvent extends SeriesEvent
{
	/**
	 * @var BookableResource
	 */
	private $resource;

	/**
	 * @var int|ResourceLevel
	 */
	private $resourceLevel;

	/**
	 * @param BookableResource $resource
	 * @param int|ResourceLevel $resourceLevel
	 * @param ExistingReservationSeries $series
	 */
	public function __construct(BookableResource $resource, $resourceLevel, ExistingReservationSeries $series)
	{
		$this->resource = $resource;
		$this->resourceLevel = $resourceLevel;

		parent::__construct($series, SeriesEventPriority::Low);
	}

	/**
	 * @return BookableResource
	 */
	public function Resource()
	{
		return $this->resource;
	}

	public function ResourceId()
	{
		return $this->resource->GetResourceId();
	}

	/**
	 * @return ExistingReservationSeries
	 */
	public function Series()
	{
		return $this->series;
	}

	public function __toString()
	{
        return sprintf("%s%s%s", get_class($this), $this->ResourceId(), $this->series->SeriesId());
    }

	public function ResourceLevel()
	{
		return $this->resourceLevel;
	}
}

class SeriesApprovedEvent extends SeriesEvent
{
	public function __construct(ExistingReservationSeries $series)
	{
		parent::__construct($series);
	}

	public function __toString()
	{
        return sprintf("%s%s", get_class($this),  $this->series->SeriesId());
    }
}

class AccessoryAddedEvent extends SeriesEvent
{
	/**
	 * @return int
	 */
	public function AccessoryId()
	{
		return $this->accessory->AccessoryId;
	}

	/**
	 * @return int
	 */
	public function Quantity()
	{
		return $this->accessory->QuantityReserved;
	}

	/**
	 * @var \ReservationAccessory
	 */
	private $accessory;

	public function __construct(ReservationAccessory $accessory, ExistingReservationSeries $series)
	{
		$this->accessory = $accessory;

		parent::__construct($series, SeriesEventPriority::Low);
	}

	public function __toString()
	{
        return sprintf("%s%s", get_class($this), $this->accessory->__toString());
    }
}

class AccessoryRemovedEvent extends SeriesEvent
{
	/**
	 * @return int
	 */
	public function AccessoryId()
	{
		return $this->accessory->AccessoryId;
	}

	/**
	 * @var \ReservationAccessory
	 */
	private $accessory;

	public function __construct(ReservationAccessory $accessory, ExistingReservationSeries $series)
	{
		$this->accessory = $accessory;

		parent::__construct($series, SeriesEventPriority::Highest);
	}

	public function __toString()
	{
        return sprintf("%s%s", get_class($this), $this->accessory->__toString());
    }
}

class OwnerChangedEvent extends SeriesEvent
{
    /**
     * @var int
     */
    private $oldOwnerId;

    /**
     * @var int
     */
    private $newOwnerId;

    /**
     * @param ExistingReservationSeries $series
     * @param int $oldOwnerId
     * @param int $newOwnerId
     */
    public function __construct(ExistingReservationSeries $series, $oldOwnerId, $newOwnerId)
    {
        $this->series = $series;
        $this->oldOwnerId = $oldOwnerId;
        $this->newOwnerId = $newOwnerId;
    }
    /**
     * @return ExistingReservationSeries
     */
    public function Series()
    {
        return $this->series;
    }

    /**
     * @return int
     */
    public function OldOwnerId()
    {
        return $this->oldOwnerId;
    }

    /**
     * @return int
     */
    public function NewOwnerId()
    {
        return $this->newOwnerId;
    }

    public function __toString()
    {
        return sprintf("%s%s%s%s", get_class($this), $this->OldOwnerId(), $this->NewOwnerId(), $this->series->SeriesId());
    }
}
?>