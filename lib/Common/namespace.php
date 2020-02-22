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

require_once(ROOT_DIR . 'lib/Common/Helpers/namespace.php');
require_once(ROOT_DIR . 'lib/Common/LoginTime.php');
require_once(ROOT_DIR . 'lib/Common/SmartyPage.php');
require_once(ROOT_DIR . 'lib/Common/Resources.php');
require_once(ROOT_DIR . 'lib/Common/ServiceLocator.php');
require_once(ROOT_DIR . 'lib/Common/Date.php');
require_once(ROOT_DIR . 'lib/Common/Time.php');
require_once(ROOT_DIR . 'lib/Common/TimeInterval.php');
require_once(ROOT_DIR . 'lib/Common/DateRange.php');
require_once(ROOT_DIR . 'lib/Common/GlobalKeys.php');
require_once(ROOT_DIR . 'lib/Common/PluginManager.php');
require_once(ROOT_DIR . 'lib/Common/ErrorMessages.php');
require_once(ROOT_DIR . 'lib/Common/Logging/Log.php');
require_once(ROOT_DIR . 'lib/Common/Logging/ExceptionHandler.php');
require_once(ROOT_DIR . 'lib/Common/ContrastingColor.php');