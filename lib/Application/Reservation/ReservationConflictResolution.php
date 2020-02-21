<?php
/**
 * Copyright 2011-2020 Nick Korbel
 *
 * This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Domain/Access/namespace.php');

interface IReservationConflictResolution
{
	/**
	 * @param ReservationItemView $existingReservation
	 * @param Blackout $blackout
	 * @return bool
	 */
	public function Handle(ReservationItemView $existingReservation, Blackout $blackout);
}

abstract class ReservationConflictResolution implements IReservationConflictResolution
{
	const BookAround = 'bookAround';
	const Delete = 'delete';
	const Notify = 'notify';

	protected function __construct()
	{
	}

	/**
	 * @param string|ReservationConflictResolution $resolutionType
	 * @return ReservationConflictResolution
	 */
	public static function Create($resolutionType)
	{
		if ($resolutionType == self::Delete)
		{
			return new ReservationConflictDelete(new ReservationRepository(), new DeleteReservationNotificationService(new UserRepository(), new AttributeRepository()));
		}
		if ($resolutionType == self::BookAround)
		{
			return new ReservationConflictBookAround();
		}
		return new ReservationConflictNotify();
	}
}

class ReservationConflictNotify extends ReservationConflictResolution
{
	public function Handle(ReservationItemView $existingReservation, Blackout $blackout)
	{
		return false;
	}
}

class ReservationConflictDelete extends ReservationConflictResolution
{
	/**
	 * @var IReservationRepository
	 */
	private $repository;
    /**
     * @var IReservationNotificationService
     */
    private $notificationService;

    public function __construct(IReservationRepository $repository, IReservationNotificationService $notificationService)
	{
		$this->repository = $repository;
        $this->notificationService = $notificationService;
    }

	public function Handle(ReservationItemView $existingReservation, Blackout $blackout)
	{
		$reservation = $this->repository->LoadById($existingReservation->GetId());
		$reservation->ApplyChangesTo(SeriesUpdateScope::ThisInstance);
		$reservation->Delete(ServiceLocator::GetServer()->GetUserSession(), 'Deleting conflicting reservation');
		$this->repository->Delete($reservation);
        $this->notificationService->Notify($reservation);

		return true;
	}
}

class ReservationConflictBookAround extends ReservationConflictResolution
{
    public function __construct()
    {
        parent::__construct();
    }

    public function Handle(ReservationItemView $existingReservation, Blackout $blackout)
    {
        $originalStart = $blackout->StartDate();
        $originalEnd = $blackout->EndDate();
        $reservationStart = $existingReservation->StartDate;
        $reservationEnd = $existingReservation->EndDate;
        $timezone = $blackout->StartDate()->Timezone();

        if ($originalStart->LessThan($reservationStart) && $originalEnd->GreaterThan($reservationEnd))
        {
            Log::Debug('Blackout around reservation %s start %s end %s', $existingReservation->GetId(), $reservationStart, $reservationEnd);

            $blackout->SetDate(new DateRange($originalStart, $reservationStart->ToTimezone($timezone)));
            $blackout->GetSeries()->AddBlackout(new Blackout(new DateRange($reservationEnd->ToTimezone($timezone), $originalEnd)));
            return true;
        }

        if ($originalStart->LessThan($reservationStart) && $originalEnd->GreaterThan($reservationStart) && $originalEnd->LessThanOrEqual($reservationEnd))
        {
            $blackout->SetDate(new DateRange($originalStart, $reservationStart->ToTimezone($timezone)));
            return true;
        }

        if ($originalStart->GreaterThan($reservationStart) && $originalStart->LessThanOrEqual($reservationEnd) && $originalEnd->GreaterThan($reservationEnd))
        {
            $blackout->SetDate(new DateRange($reservationEnd->ToTimezone($timezone), $originalEnd));
            return true;
        }

        if ($originalStart->GreaterThanOrEqual($reservationStart) && $originalEnd->LessThanOrEqual($reservationEnd))
        {
            return $blackout->GetSeries()->Delete($blackout);
        }

        return false;
    }
}