<?php

interface IQuota
{
	/**
	 * @param ReservationSeries $reservationSeries
	 * @param User $user
	 * @param Schedule $schedule
	 * @param IReservationViewRepository $reservationViewRepository
	 * @return bool
	 */
	public function ExceedsQuota($reservationSeries, $user, $schedule, IReservationViewRepository $reservationViewRepository);
}

class Quota implements IQuota
{
	/**
	 * @var int
	 */
	private $quotaId;

	/**
	 * @var \IQuotaDuration
	 */
	private $duration;

	/**
	 * @var \IQuotaLimit
	 */
	private $limit;

	/**
	 * @var int
	 */
	private $resourceId;

	/**
	 * @var int
	 */
	private $groupId;

	/**
	 * @param int $quotaId
	 * @param IQuotaDuration $duration
	 * @param IQuotaLimit $limit
	 * @param int $resourceId
	 * @param int $groupId
	 */
	public function __construct($quotaId, $duration, $limit, $resourceId = null, $groupId = null)
	{
	    $this->quotaId = $quotaId;
		$this->duration = $duration;
		$this->limit = $limit;
		$this->resourceId = empty($resourceId) ? null : $resourceId;
		$this->groupId = empty($groupId) ? null : $groupId;
	}

	/**
	 * @static
	 * @param string $duration
	 * @param decimal $limit
	 * @param string $unit
	 * @param int $resourceId
	 * @param int $groupId
	 * @return Quota
	 */
	public static function Create($duration, $limit, $unit, $resourceId, $groupId)
	{
		return new Quota(0, self::CreateDuration($duration), self::CreateLimit($limit, $unit), $resourceId, $groupId);
	}

	/**
	 * @static
	 * @param decimal $limit
	 * @param string $unit QuotaUnit
	 * @return IQuotaLimit
	 */
	public static function CreateLimit($limit, $unit)
	{
		if ($unit == QuotaUnit::Reservations)
		{
			return new QuotaLimitCount($limit);
		}

		return new QuotaLimitHours($limit);
	}

	/**
	 * @static
	 * @param string $duration QuotaDuration
	 * @return IQuotaDuration
	 */
	public static function CreateDuration($duration)
	{
		if ($duration == QuotaDuration::Day)
		{
			return new QuotaDurationDay();
		}

		if ($duration == QuotaDuration::Week)
		{
			return new QuotaDurationWeek();
		}

		return new QuotaDurationMonth();
	}

	/**
	 * @param ReservationSeries $reservationSeries
	 * @param User $user
	 * @param Schedule $schedule
	 * @param IReservationViewRepository $reservationViewRepository
	 * @return bool
	 */
	public function ExceedsQuota($reservationSeries, $user, $schedule, IReservationViewRepository $reservationViewRepository)
	{
		$timezone = $schedule->GetTimezone();
		
		foreach ($reservationSeries->AllResourceIds() as $resourceId)
		{
			if (!$this->AppliesToResource($resourceId))
			{
				return false;
			}
		}

		foreach ($user->Groups() as $group)
		{
			if (!$this->AppliesToGroup($group->GroupId))
			{
				return false;
			}
		}

		if (count($reservationSeries->Instances()) == 0)
		{
			return false;
		}
		
		$dates = $this->duration->GetSearchDates($reservationSeries, $timezone);
		$reservationsWithinRange = $reservationViewRepository->GetReservationList($dates->Start(), $dates->End(), $reservationSeries->UserId(), ReservationUserLevel::OWNER);

		try
		{
			$this->CheckAll($reservationsWithinRange, $reservationSeries, $timezone);
		}
		catch (QuotaExceededException $ex)
		{
			return true;
		}

		return false;
	}
	
	public function __toString()
	{
		return $this->quotaId . '';
	}
	
	/**
	 * @return IQuotaLimit
	 */
	public function GetLimit()
	{
		return $this->limit;
	}

	/**
	 * @return IQuotaDuration
	 */
	public function GetDuration()
	{
		return $this->duration;
	}

	/**
	 * @param int $resourceId
	 * @return bool
	 */
	public function AppliesToResource($resourceId)
	{
		return is_null($this->resourceId) || $this->resourceId == $resourceId;
	}

	/**
	 * @param int $groupId
	 * @return bool
	 */
	public function AppliesToGroup($groupId)
	{
		return is_null($this->groupId) || $this->groupId == $groupId;
	}

	/**
	 * @return int|null
	 */
	public function ResourceId()
	{
		return $this->resourceId;
	}

	/**
	 * @return int|null
	 */
	public function GroupId()
	{
		return $this->groupId;
	}

