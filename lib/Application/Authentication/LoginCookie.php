<?php

require_once(ROOT_DIR . 'lib/Common/namespace.php');

class LoginCookie extends Cookie
{
    public $UserID;
    public $LastLogin;

    public function __construct($userid, $lastLoginTime)
    {
        $this->UserID = $userid;
        $this->LastLogin = $lastLoginTime;

        parent::__construct(CookieKeys::PERSIST_LOGIN, sprintf('%s|%s', $userid, $lastLoginTime));
    }

    public static function FromValue($cookieValue)
    {
        $cookieParts = explode('|', $cookieValue);

        if (count($cookieParts) == 2) {
            return new LoginCookie($cookieParts[0], $cookieParts[1]);
        }

        return null;
    }
}
