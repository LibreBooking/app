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
	
	/**
	 * @param $repeatType string
	 */
	function SetRepeatType($repeatType);
	
	/**
	 * @param $repeatInterval string
	 */
	function SetRepeatInterval($repeatInterval);
	
	/**
	 * @param $repeatMonthlyType string
	 */
	function SetRepeatMonthlyType($repeatMonthlyType);
	
	/**
	 * @param $repeatTerminationDate Date
	 */
	function SetRepeatTerminationDate($repeatTerminationDate);
	
	/**
	 * @param $repeatWeekdays int[]
	 */
	function SetRepeatWeekdays($repeatWeekdays);
	
	/**
	 * @param $referenceNumber string
	 */
	function SetReferenceNumber($referenceNumber);

	/**
	 * @param $reservationId int
	 */
	function SetReservationId($reservationId);
	
	/**
	 * @param $isRecurring bool
	 */
	function SetIsRecurring($isRecurring);
}

class ExistingReservationPage extends ReservationPage implements IExistingReservationPage
{
	public function __construct()
	{
		parent::__construct('EditReservation');
	}
	
	public function PageLoad()
	{
		parent::PageLoad();
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
		return 'Reservation/edit.tpl';
	}
	
	protected function GetReservationAction()
	{
		return ReservationAction::Update;
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
		$this->Set('ReservationTitle', $title);
	}
	
	public function SetDescription($description)
	{
		$this->Set('Description', $description);
	}
	
	public function SetRepeatType($repeatType)
	{
		$this->Set('RepeatType', $repeatType);
	}
	
	public function SetRepeatInterval($repeatInterval)
	{
		$this->Set('RepeatInterval', $repeatInterval);
	}
	
	public function SetRepeatMonthlyType($repeatMonthlyType)
	{
		$this->Set('RepeatMonthlyType', $repeatMonthlyType);
	}
	
	public function SetRepeatWeekdays($repeatWeekdays)
	{
		$this->Set('RepeatWeekdays', $repeatWeekdays);
	}
	
	public function SetReferenceNumber($referenceNumber)
	{
		$this->Set('ReferenceNumber', $referenceNumber);
	}
	
	function SetReservationId($reservationId)
	{
		$this->Set('ReservationId', $reservationId);
	}
	
	function SetIsRecurring($isRecurring)
	{
		$this->Set('IsRecurring', $isRecurring);
	}
}
?>