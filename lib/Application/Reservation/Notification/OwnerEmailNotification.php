<?php
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationCreatedEmail.php');

abstract class OwnerEmailNotificaiton implements IReservationNotification 
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
		if ($this->ShouldSend($owner))
		{
			$resource = $this->_resourceRepo->LoadById($reservation->ResourceId());
			
			$message = $this->GetMessage($owner, $reservation, $resource);
			ServiceLocator::GetEmailService()->Send($message);
		}
	}
	
	/**
	 * @return bool
	 */
	protected abstract function ShouldSend($owner);
	
	/**
	 * @return EmailMessage
	 */
	protected abstract function GetMessage($owner, $reservation, $resource);	
}

class OwnerEmailCreatedNotificaiton extends OwnerEmailNotificaiton
{
	protected function ShouldSend($owner)
	{
		return $owner->WantsEventEmail(new ReservationCreatedEvent());
	}
	
	protected function GetMessage($owner, $reservation, $resource)
	{
		return new ReservationCreatedEmail($owner, $reservation, $resource);	
	}	
}

class OwnerEmailUpdatedNotificaiton extends OwnerEmailNotificaiton
{
	protected function ShouldSend($owner)
	{
		return $owner->WantsEventEmail(ReservationUpdatedEvent());
	}
	
	protected function GetMessage($owner, $reservation, $resource)
	{
		return new ReservationUpdatedEmail($owner, $reservation, $resource);	
	}	
}
?>