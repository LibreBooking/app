<?php

class Quota
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

	public function __construct($quotaId, $duration, $limit)
	{
	    $this->quotaId = $quotaId;
		$this->duration = $duration;
		$this->limit = $limit;
	}

	/**
	 * @param ReservationSeries $reservationSeries
	 * @param IReservationViewRepository $reservationViewRepository
	 * @param string $timezone
	 * @return bool
	 */
	public function ExceedsQuota($reservationSeries, IReservationViewRepository $reservationViewRepository, $timezone)
	{
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
	 * @param array|ReservationItemView[] $reservationsWithinRange
	 * @param ReservationSeries $series
	 * @param string $timezone
	 * @return QuotaAggregation
	 */
	private function GetAggregation($reservationsWithinRange, ReservationSeries $series, $timezone)
	{
		$aggregation = new QuotaAggregation($timezone, $this->limit, $this->duration);

		/** @var $instance Reservation */
		foreach ($series->Instances() as $instance)
		{
			$aggregation->AddInstance($instance);
		}

		/** @var $reservation ReservationItemView */
		foreach ($reservationsWithinRange as $reservation)
		{
			if ($series->ContainsResource($reservation->ResourceId))
			{
				$aggregation->AddExisting($reservation);
			}
		}

		return $aggregation;
	}

	/**
	 * @param array|ReservationItemView[] $reservationsWithinRange
	 * @param ReservationSeries $series
	 * @param string $timezone
	 */
	private function CheckAll($reservationsWithinRange, $series, $timezone)
	{
		/** @var $instance Reservation */
		foreach ($series->Instances() as $instance)
		{
			$this->AddInstance($instance, $timezone);
		}

		/** @var $reservation ReservationItemView */
		foreach ($reservationsWithinRange as $reservation)
		{
			if ($series->ContainsResource($reservation->ResourceId))
			{
				$this->AddExisting($reservation, $timezone);
			}
		}
	}

	public function AddExisting(ReservationItemView $reservation, $timezone)
	{
		$this->_breakAndAdd($reservation->StartDate, $reservation->EndDate, $timezone);
	}

	public function AddInstance(Reservation $reservation, $timezone)
	{
		$this->_breakAndAdd($reservation->StartDate(), $reservation->EndDate(), $timezone);
	}

	private function _breakAndAdd(Date $startDate, Date $endDate, $timezone)
	{
		$start = $startDate->ToTimezone($timezone);
		$end = $endDate->ToTimezone($timezone);

		if (!$start->DateEquals($end))
		{
			$beginningOfNextDay = $start->AddDays(1)->GetDate();
			$this->_add($start, $beginningOfNextDay);

			$currentDate = $beginningOfNextDay;

			for ($i = 1; $currentDate->LessThan($end) < 0; $i++)
			{
				$currentDate = $start->AddDays($i);
				$this->_add($currentDate, $currentDate->AddDays(1)->GetDate());
			}

			$this->_add($currentDate, $end);
		}
		else
		{
			$this->_add($start, $end);
		}
	}

	private function _add(Date $start, Date $end)
	{
		$durationKey = $this->duration->GetDurationKey($start);

		$this->limit->TryAdd($start, $end, $durationKey);
	}
}

interface IQuotaDuration
{
	/**
	 * @param ReservationSeries $reservationSeries
	 * @param string $timezone
	 * @return QuotaSearchDates
	 */
	public function GetSearchDates(ReservationSeries $reservationSeries, $timezone);

	/**
	 * @abstract
	 * @param Date $date
	 * @return void
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

class QuotaDurationDay implements IQuotaDuration
{
	/**
	 * @param ReservationSeries $reservationSeries
	 * @param string $timezone
	 * @return QuotaSearchDates
	 */
	public function GetSearchDates(ReservationSeries $reservationSeries, $timezone)
	{
		$instances = $reservationSeries->Instances();
		usort($instances, array('Reservation', 'Compare'));

		$startDate = $instances[0]->StartDate()->ToTimezone($timezone)->GetDate();
		$endDate = $instances[count($instances)-1]->EndDate()->ToTimezone($timezone)->AddDays(1)->GetDate();

		return new QuotaSearchDates($startDate, $endDate);
	}

	/**
	 * @param Date $date
	 * @return string
	 */
	public function GetDurationKey(Date $date)
	{
		return sprintf("%s%s%s", $date->Year(), $date->Month(), $date->Day());
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
}

class QuotaLimitCount implements IQuotaLimit
{
	/**
	 * @var array
	 */
	var $aggregateCounts = array();

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