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

require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');

class FakeAuth implements IAuthentication
{
	public $_LastLogin;
	public $_LastPassword;
	public $_LastPersist;
	public $_LastLoginId;
	public $_CookieLoginCalled = false;
	public $_LastLoginCookie;
	public $_CookieValidateResult = false;
	public $_LoginCalled = false;
    
	public $_ValidateResult = false;
	
	public function Validate($username, $password)
	{
		$this->_LastLogin = $username;
		$this->_LastPassword = $password;
		
		return $this->_ValidateResult;
	}
	
	public function Login($username, $persist)
	{
        $this->_LoginCalled = true;
		$this->_LastLogin = $username;
		$this->_LastPersist = $persist;
	}
	
	public function Logout(UserSession $user)
	{
		
	}
	
	public function CookieLogin($cookie)
	{
		$this->_CookieLoginCalled = true;
		$this->_LastLoginCookie = $cookie;
		
		return $this->_CookieValidateResult;
	}
	
	public function AreCredentialsKnown()
	{
		return true;
	}
	
	public function HandleLoginFailure(ILoginPage $loginPage)
	{
		
	}
}
?>