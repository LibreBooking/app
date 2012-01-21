<?php
/**
Copyright 2012 Nick Korbel

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

interface ILoginContext
{
	/**
	 * @abstract
	 * @return Server
	 */
	public function GetServer();

	/**
	 * @abstract
	 * @return LoginData
	 */
	public function GetData();
}

class LoginData
{
	/**
	 * @var bool
	 */
	public $Persist;

	/**
	 * @var string
	 */
	public $Language;

	public function __construct($persist = false, $language = '')
	{
		$this->Persist = $persist;
		$this->Language = $language;
	}
}

class WebLoginContext implements ILoginContext
{
	/**
	 * @var Server
	 */
	private $server;

	/**
	 * @var LoginData
	 */
	private $data;

	public function __construct(Server $server, LoginData $data)
	{
		$this->server = $server;
		$this->data = $data;
	}

	/**
	 * @return Server
	 */
	public function GetServer()
	{
		return $this->server;
	}

	/**
	 * @return LoginData
	 */
	public function GetData()
	{
		return $this->data;
	}
}

?>