	private function AddExisting(ReservationItemView $reservation, $timezone)
	{
		$this->_breakAndAdd($reservation->StartDate, $reservation->EndDate, $timezone);
	}

	private function AddInstance(Reservation $reservation, $timezone)
	{
		$this->_breakAndAdd($reservation->StartDate(), $reservation->EndDate(), $timezone);
	}

	/**
	 * @param array|ReservationItemView[] $reservationsWithinRange
	 * @param ReservationSeries $series
	 * @param string $timezone
	 * @throws QuotaExceededException
	 */
	private function CheckAll($reservationsWithinRange, $series, $timezone)
	{
		$toBeSkipped = array();
		
		/** @var $instance Reservation */
		foreach ($series->Instances() as $instance)
		{
			$toBeSkipped[$instance->ReferenceNumber()] = true;
			$this->AddInstance($instance, $timezone);
		}

		/** @var $reservation ReservationItemView */
		foreach ($reservationsWithinRange as $reservation)
		{
			if ($series->ContainsResource($reservation->ResourceId) && !array_key_exists($reservation->ReferenceNumber, $toBeSkipped) && !$this->willBeDeleted($series, $reservation->ReservationId))
			{
				$this->AddExisting($reservation, $timezone);
			}
		}
	}

	/**
	 * @param $series
	 * @param $reservationId
	 * @return bool
	 */
	private function willBeDeleted($series, $reservationId)
	{
		if (method_exists($series , 'IsMarkedForDelete'))
		{
			return $series->IsMarkedForDelete($reservationId);
		}

		return false;
	}

	private function _breakAndAdd(Date $startDate, Date $endDate, $timezone)
	{
		$start = $startDate->ToTimezone($timezone);
		$end = $endDate->ToTimezone($timezone);

		$range = new DateRange($start, $end);

		$ranges = $this->duration->Split($range);

		foreach ($ranges as $dr)
		{
			$this->_add($dr);
		}
	}

	private function _add(DateRange $dateRange)
	{
		$durationKey = $this->duration->GetDurationKey($dateRange->GetBegin());

		$this->limit->TryAdd($dateRange->GetBegin(), $dateRange->GetEnd(), $durationKey);
	}
}

class QuotaUnit
{
	const Hours = 'hours';
	const Reservations = 'reservations';
}


interface IQuotaDuration
{
	/**
	 * @abstract
	 * @return string QuotaDuration
	 */
	public function Name();

	/**
	 * @param ReservationSeries $reservationSeries
	 * @param string $timezone
	 * @return QuotaSearchDates
	 */
	public function GetSearchDates(ReservationSeries $reservationSeries, $timezone);

	/**
	 * @abstract
	 * @param DateRange $dateRange
	 * @return array|DateRange[]
	 */
	public function Split(DateRange $dateRange);

	/**
	 * @abstract
	 * @param Date $date
	 * @return string
	 */
	public function GetDurationKey(Date $date);
}

class QuotaSearchDates
{
	/**
	 * @var \Date
	 */
	private $start;

	/**
	 * @var \Date
	 */
	private $end;
	
	public function __construct(Date $start, Date $end)
	{
		$this->start = $start;
		$this->end = $end;
	}

	/**
	 * @return Date
	 */
	public function Start()
	{
		return $this->start;
	}

	/**
	 * @return Date
	 */
	public function End()
	{
		return $this->end;
	}
}

class QuotaDurationDay extends QuotaDuration implements IQuotaDuration
{
	/**
	 * @param ReservationSeries $reservationSeries
	 * @param string $timezone
	 * @return QuotaSearchDates
	 */
	public function GetSearchDates(ReservationSeries $reservationSeries, $timezone)
	{
		$dates = $this->GetFirstAndLastReservationDates($reservationSeries);
		
		$startDate = $dates[0]->ToTimezone($timezone)->GetDate();
		$endDate = $dates[1]->ToTimezone($timezone)->AddDays(1)->GetDate();

		return new QuotaSearchDates($startDate, $endDate);
	}

	public function Split(DateRange $dateRange)
	{
		$start = $dateRange->GetBegin();
		$end = $dateRange->GetEnd();
		
		$ranges = array();

		if (!$start->DateEquals($end))
		{
			$beginningOfNextDay = $start->AddDays(1)->GetDate();
			$ranges[] = new DateRange($start, $beginningOfNextDay);

			$currentDate = $beginningOfNextDay;

			for ($i = 1; $currentDate->LessThan($end) < 0; $i++)
			{
				$currentDate = $start->AddDays($i);
				$ranges[] = new DateRange($currentDate, $currentDate->AddDays(1)->GetDate());
			}

			$ranges[] = new DateRange($currentDate, $end);
		}
		else
		{
			$ranges[] = new DateRange($start, $end);
		}

		return $ranges;
	}

