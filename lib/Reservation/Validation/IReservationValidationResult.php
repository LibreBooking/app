<?php
interface IReservationValidationResult
{
	/**
	 * @return bool
	 */
	public function CanBeSaved();
	
	/**
	 * @return array[int]string
	 */
	public function GetErrors();
	
	/**
	 * @return array[int]string
	 */
	public function GetWarnings(); 
}
?>