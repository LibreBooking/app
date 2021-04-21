<?php

class CSRFToken
{
    /**
     * @var string
     */
    public static $_Token;

    /**
     * @return string
     */
    public static function Create()
    {
        if (!empty(self::$_Token)) {
            return self::$_Token;
        }

        return base64_encode(md5(BookedStringHelper::Random()));
    }
}
