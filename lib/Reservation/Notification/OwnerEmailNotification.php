<?php

class OwnerEmailNotificaiton implements IReservationNotification 
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
		$owner = $this->_userRepo->LoadById($reservation->UserId());
		if ($owner->WantsEventEmail(new ReservationCreatedEvent()))
		{
			$resource = $this->_resourceRepo->LoadById($reservation->ResourceId());
			
			$message = new ReservationCreatedEmail($owner, $reservation, $resource);
			ServiceLocator::GetEmailService()->Send($message);
		}
	}
}
?>