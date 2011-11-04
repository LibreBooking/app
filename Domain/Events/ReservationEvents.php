<?php

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
?>