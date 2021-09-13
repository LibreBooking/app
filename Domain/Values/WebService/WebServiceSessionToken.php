<?php

require_once(ROOT_DIR . 'lib/Common/namespace.php');

class WebServiceSessionToken
{
    /**
     * Only used for testing
     * @var string
     */
    public static $_Token;

    /**
     * @return string
     */
    public static function Generate()
    {
        if (empty(self::$_Token)) {
            return BookedStringHelper::Random();
        }
        return self::$_Token;
    }
}
