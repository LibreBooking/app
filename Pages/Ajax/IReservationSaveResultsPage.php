<?php
interface IReservationSaveResultsPage
{
	/**
	 * @param bool $succeeded
	 */
	public function SetSaveSuccessfulMessage($succeeded);
	
	/**
	 * @param array[int]string $errors
	 */
	public function ShowErrors($errors);
	
	/**
	 * @param array[int]string $warnings
	 */
	public function ShowWarnings($warnings);
}
?>