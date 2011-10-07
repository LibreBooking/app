<?php

interface IAuthorizationService
{
	/**
	 * @abstract
	 * @param UserSession $reserver user who is requesting access to perform action
	 * @return bool
	 */
	public function CanReserveForOthers(UserSession $reserver);
	
	/**
	 * @abstract
	 * @param UserSession $reserver user who is requesting access to perform action
	 * @param int $reserveFor user to reserve for
	 * @return bool
	 */
	public function CanReserveFor(UserSession $reserver, $reserveFor);

	/**
	 * @abstract
	 * @param UserSession $approver user who is requesting access to perform action
	 * @param int $approveFor user to approve for
	 * @return bool
	 */
	public function CanApproveFor(UserSession $approver, $approveFor);
}

class AuthorizationService implements IAuthorizationService
{
	/**
	 * @var \IScheduleUserRepository
	 */
	private $scheduleUserRepository;
	
	public function __construct(IScheduleUserRepository $scheduleUserRepository)
	{
		$this->scheduleUserRepository = $scheduleUserRepository;
	}
	
	/**
	 * @param UserSession $reserver user who is requesting access to perform action
	 * @return bool
	 */
	public function CanReserveForOthers(UserSession $reserver)
	{
		if ($reserver->IsAdmin)
		{
			return true;
		}

		$user = $this->scheduleUserRepository->GetUser($reserver->UserId);

		return $user->IsGroupAdmin();
	}

	/**
	 * @param UserSession $reserver user who is requesting access to perform action
	 * @param int $reserveFor user to reserve for
	 * @return bool
	 */
	public function CanReserveFor(UserSession $reserver, $reserveFor)
	{
		if ($reserver->IsAdmin)
		{
			return true;
		}

		throw new Exception('need to actually check groups');
	}

	/**
	 * @param UserSession $approver user who is requesting access to perform action
	 * @param int $approveFor user to approve for
	 * @return bool
	 */
	public function CanApproveFor(UserSession $approver, $approveFor)
	{
		if ($approver->IsAdmin)
		{
			return true;
		}

		throw new Exception('need to actually check groups');
	}
}
