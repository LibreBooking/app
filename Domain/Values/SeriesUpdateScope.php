<?php
/**
Copyright 2011-2015 Nick Korbel

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

require_once(ROOT_DIR . 'Domain/Values/ReservationStartTimeConstraint.php');

class SeriesUpdateScope
{
	private function __construct()
	{
	}

	const ThisInstance = 'this';
	const FullSeries = 'full';
	const FutureInstances = 'future';

	public static function CreateStrategy($seriesUpdateScope)
	{
		switch ($seriesUpdateScope)
		{
			case SeriesUpdateScope::ThisInstance :
				return new SeriesUpdateScope_Instance();
				break;
			case SeriesUpdateScope::FullSeries :
				return new SeriesUpdateScope_Full();
				break;
			case SeriesUpdateScope::FutureInstances :
				return new SeriesUpdateScope_Future();
				break;
			default :
				throw new Exception('Unknown seriesUpdateScope requested');
		}
	}

	/**
	 * @param string $updateScope
	 * @return bool
	 */
	public static function IsValid($updateScope)
	{
		return $updateScope == SeriesUpdateScope::FullSeries ||
				$updateScope == SeriesUpdateScope::ThisInstance ||
				$updateScope == SeriesUpdateScope::FutureInstances;
	}
}

interface ISeriesUpdateScope
{
	/**
	 * @param ExistingReservationSeries $series
	 * @return Reservation[]
	 */
	function Instances($series);

	/**
	 * @return bool
	 */
	function RequiresNewSeries();

	/**
	 * @return string
	 */
	function GetScope();

	/**
	 * @param ExistingReservationSeries $series
	 * @return IRepeatOptions
	 */
	function GetRepeatOptions($series);

	/**
	 * @param ExistingReservationSeries $series
	 * @param IRepeatOptions $repeatOptions
	 * @return bool
	 */
	function CanChangeRepeatTo($series, $repeatOptions);

	/**
	 * @param ExistingReservationSeries $series
	 * @param Reservation $instance
	 * @return bool
	 */
	function ShouldInstanceBeRemoved($series, $instance);
}

abstract class SeriesUpdateScopeBase implements ISeriesUpdateScope
{
	/**
	 * @var ISeriesDistinction
	 */
	protected $series;

	protected function __construct()
	{
	}

	/**
	 * @param ExistingReservationSeries $series
	 * @param Date $compareDate
	 * @return array
	 */
	protected function AllInstancesGreaterThan($series, $compareDate)
	{
		$instances = array();
		foreach ($series->_Instances() as $instance)
		{
			if ($compareDate == null || $instance->StartDate()->Compare($compareDate) >= 0)
			{
				$instances[] = $instance;
			}
		}

		return $instances;
	}

	protected abstract function EarliestDateToKeep($series);

	public function GetRepeatOptions($series)
	{
		return $series->RepeatOptions();
	}

	/**
	 * @param ReservationSeries $series
	 * @param IRepeatOptions $targetRepeatOptions
	 * @return bool
	 */
	public function CanChangeRepeatTo($series, $targetRepeatOptions)
	{
		return !$targetRepeatOptions->Equals($series->RepeatOptions());
	}

	public function ShouldInstanceBeRemoved($series, $instance)
	{
		return $instance->StartDate()->GreaterThan($this->EarliestDateToKeep($series));
	}
}

class SeriesUpdateScope_Instance extends SeriesUpdateScopeBase
{
	public function __construct()
	{
		parent::__construct();
	}

	public function GetScope()
	{
		return SeriesUpdateScope::ThisInstance;
	}

	public function Instances($series)
	{
		return array($series->CurrentInstance());
	}

	public function RequiresNewSeries()
	{
		return true;
	}

	public function EarliestDateToKeep($series)
	{
		return $series->CurrentInstance()->StartDate();
	}

	public function GetRepeatOptions($series)
	{
		return new RepeatNone();
	}

	public function CanChangeRepeatTo($series, $targetRepeatOptions)
	{
		return $targetRepeatOptions->Equals(new RepeatNone());
	}

	public function ShouldInstanceBeRemoved($series, $instance)
	{
		return false;
	}
}

class SeriesUpdateScope_Full extends SeriesUpdateScopeBase
{
	private $hasSameConfiguration = false;

	public function __construct()
	{
		parent::__construct();
	}

	public function GetScope()
	{
		return SeriesUpdateScope::FullSeries;
	}

	/**
	 * @param ExistingReservationSeries $series
	 * @return array
	 */
	public function Instances($series)
	{
		$bookedBy = $series->BookedBy();
		if (!is_null($bookedBy) && $bookedBy->IsAdmin)
		{
			return $series->_Instances();
		}

		return $this->AllInstancesGreaterThan($series, $this->EarliestDateToKeep($series));
	}

	/**
	 * @param ExistingReservationSeries $series
	 * @return mixed
	 */
	public function EarliestDateToKeep($series)
	{
		$startTimeConstraint = Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION,
																		ConfigKeys::RESERVATION_START_TIME_CONSTRAINT);

		if (ReservationStartTimeConstraint::IsCurrent($startTimeConstraint))
		{
			return $series->CurrentInstance()->StartDate();
		}

		if (ReservationStartTimeConstraint::IsNone($startTimeConstraint))
		{
			return Date::Min();
		}

		return Date::Now();
	}

	/**
	 * @param ReservationSeries $series
	 * @param IRepeatOptions $targetRepeatOptions
	 * @return bool
	 */
	public function CanChangeRepeatTo($series, $targetRepeatOptions)
	{
		$this->hasSameConfiguration = $targetRepeatOptions->HasSameConfigurationAs($series->RepeatOptions());

		return parent::CanChangeRepeatTo($series, $targetRepeatOptions);
	}

	public function RequiresNewSeries()
	{
		return false;
	}

	public function ShouldInstanceBeRemoved($series, $instance)
	{
		if ($this->hasSameConfiguration)
		{
			$newEndDate = $series->RepeatOptions()->TerminationDate();
			// remove all instances past the new end date
			return $instance->StartDate()->GreaterThan($newEndDate);
		}

		// remove all current instances, which now have an incompatible configuration
		return $instance->StartDate()->GreaterThan($this->EarliestDateToKeep($series));
	}
}

class SeriesUpdateScope_Future extends SeriesUpdateScopeBase
{
	public function __construct()
	{
		parent::__construct();
	}

	public function GetScope()
	{
		return SeriesUpdateScope::FutureInstances;
	}

	public function Instances($series)
	{
		return $this->AllInstancesGreaterThan($series, $this->EarliestDateToKeep($series));
	}

	public function EarliestDateToKeep($series)
	{
		return $series->CurrentInstance()->StartDate();
	}

	public function RequiresNewSeries()
	{
		return true;
	}
}

?>