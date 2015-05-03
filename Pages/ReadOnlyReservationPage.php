<?php
/**
Copyright 2012-2015 Nick Korbel

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

require_once(ROOT_DIR . 'Pages/Ajax/AutoCompletePage.php');
require_once(ROOT_DIR . 'Pages/NewReservationPage.php');
require_once(ROOT_DIR . 'Pages/ExistingReservationPage.php');
require_once(ROOT_DIR . 'lib/Application/Authorization/ViewSchedulePermissionServiceFactory.php');

class ReadOnlyReservationPage extends ExistingReservationPage
{
	public function __construct()
	{
		$this->permissionServiceFactory = new ViewSchedulePermissionServiceFactory();
		parent::__construct();
		$this->IsEditable = false;
		$this->IsApprovable = false;
	}

	public function PageLoad()
	{
		parent::PageLoad();
	}

	function SetIsEditable($canBeEdited)
	{
		// no-op
	}

	public function SetIsApprovable($canBeApproved)
	{
		// no-op
	}
}


?>