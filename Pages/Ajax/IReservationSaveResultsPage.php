<?php
interface IReservationSaveResultsPage
{
	/**
	 * @param bool $succeeded
	 */
	public function SetSaveSuccessfulMessage($succeeded);
	
	/**
	 * @param array|string[] $errors
	 */
	public function ShowErrors($errors);
	
	/**
	 * @param array|string[] $warnings
	 */
	public function ShowWarnings($warnings);
}
?>