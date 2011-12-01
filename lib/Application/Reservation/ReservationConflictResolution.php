<?php
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
        $reservation->Delete(ServiceLocator::GetServer()->GetUserSession());
        $this->repository->Delete($reservation);

		return true;
	}
}
?>