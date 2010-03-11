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
	
	public function __construct(
					IScheduleUserRepository $scheduleUserRepository, 
					IScheduleRepository $scheduleRepository,
					IUserRepository $userRepository)
	{
		$this->_scheduleUserRepository = $scheduleUserRepository;
		$this->_scheduleRepository = $scheduleRepository;
		$this->_userRepository = $userRepository;
	}
	
	/**
	 * @see IReservationInitializerFactory::GetInitializer()
	 */
	public function GetInitializer(IReservationPage $page)
	{
		return new NewReservationInitializer($page, 
			$this->_scheduleUserRepository, 
			$this->_scheduleRepository,
			$this->_userRepository);
	}
}

?>