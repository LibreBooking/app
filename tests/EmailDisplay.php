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

define('ROOT_DIR', dirname(__FILE__) . '/../');
require_once(ROOT_DIR . "lib/Email/namespace.php");
require_once(ROOT_DIR . "lib/Email/Messages/ReservationCreatedEmail.php");
require_once(ROOT_DIR . "lib/Email/Messages/ReservationUpdatedEmail.php");
require_once(ROOT_DIR . "Domain/namespace.php");
require_once(ROOT_DIR . "tests/fakes/namespace.php");


$start = Date::Parse('2010-10-05 03:30:00', 'UTC');
$end = Date::Parse('2010-10-06 13:30:00', 'UTC');

$reservation = new ExistingReservationSeries();
$reservation->WithCurrentInstance(new TestReservation("ref", new TestDateRange()));
$reservation->Update(1, 1, 'crazy title', 'super description');
//$reservation->UpdateDuration(new DateRange($start, $end));

$reservation->Repeats(new RepeatDayOfMonth(1, $end->AddDays(100), new DateRange($start, $end)));

$user = new FakeUser();
//$user->SetLanguage('en_gb');

$email = new ReservationUpdatedEmail($user, $reservation, new FakeBookableResource(1, 'name'));
echo $email->Body();

//$emailService = new EmailService();
//$emailService->Send($email);

?>