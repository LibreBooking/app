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

require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Database/namespace.php');
require_once(ROOT_DIR . 'lib/Database/Commands/namespace.php');

require_once(ROOT_DIR . 'Domain/Access/DomainCache.php');
require_once(ROOT_DIR . 'Domain/Access/PageableDataStore.php');
require_once(ROOT_DIR . 'Domain/Access/ScheduleRepository.php');
require_once(ROOT_DIR . 'Domain/Access/ReservationRepository.php');
require_once(ROOT_DIR . 'Domain/Access/ResourceRepository.php');
require_once(ROOT_DIR . 'Domain/Access/ScheduleUserRepository.php');
require_once(ROOT_DIR . 'Domain/Access/UserRepository.php');
require_once(ROOT_DIR . 'Domain/Access/ReservationViewRepository.php');
require_once(ROOT_DIR . 'Domain/Access/GroupRepository.php');
require_once(ROOT_DIR . 'Domain/Access/QuotaRepository.php');
require_once(ROOT_DIR . 'Domain/Access/AccessoryRepository.php');
require_once(ROOT_DIR . 'Domain/Access/BlackoutRepository.php');
require_once(ROOT_DIR . 'Domain/Access/AnnouncementRepository.php');
require_once(ROOT_DIR . 'Domain/Access/AttributeRepository.php');
require_once(ROOT_DIR . 'Domain/Access/ReportingRepository.php');
require_once(ROOT_DIR . 'Domain/Access/UserSessionRepository.php');
require_once(ROOT_DIR . 'Domain/Access/ReminderRepository.php');
require_once(ROOT_DIR . 'Domain/Access/UserPreferenceRepository.php');
require_once(ROOT_DIR . 'Domain/Access/AttributeFilter.php');
require_once(ROOT_DIR . 'Domain/Access/ReservationWaitlistRepository.php');
require_once(ROOT_DIR . 'Domain/Access/PaymentRepository.php');
require_once(ROOT_DIR . 'Domain/Access/CreditRepository.php');
require_once(ROOT_DIR . 'Domain/Access/TermsOfServiceRepository.php');