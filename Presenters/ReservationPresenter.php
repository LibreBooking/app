<?php 
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Server/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Reservation/namespace.php');

class ReservationPresenter implements IReservationPresenter
{
	/**
	 * @var IReservationPage
	 */
	private $_page;
	
	/**
	 * @var IReservationInitializerFactory
	 */
	private $_initilizationFactory;
	
	/**
	 * @var IReservationPreconditionService
	 */
	private $_precondtionService;
	
	public function __construct(
		IReservationPage $page, 
		IReservationInitializerFactory $initializationFactory,
		IReservationPreconditionService $precondtionService)
	{
		$this->_page = $page;
		$this->_initilizationFactory = $initializationFactory;
		$this->_preconditionService = $precondtionService;
	}
	
	public function PageLoad()
	{
		/*
		$user = ServiceLocator::GetServer()->GetUserSession();
		$timezone = $user->Timezone;
		$userId = $user->UserId;
		
		$requestedResourceId = $this->_page->GetRequestedResourceId();
		$requestedScheduleId = $this->_page->GetRequestedScheduleId();
		$requestedStartDate = $this->_page->GetRequestedDate();
		$requestedPeriodId = $this->_page->GetRequestedPeriod();
		*/
		
		$this->_preconditionService->CheckAll($this->_page);
		$initializer = $this->_initilizationFactory->GetInitializer($this->_page);
		$initializer->Initialize();
	}
}

interface IReservationPresenter
{}

class ReservationResource implements IResource
{
	private $_id;
	
	public function __construct($resourceId)
	{
		$this->_id = $resourceId;
	}
	
	/**
	 * @see IResource::GetResourceId()
	 */
	public function GetResourceId()
	{
		return $this->_id;
	}
	
	/**
	 * This will always be an empty string
	 * 
	 * @see IResource::GetName()
	 */
	public function GetName()
	{
		return "";
	}
}
?>