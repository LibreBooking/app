<?php

class WebServiceExpiration
{
    private static $SESSION_LENGTH_IN_MINUTES = 30;

    public function __construct()
    {
        self::$SESSION_LENGTH_IN_MINUTES = Configuration::Instance()->GetKey(ConfigKeys::INACTIVITY_TIMEOUT, new IntConverter());
    }

    /**
     * @param string $expirationTime
     * @return bool
     */
    public static function IsExpired($expirationTime)
    {
        return Date::Parse($expirationTime, 'UTC')->LessThan(Date::Now());
    }

    /**
     * @return string
     */
    public static function Create()
    {
        return Date::Now()->AddMinutes(self::$SESSION_LENGTH_IN_MINUTES)->ToUtc()->ToIso();
    }
}
