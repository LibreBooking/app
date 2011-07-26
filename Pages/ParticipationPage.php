<?php
require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/DashboardPresenter.php');

interface IParticipationPage
{
	/**
	 * @return string|InvitationAction
	 */
	function GetInvitationAction();

	/**
	 * @return string|InvitationAction
	 */
	function GetInvitationReferenceNumber();

	/**
	 * @return void
	 */
	function DisplayParticipation();

	/**
	 * @return int
	 */
	function GetUserId();
}

class ParticipationPage extends SecurePage implements IParticipationPage
{
	/**
	 * @var \ParticipationPresenter
	 */
	private $presenter;
	
	public function __construct()
	{
	    parent::__construct('Participation');
		$this->presenter = new ParticipationPresenter($this, new ReservationRepository());
	}
	
	public function PageLoad()
	{
		$this->presenter->PageLoad();
	}

	public function DisplayParticipation()
	{
		$this->Display('participation.tpl');
	}

	function GetInvitationAction()
	{
		return $this->GetQuerystring(QueryStringKeys::INVITATION_ACTION);
	}

	function GetInvitationReferenceNumber()
	{
		return $this->GetQuerystring(QueryStringKeys::REFERENCE_NUMBER);
	}

	public function GetUserId()
	{
		return ServiceLocator::GetServer()->GetUserSession()->UserId;
	}
}
?>
