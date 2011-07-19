<?php
require_once(ROOT_DIR . 'lib/Email/Messages/InviteeAddedEmail.php');

class InviteeAddedEmailNotification implements IReservationNotification
{
	/**
	 * @var \IUserRepository
	 */
	private $userRepository;

	public function __construct(IUserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

	/**
	 * @param ReservationSeries $reservationSeries
	 */
	function Notify($reservationSeries)
	{
		$owner = null;

		$instance = $reservationSeries->CurrentInstance();
		foreach ($instance->AddedInvitees() as $userId)
		{
			if ($owner == null)
			{
				$owner = $this->userRepository->LoadById($reservationSeries->UserId());
			}

			$invitee = $this->userRepository->LoadById($userId);

			$message = new InviteeAddedEmail($owner, $invitee, $reservationSeries);
			ServiceLocator::GetEmailService()->Send($message);
		}
	}
}
?>