<?php
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/ReservationEvents.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationCreatedEmail.php');

abstract class OwnerEmailNotification implements IReservationNotification
{
	/**
	 * @var IUserRepository
	 */
	private $_userRepo;
	
	/**
	 * @param IUserRepository $userRepo
	 */
	public function __construct(IUserRepository $userRepo)
	{
		$this->_userRepo = $userRepo;
	}

	/**
	 * @param ReservationSeries $reservation
	 * @return void
	 */
	public function Notify($reservation)
	{
		$owner = $this->_userRepo->LoadById($reservation->UserId());
		if ($this->ShouldSend($owner))
		{
			$resource = $reservation->Resource();
			
			$message = $this->GetMessage($owner, $reservation, $resource);
			ServiceLocator::GetEmailService()->Send($message);
		}
	}
	
	/**
	 * @abstract
	 * @param $owner User
	 * @return bool
	 */
	protected abstract function ShouldSend(User $owner);
	
	/**
	 * @abstract
	 * @param $owner User
	 * @param $reservation ReservationSeries
	 * @param $resource BookableResource
	 * @return EmailMessage
	 */
	protected abstract function GetMessage(User $owner, ReservationSeries $reservation, BookableResource $resource);
}

class OwnerEmailCreatedNotification extends OwnerEmailNotification
{
	protected function ShouldSend(User $owner)
	{
		return $owner->WantsEventEmail(new ReservationCreatedEvent());
	}
	
	protected function GetMessage(User $owner, ReservationSeries $reservation, BookableResource $resource)
	{
		return new ReservationCreatedEmail($owner, $reservation, $resource);	
	}	
}

class OwnerEmailUpdatedNotification extends OwnerEmailNotification
{
	protected function ShouldSend(User $owner)
	{
		return $owner->WantsEventEmail(new ReservationUpdatedEvent());
	}
	
	protected function GetMessage(User $owner, ReservationSeries $reservation, BookableResource $resource)
	{
		return new ReservationUpdatedEmail($owner, $reservation, $resource);	
	}	
}

class OwnerEmailApprovedNotification extends OwnerEmailNotification
{
	/**
	 * @param $owner User
	 * @return bool
	 */
	protected function ShouldSend(User $owner)
	{
		return $owner->WantsEventEmail(new ReservationApprovedEvent());
	}

	/**
	 * @param $owner User
	 * @param $reservation ReservationSeries
	 * @param $resource BookableResource
	 * @return EmailMessage
	 */
	protected function GetMessage(User $owner, ReservationSeries $reservation, BookableResource $resource)
	{
		return new ReservationApprovedEmail($owner, $reservation, $resource);
	}
}
?>