	/**
	 * @param Date $date
	 * @return string
	 */
	public function GetDurationKey(Date $date)
	{
		return sprintf("%s%s%s", $date->Year(), $date->Month(), $date->Day());
	}

	/**
	 * @return string QuotaDuration
	 */
	public function Name()
	{
		return QuotaDuration::Day;
	}
}

abstract class QuotaDuration
{
	const Day = 'day';
	const Week = 'week';
	const Month = 'month';
	
	/**
	 * @param ReservationSeries $reservationSeries
	 * @return array|Date[]
	 */
	protected function GetFirstAndLastReservationDates(ReservationSeries $reservationSeries)
	{
		/** @var $instances Reservation[] */
		$instances = $reservationSeries->Instances();
		usort($instances, array('Reservation', 'Compare'));

		return array($instances[0]->StartDate(), $instances[count($instances)-1]->EndDate());
	}
}

class QuotaDurationWeek extends QuotaDuration implements IQuotaDuration
{
	/**
	 * @param ReservationSeries $reservationSeries
	 * @param string $timezone
	 * @return QuotaSearchDates
	 */
	public function GetSearchDates(ReservationSeries $reservationSeries, $timezone)
	{
		$dates = $this->GetFirstAndLastReservationDates($reservationSeries);
		
		$startDate = $dates[0]->ToTimezone($timezone);
		$daysFromWeekStart = $startDate->Weekday();
		$startDate = $startDate->AddDays(-$daysFromWeekStart)->GetDate();

		$endDate = $dates[1]->ToTimezone($timezone);
		$daysFromWeekEnd = 7 - $endDate->Weekday();
		$endDate = $endDate->AddDays($daysFromWeekEnd)->GetDate();

		return new QuotaSearchDates($startDate, $endDate);
	}

	/**
	 * @param Date $date
	 * @return void
	 */
	public function GetDurationKey(Date $date)
	{
		$daysFromWeekStart = $date->Weekday();
		$firstDayOfWeek = $date->AddDays(-$daysFromWeekStart)->GetDate();
		return sprintf("%s%s%s", $firstDayOfWeek->Year(), $firstDayOfWeek->Month(), $firstDayOfWeek->Day());
	}

	/**
	 * @param DateRange $dateRange
	 * @return array|DateRange[]
	 */
	public function Split(DateRange $dateRange)
	{
		$start = $dateRange->GetBegin();
		$end = $dateRange->GetEnd();

		$ranges = array();

		if (!$start->DateEquals($end))
		{
			$nextWeek = $this->GetStartOfNextWeek($start);

			if ($nextWeek->LessThan($end))
			{
				$ranges[] = new DateRange($start, $nextWeek);
				while ($nextWeek->LessThan($end))
				{
					$thisEnd = $this->GetStartOfNextWeek($nextWeek);

					if ($thisEnd->LessThan($end))
					{
						$ranges[] = new DateRange($nextWeek, $thisEnd);
					}
					else
					{
						$ranges[] = new DateRange($nextWeek, $end);
					}
					
					$nextWeek = $thisEnd;
				}
			}
			else
			{
				$ranges[] = new DateRange($start, $end);
			}
		}
		else
		{
			$ranges[] = new DateRange($start, $end);
		}


		return $ranges;
	}

	/**
	 * @param Date $date
	 * @return Date
	 */
	private function GetStartOfNextWeek(Date $date)
	{
		$daysFromWeekEnd = 7 - $date->Weekday();
		return $date->AddDays($daysFromWeekEnd)->GetDate();
	}

	/**
	 * @return string QuotaDuration
	 */
	public function Name()
	{
		return QuotaDuration::Week;
	}
}

class QuotaDurationMonth extends QuotaDuration implements IQuotaDuration
{

	/**
	 * @param ReservationSeries $reservationSeries
	 * @param string $timezone
	 * @return QuotaSearchDates
	 */
	public function GetSearchDates(ReservationSeries $reservationSeries, $timezone)
	{
		$minMax = $this->GetFirstAndLastReservationDates($reservationSeries);

		/** @var $start Date */
		$start = $minMax[0]->ToTimezone($timezone);
		/** @var $end Date */
		$end = $minMax[1]->ToTimezone($timezone);

		$searchStart = Date::Create($start->Year(), $start->Month(), 1, 0, 0, 0, $timezone);
		$searchEnd = Date::Create($end->Year(), $end->Month()+1, 1, 0, 0, 0, $timezone);

		return new QuotaSearchDates($searchStart, $searchEnd);
	}

