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
	public function GetRequestedDate();
}

class NewReservationPage extends ReservationPage implements INewReservationPage
{
	public function __construct()
	{
		parent::__construct('CreateReservation');
	}
	
	protected function GetPresenter()
	{
		$initializationFactory = new ReservationInitializerFactory($this->scheduleUserRepository, $this->scheduleRepository, $this->userRepository);
		$preconditionService = new NewReservationPreconditionService($this->permissionServiceFactory);
		
		return new ReservationPresenter(
			$this, 
			$initializationFactory,
			$preconditionService);
	}

	protected function GetTemplateName()
	{
		return 'Reservation/reservation.tpl';
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
	
	public function GetRequestedDate()
	{
		$dateTimeString = $this->server->GetQuerystring(QueryStringKeys::RESERVATION_DATE);
		$dateTime = new DateTime($dateTimeString);
		$dateString = $dateTime->format(Date::SHORT_FORMAT);
		$timezone = $dateTime->getTimezone()->getName();

		return new Date($dateString, $timezone);
	}
}
?>