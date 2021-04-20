<?php

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/ParticipationPresenter.php');

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
	 * @param $results serializable json
	 * @return void
	 */
	function DisplayResult($results);

	/**
	 * @return int
	 */
	function GetUserId();

	/**
	 * @return string
	 */
	function GetResponseType();

	/**
	 * @param array|ReservationItemView[] $reservations
	 * @return void
	 */
	function BindReservations($reservations);

	/**
	 * @param $timezone
	 * @return void
	 */
	public function SetTimezone($timezone);

	/**
	 * @param $result string
	 */
	public function SetResult($result);
}

class ParticipationPage extends SecurePage implements IParticipationPage
{
	/**
	 * @var \ParticipationPresenter
	 */
	private $presenter;

	public function __construct()
	{
	    parent::__construct('OpenInvitations');
		$this->presenter = new ParticipationPresenter(
		    $this,
            new ReservationRepository(),
            new ReservationViewRepository(),
            new ParticipationNotification(new UserRepository()));
	}

	public function PageLoad()
	{
		$this->presenter->PageLoad();
	}

	public function DisplayParticipation()
	{
		$this->Display('MyAccount/participation.tpl');
	}

	public function DisplayResult($results)
	{
		$this->SetJson($results);
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

	function GetResponseType()
	{
		return $this->GetQuerystring(QueryStringKeys::RESPONSE_TYPE);
	}

	function BindReservations($reservations)
	{
		$this->Set('Reservations', $reservations);
	}

	public function SetTimezone($timezone)
	{
		$this->Set('Timezone', $timezone);
	}

	/**
	 * @param $result string
	 */
	public function SetResult($result)
	{
		$this->Set('ActionResult', $result);
	}
}
