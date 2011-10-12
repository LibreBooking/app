<?php 

class ReservationInitializerFactory implements IReservationInitializerFactory
{
	/**
	 * @var IScheduleUserRepository
	 */
	private $_scheduleUserRepository;

	/**
	 * @var IScheduleRepository
	 */
	private $_scheduleRepository;

	/**
	 * @var IUserRepository
	 */
	private $_userRepository;

	/**
	 * @var IResourceService
	 */
	private $_resourceService;

	/**
	 * @var IReservationAuthorization
	 */
	private $_reservationAuthorization;

	public function __construct(
		IScheduleUserRepository $scheduleUserRepository,
		IScheduleRepository $scheduleRepository,
		IUserRepository $userRepository,
		IResourceService $resourceService,
		IReservationAuthorization $reservationAuthorization
	)
	{
		$this->_scheduleUserRepository = $scheduleUserRepository;
		$this->_scheduleRepository = $scheduleRepository;
		$this->_userRepository = $userRepository;
		$this->_resourceService = $resourceService;
		$this->_reservationAuthorization = $reservationAuthorization;
	}

	public function GetNewInitializer(INewReservationPage $page)
	{
		return new NewReservationInitializer($page,
			$this->_scheduleRepository,
			$this->_userRepository,
			$this->_resourceService,
			$this->_reservationAuthorization);
	}

	public function GetExisitingInitializer(IExistingReservationPage $page, ReservationView $reservationView)
	{
		return new ExistingReservationInitializer($page,
			$this->_scheduleRepository,
			$this->_userRepository,
			$this->_resourceService,
			$reservationView,
			$this->_reservationAuthorization);
	}
}

?>