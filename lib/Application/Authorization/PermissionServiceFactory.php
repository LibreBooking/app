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
		return PluginManager::Instance()->LoadPermission();
	}
}
