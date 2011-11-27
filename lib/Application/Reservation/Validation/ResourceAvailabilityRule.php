<?php
interface IResourceAvailabilityStrategy
{
	/**
	 * @param Date $startDate
	 * @param Date $endDate
	 * @return array|IReservedItemView[]
	 */
	public function GetItemsBetween(Date $startDate, Date $endDate);
}

class ResourceReservationAvailability implements IResourceAvailabilityStrategy
{
	/**
	 * @var IReservationViewRepository
	 */
	protected $_repository;

	public function __construct(IReservationViewRepository $repository)
	{
		$this->_repository = $repository;
	}
	
	public function GetItemsBetween(Date $startDate, Date $endDate)
	{
		return $this->_repository->GetReservationList($startDate, $endDate);
	}
}

class ResourceBlackoutAvailability implements IResourceAvailabilityStrategy
{
	/**
	 * @var IReservationViewRepository
	 */
	protected $_repository;

	public function __construct(IReservationViewRepository $repository)
	{
		$this->_repository = $repository;
	}

	public function GetItemsBetween(Date $startDate, Date $endDate)
	{
		return $this->_repository->GetBlackoutsWithin(new DateRange($startDate, $endDate));
	}
}

class ResourceAvailabilityRule implements IReservationValidationRule
{
	/**
	 * @var IResourceAvailabilityStrategy
	 */
	protected $strategy;
	
	/**
	 * @var string
	 */
	protected $timezone;
	
	public function __construct(IResourceAvailabilityStrategy $strategy, $timezone)
	{
		$this->strategy = $strategy;
		$this->timezone = $timezone;
	}
	
	/**
	 * @param ReservationSeries $reservationSeries
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries)
	{
		$conflicts = array();
		
		$reservations = $reservationSeries->Instances();

		/** @var Reservation $reservation */
		foreach ($reservations as $reservation)
		{
			Log::Debug("Checking for reservation conflicts, reference number %s", $reservation->ReferenceNumber());
			
			$existingItems = $this->strategy->GetItemsBetween($reservation->StartDate(), $reservation->EndDate());

			/** @var IReservedItemView $existingItem */
			foreach ($existingItems as $existingItem)
			{
				if (
					$existingItem->GetStartDate()->Equals($reservation->EndDate()) ||
					$existingItem->GetEndDate()->Equals($reservation->StartDate())
				)
				{
					continue;
				}
				
				if ($this->IsInConflict($reservation, $reservationSeries, $existingItem))
				{
					Log::Debug("Reference number %s conflicts with existing %s with id %s", $reservation->ReferenceNumber(), get_class($existingItem), $existingItem->GetId());
					array_push($conflicts, $existingItem);
				}
			}
		}
		
		$thereAreConflicts = count($conflicts) > 0;		
		
		if ($thereAreConflicts)
		{
			return new ReservationRuleResult(false, $this->GetErrorString($conflicts));
		}
		
		return new ReservationRuleResult();
	}
	
	protected function IsInConflict(Reservation $instance, ReservationSeries $series, IReservedItemView $existingItem)
	{
		return ($existingItem->GetResourceId() == $series->ResourceId()) ||
			(false !== array_search($existingItem->GetResourceId(), $series->AllResourceIds()));
	}

	/**
	 * @param array|IReservedItemView[] $conflicts
	 * @return string
	 */
	protected function GetErrorString($conflicts)
	{
		$errorString = new StringBuilder();

		$errorString->Append(Resources::GetInstance()->GetString('ConflictingReservationDates'));
		$errorString->Append("\n");
		$format = Resources::GetInstance()->GetDateFormat(ResourceKeys::DATE_GENERAL);
		
		$dates = array();
		/** @var IReservedItemView $conflict */
		foreach($conflicts as $conflict)
		{
			$dates[] = $conflict->GetStartDate()->ToTimezone($this->timezone)->Format($format);
		}
		
		$uniqueDates = array_unique($dates);
		sort($uniqueDates);
		
		foreach ($uniqueDates as $date)
		{
			$errorString->Append($date);
			$errorString->Append("\n");
		}
		
		return $errorString->ToString();
	}
}
?>