<?php
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationCreatedEmailAdmin.php');
require_once(ROOT_DIR . 'lib/Email/Messages/ReservationUpdatedEmailAdmin.php');

abstract class AdminEmailNotification implements IReservationNotification
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
	public function Notify($reservationSeries)
	{
		if (!$this->ShouldSend())
		{
			return;
		}

		$admins = $this->_userRepo->GetResourceAdmins($reservationSeries->ResourceId());
		$owner = $this->_userRepo->LoadById($reservationSeries->UserId());
		$resource = $this->_resourceRepo->LoadById($reservationSeries->ResourceId());
			
		foreach ($admins as $admin)
		{
			$message = $this->GetMessage($admin, $owner, $reservationSeries, $resource);
			ServiceLocator::GetEmailService()->Send($message);
		}
	}

	/**
	 * @return IEmailMessage
	 */
	protected abstract function GetMessage($admin, $owner, $reservationSeries, $resource);

	/**
	 * @return bool
	 */
	protected abstract function ShouldSend();
}

class AdminEmailCreatedNotification extends AdminEmailNotification
{
	protected function GetMessage($admin, $owner, $reservationSeries, $resource)
	{
		return new ReservationCreatedEmailAdmin($admin, $owner, $reservationSeries, $resource);
	}
	
	protected function ShouldSend()
	{
		return Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_NOTIFY_CREATED, new BooleanConverter());
	}
}

class AdminEmailUpdatedNotification extends AdminEmailNotification
{
	protected function GetMessage($admin, $owner, $reservationSeries, $resource)
	{
		return new ReservationUpdatedEmailAdmin($admin, $owner, $reservationSeries, $resource);
	}
	
	protected function ShouldSend()
	{
		return Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_NOTIFY_UPDATED, new BooleanConverter());
	}
}
?>