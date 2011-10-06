<?php
interface IPermissionServiceFactory
{
	/**
	 * @param int $userId
	 * @return IPermissionService
	 */
	function GetPermissionService($userId);
}

class PermissionServiceFactory implements IPermissionServiceFactory
{
	/**
	 * @see IPermissionServiceFactory::GetPermissionService()
	 */
	public function GetPermissionService($userId)
	{
		// TODO: Make this pluggable
		$resourcePermissionStore = new ResourcePermissionStore(new ScheduleUserRepository());
		return new PermissionService($resourcePermissionStore, $userId);
	}
}
?>