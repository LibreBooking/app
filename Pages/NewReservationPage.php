<?php
require_once(ROOT_DIR . 'Pages/ReservationPage.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'Presenters/ReservationPresenter.php');

interface INewReservationPage extends IReservationPage
{
	public function GetRequestedResourceId();
	
	public function GetRequestedScheduleId();
	
	/**
	 * @return Date
	 */
	public function GetReservationDate();
	
	/**
	 * @return Date
	 */
	public function GetStartDate();
	
	/**
	 * @return Date
	 */
	public function GetEndDate();
}

class NewReservationPage extends ReservationPage implements INewReservationPage
{
	public function __construct()
	{
		parent::__construct('CreateReservation');

		$this->SetParticipants(array());
		$this->SetInvitees(array());
	}
	
	protected function GetPresenter()
	{
		$preconditionService = new NewReservationPreconditionService($this->permissionServiceFactory);
		
		return new ReservationPresenter(
			$this, 
			$this->initializationFactory,
			$preconditionService);
	}

	protected function GetTemplateName()
	{
		return 'Reservation/create.tpl';
	}
	
	protected function GetReservationAction()
	{
		return ReservationAction::Create;
	}
	
	public function GetRequestedResourceId()
	{
		return $this->server->GetQuerystring(QueryStringKeys::RESOURCE_ID);
	}
	
	public function GetRequestedScheduleId()
	{
		return $this->server->GetQuerystring(QueryStringKeys::SCHEDULE_ID);
	}
	
	public function GetReservationDate()
	{
		$timezone = ServiceLocator::GetServer()->GetUserSession()->Timezone;
		$dateTimeString = $this->server->GetQuerystring(QueryStringKeys::RESERVATION_DATE);

		return new Date($dateTimeString, $timezone);
	}
	
	public function GetStartDate()
	{
		$timezone = ServiceLocator::GetServer()->GetUserSession()->Timezone;
		$dateTimeString = $this->server->GetQuerystring(QueryStringKeys::START_DATE);
		
		return new Date($dateTimeString, $timezone);
	}
	
	public function GetEndDate()
	{
		$timezone = ServiceLocator::GetServer()->GetUserSession()->Timezone;
		$dateTimeString = $this->server->GetQuerystring(QueryStringKeys::END_DATE);

		return new Date($dateTimeString, $timezone);
	}
}
?>