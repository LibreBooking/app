<?php

interface IReservationConflictResolution
{
	
}

class ReservationConflictResolution implements IReservationConflictResolution
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
		return new ReservationConflictResolution();
	}
}
?>