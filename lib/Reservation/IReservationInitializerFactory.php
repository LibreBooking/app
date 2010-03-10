<?php 

interface IReservationInitializerFactory
{
	/**
	 * @param IReservationPage $page
	 * @return IReservationInitializer
	 */
	public function GetInitializer(IReservationPage $page);
}

?>