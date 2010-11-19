<?php
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationCreatedEmailAdmin.php');

class AdminEmailNotificaiton implements IReservationNotification 
{
	/**
	 * @var IUserRepository
	 */
	private $_userRepo;
	
	/**
	 * @var IResourceRepository
	 */
	private $_resourceRepo;
	
	/**
	 * @param IUserRepository $userRepo
	 * @param IResourceRepository $resourceRepo
	 */
	public function __construct(IUserRepository $userRepo, IResourceRepository $resourceRepo)
	{
		$this->_userRepo = $userRepo;
		$this->_resourceRepo = $resourceRepo;
	}
	
	/**
	 * @see IReservationNotification::Notify()
	 */
	public function Notify($reservation)
	{
		if (!Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_NOTIFY_CREATED, new BooleanConverter()))
		{
			return;
		}
		
		$admins = $this->_userRepo->GetResourceAdmins($reservation->ResourceId());
		$owner = $this->_userRepo->LoadById($reservation->UserId());
		$resource = $this->_resourceRepo->LoadById($reservation->ResourceId());
			
		foreach ($admins as $admin)
		{
			$message = new ReservationCreatedEmailAdmin($admin, $owner, $reservation, $resource);
			ServiceLocator::GetEmailService()->Send($message);
		}
	}
}
?>