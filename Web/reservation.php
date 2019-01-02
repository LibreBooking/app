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

define('ROOT_DIR', '../');

require_once(ROOT_DIR . 'Pages/Reservation/NewReservationPage.php');
require_once(ROOT_DIR . 'Pages/Reservation/ExistingReservationPage.php');

$server = ServiceLocator::GetServer();

if (!is_null($server->GetQuerystring(QueryStringKeys::REFERENCE_NUMBER)))
{
	$page = new SecurePageDecorator(new ExistingReservationPage());
}
else if(!is_null($server->GetQuerystring(QueryStringKeys::SOURCE_REFERENCE_NUMBER)))
{
	$page = new SecurePageDecorator(new DuplicateReservationPage());
}
else
{
	$page = new SecurePageDecorator(new NewReservationPage());
}

$page->PageLoad();