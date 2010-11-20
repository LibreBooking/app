<?php 
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Server/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Domain/Access/namespace.php');
//require_once(ROOT_DIR . 'lib/Reservation/namespace.php');

abstract class ReservationPresenterBase implements IReservationPresenter
{
	/**
	 * @var IReservationPage
	 */
	protected $basePage;
	
	/**
	 * @var IReservationInitializerFactory
	 */
	protected $initilizationFactory;
	
	/**
	 * @var IReservationPreconditionService
	 */
	protected $precondtionService;
	
	protected function __construct(IReservationPage $page)
	{
		$this->basePage = $page;
	}
	
	public abstract function PageLoad();
}

class ReservationPresenter extends ReservationPresenterBase
{
	/**
	 * @var INewReservationPage
	 */
	private $_page;

	public function __construct(
		INewReservationPage $page, 
		IReservationInitializerFactory $initializationFactory,
		INewReservationPreconditionService $precondtionService)
	{
		parent::__construct($page, $initializationFactory, $precondtionService);
		
		$this->_page = $page;
		$this->initializationFactory = $initializationFactory;
		$this->preconditionService = $precondtionService;
	}
	
	public function PageLoad()
	{
		$user = ServiceLocator::GetServer()->GetUserSession();

		$this->preconditionService->CheckAll($this->_page, $user);
		$initializer = $this->initializationFactory->GetInitializer($this->_page);
		$initializer->Initialize();
	}
}

interface IReservationPresenter
{}


?>