<?php
/**
Copyright 2011-2014 Nick Korbel

This file is part of Booked SchedulerBooked SchedulereIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later versBooked SchedulerduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
alBooked SchedulercheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'Domain/Access/namespace.php');

interface IReservationConflictResolution
{
	/**
	 * @abstract
	 * @param ReservationItemView $existingReservation
	 * @return bool
	 */
	public function Handle(ReservationItemView $existingReservation);
}

abstract class ReservationConflictResolution implements IReservationConflictResolution
{
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
            return new ReservationConflictDelete(new ReservationRepository());
        }
		return new ReservationConflictNotify();
	}
}

class ReservationConflictNotify extends ReservationConflictResolution
{
	/**
	 * @param ReservationItemView $existingReservation
	 * @return bool
	 */
	public function Handle(ReservationItemView $existingReservation)
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

    public function __construct(IReservationRepository $repository)
    {
        $this->repository = $repository;
    }
	/**
	 * @param ReservationItemView $existingReservation
	 * @return bool
	 */
	public function Handle(ReservationItemView $existingReservation)
	{
        $reservation = $this->repository->LoadById($existingReservation->GetId());
		$reservation->ApplyChangesTo(SeriesUpdateScope::ThisInstance);
        $reservation->Delete(ServiceLocator::GetServer()->GetUserSession());
        $this->repository->Delete($reservation);

		return true;
	}
}
?>