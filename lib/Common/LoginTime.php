<?php

class LoginTime
{
    /**
     * @var null
     * Only for testing
     */
    public static $Now = null;

    private static $_format = 'Y-m-d H:i:s';

    public static function Now()
    {
        if (empty(self::$Now)) {
            return Date::Now()->ToDatabase();
        } else {
            return date(self::$_format, self::$Now);
        }
    }
}
