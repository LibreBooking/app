<?php 

interface IReservationPreconditionService
{
	/**
	 * @param IReservationPage $page
	 */
	public function CheckAll(IReservationPage $page, UserSession $user);
}

?>