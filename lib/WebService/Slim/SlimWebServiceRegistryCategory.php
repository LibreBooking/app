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

class SlimWebServiceRegistryCategory
{
	private $gets = array();
	private $posts = array();

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

	public function AddGet($route, $callback)
	{
		$this->gets[] = new SlimServiceRegistration($this->name, $route, $callback);
	}

	public function AddPost($route, $callback)
	{
		$this->posts[] = new SlimServiceRegistration($this->name, $route, $callback);
	}

	/**
	 * @return mixed
	 */
	public function Name()
	{
		return $this->name;
	}
}

?>