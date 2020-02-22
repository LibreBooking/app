<?php
/**
Copyright 2011-2020 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'lib/Application/Schedule/ResourceService.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/ScheduleReservationList.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/IReservationSlot.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/ReservationSlot.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/EmptyReservationSlot.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/BlackoutSlot.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/BufferSlot.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/ReservationListingFactory.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/ReservationService.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/IReservationListing.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/ReservationListItem.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/ReservationListing.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/DailyLayout.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/ICalendarSegment.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/CalendarDay.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/CalendarWeek.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/CalendarMonth.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/CalendarReservation.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/CalendarSubscriptionUrl.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/iCalendarReservationView.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/CalendarSubscriptionService.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/CalendarSubscriptionValidator.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/CalendarFactory.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/ScheduleLayoutSerializable.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/DailyReservationSummary.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/ScheduleResourceFilter.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/ScheduleService.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/SchedulePermissionService.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/DisplaySlotFactory.php');