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
	 * @param bool $succeeded
	 */
	public function SetSaveSuccessfulMessage($succeeded)
	{
		$this->SetJson(array('approved' => (string)$succeeded));
	}

	public function ShowErrors($errors)
	{
		if (!empty($errors))
		{
			$this->SetJson(array('approved' => (string)false), $errors);
		}
	}
	
	public function ShowWarnings($warnings)
	{
		// nothing to do
	}
}
?>