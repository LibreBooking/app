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

require_once(ROOT_DIR . 'Domain/Values/AccountStatus.php');
require_once(ROOT_DIR . 'Domain/Values/InvitationAction.php');
require_once(ROOT_DIR . 'Domain/Values/ReservationUserLevel.php');
require_once(ROOT_DIR . 'Domain/Values/ReservationStatus.php');
require_once(ROOT_DIR . 'Domain/Values/ResourceLevel.php');
require_once(ROOT_DIR . 'Domain/Values/SeriesUpdateScope.php');
require_once(ROOT_DIR . 'Domain/Values/AttributeValue.php');
require_once(ROOT_DIR . 'Domain/Values/AttributeEntityValue.php');
require_once(ROOT_DIR . 'Domain/Values/ReservationColorRule.php');

require_once(ROOT_DIR . 'Domain/Schedule.php');
require_once(ROOT_DIR . 'Domain/BookableResource.php');
require_once(ROOT_DIR . 'Domain/ReservationTypes.php');
require_once(ROOT_DIR . 'Domain/SchedulePeriod.php');
require_once(ROOT_DIR . 'Domain/ScheduleLayout.php');
require_once(ROOT_DIR . 'Domain/Reservation.php');
require_once(ROOT_DIR . 'Domain/ReservationSeries.php');
require_once(ROOT_DIR . 'Domain/ExistingReservationSeries.php');
require_once(ROOT_DIR . 'Domain/RepeatOptions.php');
require_once(ROOT_DIR . 'Domain/User.php');
require_once(ROOT_DIR . 'Domain/Group.php');
require_once(ROOT_DIR . 'Domain/Quota.php');
require_once(ROOT_DIR . 'Domain/ReservationAttachment.php');
require_once(ROOT_DIR . 'Domain/ReservationAttachment.php');