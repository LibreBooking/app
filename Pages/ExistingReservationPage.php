<?php
require_once(ROOT_DIR . 'Pages/ReservationPage.php');

interface IExistingReservationPage extends IReservationPage
{
	function GetReferenceNumber();
	
	/**
	 * @param $additionalResourceIds int[]
	 */
	function SetAdditionalResources($additionalResourceIds);
	
	/**
	 * @param $participantIds int[]
	 */
	function SetParticipants($participantIds);
	
	/**
     * @param $title string
	 */
	function SetTitle($title);
	
	/**
     * @param $description string
	 */
	function SetDescription($description);
}

class ExistingReservationPage extends ReservationPage implements IExistingReservationPage
{
	public function __construct()
	{
		parent::__construct('EditReservation');
	}
	
	protected function GetPresenter()
	{
		$initializationFactory = new ReservationInitializerFactory($this->scheduleUserRepository, $this->scheduleRepository, $this->userRepository);
		$preconditionService = new EditReservationPreconditionService($this->permissionServiceFactory);
		$reservationViewRepository = new ReservationViewRepository();
		
		return new EditReservationPresenter($this,
										 $initializationFactory,
										 $preconditionService,
										 $reservationViewRepository);
	}

	protected function GetTemplateName()
	{
		return 'reservation.tpl';
	}
	
	public function GetReferenceNumber()
	{
		return $this->server->GetQuerystring(QueryStringKeys::REFERENCE_NUMBER); 
	}
	
	public function SetAdditionalResources($additionalResourceIds)
	{
		$this->Set('AdditionalResourceIds', $additionalResourceIds);
	}
	
	public function SetParticipants($participantIds)
	{
		$this->Set('ParticipantIds', $participantIds);
	}
	
	public function SetTitle($title)
	{
		$this->Set('Title', $title);
	}
	
	public function SetDescription($description)
	{
		$this->Set('Description', $description);
	}
	
}
?>