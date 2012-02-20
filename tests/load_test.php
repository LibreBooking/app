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

define('ROOT_DIR', dirname(__FILE__) . '/../');

require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

$numberOfResources = 30;
$numberOfUsers = 500;
$numberOfReservations = 5000;

$users = array();
$resources = array();

$db = ServiceLocator::GetDatabase();

// USERS
$db->Execute(new AdHocCommand("delete from users where fname ='load' and lname = 'test'"));
$userRepo = new UserRepository();
for ($i = 0; $i < $numberOfUsers; $i++)
{
	$user = User::Create("load", "test", "email $i", "username $i", "en_us", "America/Chicago", "7b6aec38ff9b7650d64d0374194307bdde711425", "3b3dbb9b");
	$userId = $userRepo->Add($user);
	$users[] = $user;
}

// RESOURCES
$db->Execute(new AdHocCommand("delete from resources where name like 'load%'"));
$resourceRepo = new ResourceRepository();
for ($i = 0; $i < $numberOfResources; $i++)
{
	$resource = BookableResource::CreateNew("load$i", 1);
	$resourceId = $resourceRepo->Add($resource);
	$resources[] = $resource;
}

// RESERVATIONS
$db->Execute(new AdHocCommand("delete from reservation_series where title like 'load%'"));
$scheduleRepo = new ScheduleRepository();
$layout = $scheduleRepo->GetLayout(1, new ScheduleLayoutFactory('America/Chicago'));
$reservationRepo = new ReservationRepository();
$bookedBy = new UserSession(1);
$currentDate = Date::Now();

$i = 0;
while ($i < $numberOfReservations)
{
	$userId = getRandomUserId($users)->Id();
	$resource = getRandomResource($resources);
	$periods = $layout->GetLayout($currentDate);

	foreach ($periods as $period)
	{
		if ($period->IsReservable())
		{
			$date = new DateRange($period->BeginDate(), $period->EndDate(), 'America/Chicago');
			$reservation = ReservationSeries::Create($userId, $resource, "load$i", null, $date, new RepeatNone(), $bookedBy);
			$reservationRepo->Add($reservation);
			$i++;
		}
	}

	$currentDate = $currentDate->AddDays(1);
}

/**
 * @param array|User[] $users
 * @return User
 */
function getRandomUserId($users)
{
	$rand = rand(0, count($users)-1);
	return $users[$rand];
}

/**
 * @param array|BookableResoure[] $resources
 * @return BookableResoure
 */
function getRandomResource($resources)
{
	$rand = rand(0, count($resources)-1);
	return $resources[$rand];
}

?>