<?php

class Quota
{
	/**
	 * @var int
	 */
	private $quotaId;

	public function __construct($quotaId)
	{
	    $this->quotaId = $quotaId;
	}

	/**
	 * @param ReservationSeries $reservationSeries
	 * @param IReservationViewRepository $reservationViewRepository
	 * @param string $timezone
	 * @return bool
	 */
	public function ExceedsQuota($reservationSeries, IReservationViewRepository $reservationViewRepository, $timezone)
	{
		$dates = $this->GetEarliestAndLatestReservationDates($reservationSeries, $timezone);
		$reservationsWithinRange = $reservationViewRepository->GetReservationList($dates[0], $dates[1], $reservationSeries->UserId(), ReservationUserLevel::OWNER);

		$aggregation = $this->GetAggregation($reservationsWithinRange, $reservationSeries, $timezone);

		return $aggregation->ExceedsConstraint(1);
	}

	public function __toString()
	{
		return $this->quotaId . '';
	}

	private function GetEarliestAndLatestReservationDates(ReservationSeries $reservationSeries, $timezone)
	{
		$instances = $reservationSeries->Instances();
		usort($instances, array('Reservation', 'Compare'));
		
		$startDate = $instances[0]->StartDate()->ToTimezone($timezone)->GetDate();
		$endDate = $instances[count($instances)-1]->EndDate()->ToTimezone($timezone)->AddDays(1)->GetDate();

		return array($startDate, $endDate);
	}

	/**
	 * @param array|ReservationItemView[] $reservationsWithinRange
	 * @param ReservationSeries $series
	 * @param string $timezone
	 * @return DailyBreakdown
	 */
	private function GetAggregation($reservationsWithinRange, ReservationSeries $series, $timezone)
	{
		$dailyBreakdown = new DailyBreakdown($timezone);
		
		/** @var $reservation ReservationItemView */
		foreach ($reservationsWithinRange as $reservation)
		{
			if ($series->ContainsResource($reservation->ResourceId))
			{
				$dailyBreakdown->AddExisting($reservation);
			}
		}

		/** @var $instance Reservation */
		foreach ($series->Instances() as $instance)
		{
			$dailyBreakdown->AddInstance($instance);
		}

		return $dailyBreakdown;
	}
}

class DailyBreakdown
{
	/**
	 * @var string
	 */
	private $timezone;
	
	public function __construct($timezone)
	{
		$this->timezone = $timezone;
	}
	public function AddExisting(ReservationItemView $reservation)
	{
		$this->_breakAndAdd($reservation->StartDate, $reservation->EndDate);
	}

	public function AddInstance(Reservation $reservation)
	{
		$this->_breakAndAdd($reservation->StartDate(), $reservation->EndDate());
	}

	var $reservationLengths = array();

	private function _breakAndAdd(Date $startDate, Date $endDate)
	{
		$start = $startDate->ToTimezone($this->timezone);
		$end = $endDate->ToTimezone($this->timezone);
		
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
		$key = sprintf("%s%s%s", $start->Year(), $start->Month(), $start->Day());
		if (array_key_exists($key, $this->reservationLengths))
		{
			$this->reservationLengths[$key][] = $end->GetDifference($start);
		}
		else
		{
			$this->reservationLengths[$key] = array($end->GetDifference($start));
		}
	}

	public function ExceedsConstraint($constraint)
	{
		foreach ($this->reservationLengths as $x)
		{
			if (count($x) > $constraint)
			{
				return true;
			}
		}

		return false;
	}
}

?>