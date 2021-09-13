<?php

class AuthorizationServiceFactory
{
    /**
     * @return IAuthorizationService
     */
    public static function GetAuthorizationService()
    {
        return PluginManager::Instance()->LoadAuthorization();
    }
}
