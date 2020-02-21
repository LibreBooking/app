<?php
/**
Copyright 2012-2020 Nick Korbel

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

class SlimWebServiceRegistryCategory
{
	private $gets = array();
	private $posts = array();
	private $deletes = array();

	public function __construct($name)
	{
		$this->name = $name;
	}

	/**
	 * @return array|SlimServiceRegistration[]
	 */
	public function Gets()
	{
		return $this->gets;
	}

	/**
	 * @return array|SlimServiceRegistration[]
	 */
	public function Posts()
	{
		return $this->posts;
	}

	/**
	 * @return array|SlimServiceRegistration[]
	 */
	public function Deletes()
	{
		return $this->deletes;
	}

	public function AddGet($route, $callback, $routeName)
	{
		$this->gets[] = new SlimServiceRegistration($this->name, $route, $callback, $routeName);
	}

	public function AddPost($route, $callback, $routeName)
	{
		$this->posts[] = new SlimServiceRegistration($this->name, $route, $callback, $routeName);
	}

	public function AddDelete($route, $callback, $routeName)
	{
		$this->deletes[] = new SlimServiceRegistration($this->name, $route, $callback, $routeName);
	}

	public function AddSecureGet($route, $callback, $routeName)
	{
		$this->gets[] = new SlimSecureServiceRegistration($this->name, $route, $callback, $routeName);
	}

	public function AddSecurePost($route, $callback, $routeName)
	{
		$this->posts[] = new SlimSecureServiceRegistration($this->name, $route, $callback, $routeName);
	}

	public function AddSecureDelete($route, $callback, $routeName)
	{
		$this->deletes[] = new SlimSecureServiceRegistration($this->name, $route, $callback, $routeName);
	}

	public function AddAdminGet($route, $callback, $routeName)
	{
		$this->gets[] = new SlimAdminServiceRegistration($this->name, $route, $callback, $routeName);
	}

	public function AddAdminPost($route, $callback, $routeName)
	{
		$this->posts[] = new SlimAdminServiceRegistration($this->name, $route, $callback, $routeName);
	}

	public function AddAdminDelete($route, $callback, $routeName)
	{
		$this->deletes[] = new SlimAdminServiceRegistration($this->name, $route, $callback, $routeName);
	}

	/**
	 * @return mixed
	 */
	public function Name()
	{
		return $this->name;
	}
}

