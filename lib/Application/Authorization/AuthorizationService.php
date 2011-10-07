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
	 * @param IScheduleUser $reserveFor user to reserve for
	 * @return bool
	 */
	public function CanReserveFor(UserSession $reserver, IScheduleUser $reserveFor);

	/**
	 * @abstract
	 * @param UserSession $approver user who is requesting access to perform action
	 * @param IScheduleUser $approveFor user to approve for
	 * @return bool
	 */
	public function CanApproveFor(UserSession $approver, IScheduleUser $approveFor);
}

class AuthorizationService implements IAuthorizationService
{
	/**
	 * @param UserSession $reserver user who is requesting access to perform action
	 * @return bool
	 */
	public function CanReserveForOthers(UserSession $reserver)
	{
		// TODO: Implement CanReserveForOthers() method.
	}

	/**
	 * @param UserSession $reserver user who is requesting access to perform action
	 * @param IScheduleUser $reserveFor user to reserve for
	 * @return bool
	 */
	public function CanReserveFor(UserSession $reserver, IScheduleUser $reserveFor)
	{
		// TODO: Implement CanReserveFor() method.
	}

	/**
	 * @param UserSession $approver user who is requesting access to perform action
	 * @param IScheduleUser $approveFor user to approve for
	 * @return bool
	 */
	public function CanApproveFor(UserSession $approver, IScheduleUser $approveFor)
	{
		// TODO: Implement CanApproveFor() method.
	}
}
