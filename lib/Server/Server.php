<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */


class Server
{
    public function __construct()
    {
    }

    public function SetCookie(Cookie $cookie)
    {
        setcookie($cookie->Name, $cookie->Value, $cookie->Expiration, $cookie->Path);
    }

    public function GetCookie($name)
    {
        if (isset($_COOKIE[$name]))
        {
            return $_COOKIE[$name];
        }
        return null;
    }

    public function SetSession($name, $value)
    {
        if (!is_null($value))
        {
            @session_start();
        }

        $_SESSION[$name] = $value;
    }

    public function GetSession($name)
    {
        @session_start();
        if (isset($_SESSION[$name]))
        {
            return $_SESSION[$name];
        }
        return null;
    }

    public function GetQuerystring($name)
    {
        if (isset($_GET[$name]))
        {
            return htmlspecialchars($_GET[$name]);
        }
        return null;
    }

    /**
     * This return null or an array of form elements such as email and password and submit
     * @param string $name
     * @return string
     */
    public function GetForm($name)
    {
        if (isset($_POST[$name]))
        {
            if (is_array($_POST[$name]))
            {
                return $_POST[$name];
            }

            return htmlspecialchars($_POST[$name]);
        }
        return null;
    }

    public function GetFile($name)
    {
        if (isset($_FILES[$name]))
        {
            return new UploadedFile($_FILES[$name]);
        }
        return null;
    }

    public function GetUrl()
    {
        $url = htmlspecialchars($_SERVER['PHP_SELF']);

        if (isset($_SERVER['QUERY_STRING']))
        {
            $url .= '?' . htmlspecialchars($_SERVER['QUERY_STRING']);
        }

        return $url;
    }

    /**
     * @return UserSession
     */
    public function GetUserSession()
    {
        $userSession = $this->GetSession(SessionKeys::USER_SESSION);

        if (!empty($userSession))
        {
            return $userSession;
        }

        return new NullUserSession();
    }

    /**
     * @param $userSession UserSession
     * @return void
     */
    public function SetUserSession($userSession)
    {
        $this->SetSession(SessionKeys::USER_SESSION, $userSession);
    }

    /**
     * @return string
     */
    public function GetRequestMethod()
    {
        return $this->GetHeader('REQUEST_METHOD');
    }

    /**
     * @return string
     */
    public function GetLanguage()
    {
        $lang = $this->GetHeader('HTTP_ACCEPT_LANGUAGE');
        if (strlen($lang) > 4)
        {
            return substr(str_replace('-','_', $lang), 0, 5);
        }
        return null;
    }

    /**
     * @param string $headerCode
     * @return string
     */
    public function GetHeader($headerCode)
    {
        return $_SERVER[$headerCode];
    }

    /**
     * @return string
     */
    public function GetRemoteAddress()
    {
        return $this->GetHeader('REMOTE_ADDR');
    }

}

?>