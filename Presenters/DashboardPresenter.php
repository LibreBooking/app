<?php
/**
Copyright 2011-2019 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Database/namespace.php');
require_once(ROOT_DIR . 'lib/Database/Commands/namespace.php');

require_once(ROOT_DIR . 'Controls/Dashboard/AnnouncementsControl.php');
require_once(ROOT_DIR . 'Controls/Dashboard/UpcomingReservations.php');
require_once(ROOT_DIR . 'Controls/Dashboard/ResourceAvailabilityControl.php');

class DashboardPresenter
{
	private $_page;

	public function __construct(IDashboardPage $page)
	{
		$this->_page = $page;
	}

	public function Initialize()
	{
		$announcement = new AnnouncementsControl(new SmartyPage());
		$upcomingReservations = new UpcomingReservations(new SmartyPage());
		$availability = new ResourceAvailabilityControl(new SmartyPage());

		$this->_page->AddItem($announcement);
		$this->_page->AddItem($upcomingReservations);
		$this->_page->AddItem($availability);

		if (ServiceLocator::GetServer()->GetUserSession()->IsAdmin)
		{
			$allUpcomingReservations = new AllUpcomingReservations(new SmartyPage());
			$this->_page->AddItem($allUpcomingReservations);
		}
	}
}