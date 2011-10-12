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
	
	/**
	 * @param $canBeEdited bool
	 */
	function SetIsEditable($canBeEdited);

	/**
	 * @abstract
	 * @param $canBeApproved bool
	 * @return void
	 */
	function SetIsApprovable($canBeApproved);

	/**
	 * @param $amIParticipating
	 */
	function SetCurrentUserParticipating($amIParticipating);

	/**
	 * @param $amIInvited
	 */
	function SetCurrentUserInvited($amIInvited);
}

class ExistingReservationPage extends ReservationPage implements IExistingReservationPage
{
	private $IsEditable = false;
	private $IsApprovable = false;
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function PageLoad()
	{
		parent::PageLoad();
	}
	
	protected function GetPresenter()
	{
		$preconditionService = new EditReservationPreconditionService($this->permissionServiceFactory);
		$reservationViewRepository = new ReservationViewRepository();
		
		return new EditReservationPresenter($this,
										 $this->initializationFactory,
										 $preconditionService,
										 $reservationViewRepository);
	}

	protected function GetTemplateName()
	{
		if ($this->IsApprovable)
		{
			return 'Reservation/approve.tpl';
		}
		if ($this->IsEditable)
		{
			return 'Reservation/edit.tpl';
		}
		return 'Reservation/view.tpl';
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
	
	function SetIsEditable($canBeEdited)
	{
		$this->IsEditable = $canBeEdited;
	}

	/**
	 * @param $amIParticipating
	 */
	function SetCurrentUserParticipating($amIParticipating)
	{
		$this->Set('IAmParticipating', $amIParticipating);
	}

	/**
	 * @param $amIInvited
	 */
	function SetCurrentUserInvited($amIInvited)
	{
		$this->Set('IAmInvited', $amIInvited);
	}

	/**
	 * @param $canBeApproved bool
	 * @return void
	 */
	function SetIsApprovable($canBeApproved)
	{
		$this->IsApprovable = $canBeApproved;
	}
}
?>