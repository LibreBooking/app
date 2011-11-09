<?php
require_once(ROOT_DIR . 'Domain/Access/AccessoryRepository.php');
require_once(ROOT_DIR . 'Domain/Access/ReservationRepository.php');

class AccessoryAvailabilityRule implements IReservationValidationRule
{
	/**
	 * @var IReservationViewRepository
	 */
	protected $reservationRepository;

	/**
	 * @var IAccessoryRepository
	 */
	protected $accessoryRepository;

	/**
	 * @var string
	 */
	protected $timezone;
	
	public function __construct(IReservationViewRepository $reservationRepository, IAccessoryRepository $accessoryRepository, $timezone)
	{
		$this->reservationRepository = $reservationRepository;
		$this->accessoryRepository = $accessoryRepository;
		$this->timezone = $timezone;
	}
	
	/**
	 * @param ReservationSeries $reservationSeries
	 * @return ReservationRuleResult
	 */
	public function Validate($reservationSeries)
	{
		$conflicts = array();

		$accessories = array();
		foreach ($reservationSeries->Accessories() as $accessory)
		{
			$a = $this->accessoryRepository->LoadById($accessory->AccessoryId);
			$accessories[$a->Id] = new AccessoryToCheck($a, $accessory);
		}

		$reservations = $reservationSeries->Instances();
		/** @var Reservation $reservation */
		foreach ($reservations as $reservation)
		{
			Log::Debug("Checking for accessory conflicts, reference number %s", $reservation->ReferenceNumber());
			
			$accessoryReservations = $this->reservationRepository->GetAccessoriesWithin($reservation->Duration());

			/** @var AccessoryReservation $accessoryReservation */
			foreach ($accessoryReservations as $accessoryReservation)
			{
				if (!array_key_exists($accessoryReservation->GetAccessoryId(), $accessories))
				{
					// not an accessory on this reservation
					continue;
				}
				
				if (
					$accessoryReservation->GetStartDate()->Equals($reservation->EndDate()) ||
					$accessoryReservation->GetEndDate()->Equals($reservation->StartDate())
				)
				{
					// not overlapping
					continue;
				}
				
				if ($this->IsInConflict($reservation, $accessoryReservation, $accessories))
				{
					Log::Debug("Accessory for reference number %s conflicts with existing reservation %s", $reservation->ReferenceNumber(), $accessoryReservation->GetReferenceNumber());
					array_push($conflicts, $accessoryReservation);
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

	/**
	 * @param Reservation $instance
	 * @param AccessoryReservation $accessoryReservation
	 * @param AccessoryToCheck[] $accessoriesToCheck
	 * @return bool
	 */
	protected function IsInConflict(Reservation $instance,AccessoryReservation $accessoryReservation, $accessoriesToCheck)
	{
		/** @var AccessoryToCheck $accessoryToCheck  */
		$accessoryToCheck = $accessoriesToCheck[$accessoryReservation->GetAccessoryId()];

		return $accessoryReservation->QuantityReserved() + $accessoryToCheck->QuantityReserved() > $accessoryToCheck->QuantityAvailable();
	}

	/**
	 * @param array|AccessoryReservation[] $conflicts
	 * @return string
	 */
	protected function GetErrorString($conflicts)
	{
		$errorString = new StringBuilder();

		$errorString->Append(Resources::GetInstance()->GetString('ConflictingAccessoryDates'));
		$errorString->Append("\n");
		$format = Resources::GetInstance()->GetDateFormat(ResourceKeys::DATE_GENERAL);
		
		$dates = array();
		/** @var AccessoryReservation $conflict */
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

class AccessoryToCheck
{
	/**
	 * @var \Accessory
	 */
	private $accessory;

	/**
	 * @var \ReservationAccessory
	 */
	private $reservationAccessory;
	
	public function __construct(Accessory $accessory, ReservationAccessory $reservationAccessory)
	{
		$this->accessory = $accessory;
		$this->reservationAccessory = $reservationAccessory;
	}

	/**
	 * @return int
	 */
	public function QuantityReserved()
	{
		return $this->reservationAccessory->QuantityReserved;
	}

	/**
	 * @return int
	 */
	public function QuantityAvailable()
	{
		return $this->accessory->QuantityAvailable;
	}
}
?>