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

require_once(ROOT_DIR . 'lib/Server/namespace.php');

class FakeServer extends Server
{
	public $Cookies = array();
	public $Session = array();
	public $Post = array();
	public $Get = array();
	public $Form = array();

	/**
	 * @var UserSession
	 */
	public $UserSession;

	public function FakeServer()
	{
		$this->UserSession = new FakeUserSession();
		$this->SetSession(SessionKeys::USER_SESSION, $this->UserSession);
	}

	public function SetCookie(Cookie $cookie)
	{
		$this->Cookies[$cookie->Name] = $cookie;
	}

    /**
     * @param string $name
     * @return string
     */
	public function GetCookie($name)
	{
		if (array_key_exists($name, $this->Cookies)) {
			$cookie = $this->Cookies[$name];
			if (!is_null($cookie)) {
				return $cookie->Value;
			}
		}

		return null;
	}

	public function SetSession($name, $value)
	{
		$this->Session[$name] = $value;
	}

	public function GetSession($name)
	{
		if (array_key_exists($name, $this->Session)) {
			return $this->Session[$name];
		}
		return null;
	}

	public function SetQuerystring($name, $value)
	{
		$this->Get[$name] = $value;
	}

	public function GetQuerystring($name)
	{
		if (isset($this->Get[$name])) {
			return $this->Get[$name];
		}
		return null;
	}

	public function SetForm($name, $value)
	{
		$this->Form[$name] = $value;
	}

	public function GetForm($name)
	{
		if (isset($this->Form[$name])) {
			return $this->Form[$name];
		}

		return null;
	}

	public function SetUserSession($userSession)
	{
		$this->UserSession = $userSession;
	}

	public function GetUserSession()
	{
		return $this->UserSession;
	}

    public function GetLanguage()
    {
        return 'en_us';
    }

    public function GetRemoteAddress()
    {
        return 'localhost';
    }
}

?>