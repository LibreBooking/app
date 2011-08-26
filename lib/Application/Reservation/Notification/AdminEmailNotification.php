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
	 * @param IUserRepository $userRepo
	 */
	public function __construct(IUserRepository $userRepo)
	{
		$this->_userRepo = $userRepo;
	}


	/**
	 * @param ReservationSeries $reservationSeries
	 * @return
	 */
	public function Notify($reservationSeries)
	{
		if (!$this->ShouldSend())
		{
			return;
		}

		$admins = $this->_userRepo->GetResourceAdmins($reservationSeries->ResourceId());
		$owner = $this->_userRepo->LoadById($reservationSeries->UserId());
		$resource = $reservationSeries->Resource();
			
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