	/**
	 * @param DateRange $dateRange
	 * @return array|DateRange[]
	 */
	public function Split(DateRange $dateRange)
	{
		$ranges = array();
		
		$start = $dateRange->GetBegin();
		$end = $dateRange->GetEnd();

		if (!$this->SameMonth($start, $end))
		{
			$current = $start;

			while (!$this->SameMonth($current, $end))
			{
				$next = $this->GetFirstOfMonth($current, 1);

				$ranges[] = new DateRange($current, $next);

				$current = $next;

				if ($this->SameMonth($current, $end))
				{
					$ranges[] = new DateRange($current, $end);
				}
			}
		}
		else
		{
			$ranges[] = $dateRange;
		}

		return $ranges;
	}

	/**
	 * @param Date $date
	 * @param int $monthOffset
	 * @return Date
	 */
	private function GetFirstOfMonth(Date $date, $monthOffset = 0)
	{
		return Date::Create($date->Year(), $date->Month() + $monthOffset, 1, 0, 0, 0, $date->Timezone());
	}

	/**
	 * @param Date $d1
	 * @param Date $d2
	 * @return bool
	 */
	private function SameMonth(Date $d1, Date $d2)
	{
		return ($d1->Month() == $d2->Month()) && ($d1->Year()== $d2->Year());
	}

	/**
	 * @param Date $date
	 * @return string
	 */
	public function GetDurationKey(Date $date)
	{
		return sprintf("%s%s", $date->Year(), $date->Month());
	}

	/**
	 * @return string QuotaDuration
	 */
	public function Name()
	{
		return QuotaDuration::Month;
	}
}

interface IQuotaLimit
{
	/**
	 * @abstract
	 * @param Date $start
	 * @param Date $end
	 * @param string $key
	 * @return void
	 * @throws QuotaExceededException
	 */
	public function TryAdd($start, $end, $key);

	/**
	 * @abstract
	 * @return decimal
	 */
	public function Amount();

	/**
	 * @abstract
	 * @return string|QuotaUnit
	 */
	public function Name();
}

class QuotaLimitCount implements IQuotaLimit
{
	/**
	 * @var array|int[]
	 */
	private $aggregateCounts = array();

	/**
	 * @var int
	 */
	private $totalAllowed;

	/**
	 * @param int $totalAllowed
	 */
	public function __construct($totalAllowed)
	{
		$this->totalAllowed = $totalAllowed;
	}
	
	public function TryAdd($start, $end, $key)
	{
		if (array_key_exists($key, $this->aggregateCounts))
		{
			$this->aggregateCounts[$key] = $this->aggregateCounts[$key]+1;

			if ($this->aggregateCounts[$key] > $this->totalAllowed)
			{
				throw new QuotaExceededException("Only {$this->totalAllowed} reservations are allowed for this duration");
			}
		}
		else
		{
			$this->aggregateCounts[$key] = 1;
		}
	}

	/**
	 * @return decimal
	 */
	public function Amount()
	{
		return $this->totalAllowed;
	}

	/**
	 * @return string|QuotaUnit
	 */
	public function Name()
	{
		return QuotaUnit::Reservations;
	}
}

class QuotaLimitHours implements IQuotaLimit
{
	/**
	 * @var array|DateDiff[]
	 */
	private $aggregateCounts = array();

	/**
	 * @var \DateDiff
	 */
	private $allowedDuration;

	/**
	 * @var decimal
	 */
	private $allowedHours;
	
	/**
	 * @param decimal $allowedHours
	 */
	public function __construct($allowedHours)
	{
		$this->allowedHours = $allowedHours;
		$this->allowedDuration = new DateDiff($allowedHours * 3600);
	}

	/**
	 * @param Date $start
	 * @param Date $end
	 * @param string $key
	 * @return void
	 * @throws QuotaExceededException
	 */
	public function TryAdd($start, $end, $key)
	{
		$diff = $start->GetDifference($end);

		if (array_key_exists($key, $this->aggregateCounts))
		{
			$this->aggregateCounts[$key] = $this->aggregateCounts[$key]->Add($diff);
		}
		else
		{
			$this->aggregateCounts[$key] = $diff;
		}

		if ($this->aggregateCounts[$key]->GreaterThan($this->allowedDuration))
		{
			throw new QuotaExceededException("Cumulative reservation length cannot exceed {$this->allowedHours} hours for this duration");
		}
	}

	/**
	 * @return decimal
	 */
	public function Amount()
	{
		return $this->allowedHours;
	}

	/**
	 * @return string|QuotaUnit
	 */
	public function Name()
	{
		return QuotaUnit::Hours;
	}
}
class QuotaExceededException extends Exception
{
	/**
	 * @param string $message
	 */
	public function __construct($message)
	{
		parent::__construct($message);
	}
}

?>