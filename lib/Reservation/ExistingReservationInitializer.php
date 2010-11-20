<?php
require_once(ROOT_DIR . 'lib/Reservation/ReservationInitializerBase.php');
require_once(ROOT_DIR . 'Pages/ExistingReservationPage.php');

class ExistingReservationInitializer extends ReservationInitializerBase
{
	/**
	 * @var IExistingReservationPage
	 */
	private $page;
	
	/**
	 * @var IReservationViewRepository
	 */
	private $reservationViewRepoistory;
	
	/**
	 * @var ReservationView
	 */
	private $reservationView;
	
	public function __construct(
		IExistingReservationPage $page, 
		IScheduleUserRepository $scheduleUserRepository,
		IScheduleRepository $scheduleRepository,
		IUserRepository $userRepository,
		IReservationViewRepository $reservationViewRepository
		)
	{
		$this->page = $page;
		$this->reservationViewRepoistory = $reservationViewRepository;
		
		parent::__construct(
						$page, 
						$scheduleUserRepository, 
						$scheduleRepository, 
						$userRepository);
	}
	
	public function Initialize()
	{
		$this->reservationView = $this->reservationViewRepoistory->GetReservationForEditing($this->page->GetReferenceNumber());
		parent::Initialize();
		
		$this->page->SetAdditionalResources($this->reservationView->AdditionalResourceIds);
		$this->page->SetParticipants($this->reservationView->ParticipantIds);
		$this->page->SetTitle($this->reservationView->Title);
		$this->page->SetDescription($this->reservationView->Description);
	}
	
	protected function GetOwnerId()
	{
		return $this->reservationView->OwnerId;
	}
	
	protected function GetResourceId()
	{
		return $this->reservationView->ResourceId;
	}
	
	protected function GetScheduleId()
	{
		return $this->reservationView->ScheduleId;
	}
	
	protected function GetStartDate()
	{
		return $this->reservationView->StartDate;
	}
	
	protected function GetEndDate()
	{
		return $this->reservationView->EndDate;
	}
	
	protected function GetTimezone()
	{
		return ServiceLocator::GetServer()->GetUserSession()->Timezone;
	}
}
?>