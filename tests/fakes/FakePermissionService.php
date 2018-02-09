<?php
/**
Copyright 2012-2018 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Application/Authorization/namespace.php');

class FakePermissionService implements IPermissionService
{
	/**
	 * @var array|IResource[]
	 */
	public $Resources;

	/**
	 * @var UserSession
	 */
	public $User;

	/**
	 * @var array|bool[]
	 */
	public $ReturnValues = array();

	private $_invocationCount = 0;

	/**
	 * @param $returnValues array|bool[]
	 */
	public function __construct($returnValues = array())
	{
		$this->ReturnValues = $returnValues;
	}

	public function CanAccessResource(IPermissibleResource $resource, UserSession $user)
	{
		$this->Resources[] = $resource;
		$this->User = $user;

		return $this->ReturnValues[$this->_invocationCount++];
	}
}

class FakePermissionServiceFactory implements IPermissionServiceFactory
{

	/**
	 * @var IPermissionService
	 */
	public $service;

	/**
	 * @return IPermissionService
	 */
	function GetPermissionService()
	{
		return ($this->service == null) ? new FakePermissionService() : $this->service;
	}
}
?>