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

require_once(ROOT_DIR . 'lib/external/Slim/Slim.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class SlimWebServiceRegistry
{
	/**
	 * @var Slim\Slim
	 */
	private $slim;

	/**
	 * @var array|SlimWebServiceRegistryCategory[]
	 */
	private $categories = array();

	/**
	 * @var array
	 */
	private $secureRoutes = array();

	/**
	 * @var array
	 */
	private $adminRoutes = array();

	public function __construct(Slim\Slim $slim)
	{
		$this->slim = $slim;
	}

	/**
	 * @param SlimWebServiceRegistryCategory $category
	 */
	public function AddCategory(SlimWebServiceRegistryCategory $category)
	{
		foreach ($category->Gets() as $registration)
		{
			$this->slim->get($registration->Route(), $registration->Callback())->name($registration->RouteName());
			$this->SecureRegistration($registration);
		}

		foreach ($category->Posts() as $registration)
		{
			$this->slim->post($registration->Route(), $registration->Callback())->name($registration->RouteName());
			$this->SecureRegistration($registration);
		}

		foreach ($category->Deletes() as $registration)
		{
			$this->slim->delete($registration->Route(), $registration->Callback())->name($registration->RouteName());
			$this->SecureRegistration($registration);
		}

		$this->categories[] = $category;
	}

	/**
	 * @return SlimWebServiceRegistryCategory[]
	 */
	public function Categories()
	{
		$categories = $this->categories;

		usort($categories, function ($a, $b)
		{
			/**
			 * @var $a SlimWebServiceRegistryCategory
			 * @var $b SlimWebServiceRegistryCategory
			 */

			return ($a->Name() < $b->Name()) ? -1 : 1;
		});

		return $categories;
	}

	/**
	 * @param string $routeName
	 * @return bool
	 */
	public function IsSecure($routeName)
	{
		return array_key_exists($routeName, $this->secureRoutes);
	}

	/**
	 * @param string $routeName
	 * @return bool
	 */
	public function IsLimitedToAdmin($routeName)
	{
		return array_key_exists($routeName, $this->adminRoutes);
	}

	private function SecureRegistration(SlimServiceRegistration $registration)
	{
		if ($registration->IsSecure())
		{
			$this->secureRoutes[$registration->RouteName()] = true;
		}

		if ($registration->IsLimitedToAdmin())
		{
			$this->adminRoutes[$registration->RouteName()] = true;
		}
	}
}

