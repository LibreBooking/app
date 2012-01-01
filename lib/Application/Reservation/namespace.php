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

require_once(ROOT_DIR . 'lib/Application/Reservation/ReservationAuthorization.php');

require_once(ROOT_DIR . 'lib/Application/Reservation/IReservationInitializer.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/IReservationInitializerFactory.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/IReservationPreconditionService.php');

require_once(ROOT_DIR . 'lib/Application/Reservation/NewReservationInitializer.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/ExistingReservationInitializer.php');

require_once(ROOT_DIR . 'lib/Application/Reservation/ReservationInitializerFactory.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/ReservationPreconditionService.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/ReservationResource.php');

require_once(ROOT_DIR . 'lib/Application/Reservation/ReservationAction.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/ReservationEvents.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/ManageBlackoutsService.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/ReservationConflictResolution.php');

?>