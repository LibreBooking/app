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

class FakeRegistration implements IRegistration
{
	public $_RegisterCalled = false;
	public $_UserExists = true;
	public $_ExistsCalled = false;
	public $_SynchronizeCalled = false;
	public $_LastLogin;
	public $_LastEmail;
	public $_Login;
	public $_Email;
	public $_First;
	public $_Last;
	public $_Password;
	public $_Timezone;
	public $_AdditionalFields;
	public $_HomepageId;
	public $_LastSynchronizedUser;
	public $_RegisteredUser;

	public function __construct()
	{
		$this->_RegisteredUser = new FakeUser(1);
	}
	/**
	 * @var array|AttributeValue[]
	 */
	public $_AttributeValues = array();

	public function Register($login, $email, $firstName, $lastName, $password, $timezone, $language, $homepageId, $additionalFields = array(), $attributes = array())
	{
		$this->_RegisterCalled = true;
		$this->_Login = $login;
		$this->_Email = $email;
		$this->_First = $firstName;
		$this->_Last = $lastName;
		$this->_Password = $password;
		$this->_Timezone = $timezone;
		$this->_HomepageId = $homepageId;
		$this->_AdditionalFields = $additionalFields;
		$this->_AttributeValues = $attributes;

		return $this->_RegisteredUser;
	}
	
	public function UserExists($loginName, $emailAddress)
	{
		$this->_ExistsCalled = true;
		$this->_LastLogin = $loginName;
		$this->_LastEmail = $emailAddress;
		
		return $this->_UserExists;
	}

	public function Synchronize(AuthenticatedUser $user)
	{
		$this->_SynchronizeCalled = true;
		$this->_LastSynchronizedUser = $user;
	}
}
?>