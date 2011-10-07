<?php

class AuthorizationServiceFactory
{
	/**
	 * @return IAuthorizationService
	 */
	public function GetAuthorizationService()
	{
		return PluginManager::Instance()->LoadAuthorization();
	}
}