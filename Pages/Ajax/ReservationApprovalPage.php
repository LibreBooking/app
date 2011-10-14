<?php
require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Pages/Ajax/IReservationSaveResultsPage.php');
require_once(ROOT_DIR . 'Presenters/ReservationApprovalPresenter.php');

interface IReservationApprovalPage extends IReservationSaveResultsPage
{
	/**
	 * @abstract
	 * @return string
	 */
	public function GetReferenceNumber();

	/**
	 * @abstract
	 * @param $wasApproved bool
	 * @return void
	 */
	public function SetResult($wasApproved);
}
class ReservationApprovalPage extends SecurePage implements IReservationApprovalPage
{
	public function PageLoad()
	{
		$reservationAction = ReservationAction::Approve;
		$factory = new ReservationPersistenceFactory();
		$persistenceService = $factory->Create($reservationAction);
		$handler = ReservationHandler::Create($reservationAction, $persistenceService);

		$presenter = new ReservationApprovalPresenter($this, $persistenceService, $handler);
		$presenter->PageLoad();
	}

	/**
	 * @return string
	 */
	public function GetReferenceNumber()
	{
		return $this->GetQuerystring(QueryStringKeys::REFERENCE_NUMBER);
	}

	/**
	 * @param $wasApproved bool
	 * @return void
	 */
	public function SetResult($wasApproved)
	{
		$this->SetJson(array('approved' => (string)$wasApproved));
	}

	/**
	 * @param bool $succeeded
	 */
	public function SetSaveSuccessfulMessage($succeeded)
	{
		// TODO: Implement SetSaveSuccessfulMessage() method.
	}

	/**
	 * @param array[int]string $errors
	 */
	public function ShowErrors($errors)
	{
		// TODO: Implement ShowErrors() method.
	}

	/**
	 * @param array[int]string $warnings
	 */
	public function ShowWarnings($warnings)
	{
		// TODO: Implement ShowWarnings() method.
	}
}
?>