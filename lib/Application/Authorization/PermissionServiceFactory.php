<?php
interface IPermissionServiceFactory
{
	/**
	 * @return IPermissionService
	 */
	function GetPermissionService();
}

class PermissionServiceFactory implements IPermissionServiceFactory
{
	/**
	 * @return IPermissionService
	 */
	public function GetPermissionService()
	{
		// TODO: Make this pluggable
		$resourcePermissionStore = new ResourcePermissionStore(new ScheduleUserRepository());
		return new PermissionService($resourcePermissionStore);
	}
}
?>