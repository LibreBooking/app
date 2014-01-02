<?php
/**
Copyright 2011-2014 Nick Korbel

This file is part of Booked SchedulerBooked SchedulereIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later versBooked SchedulerduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
alBooked SchedulercheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'lib/Application/Authentication/ILoginContext.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/IAuthentication.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/WebLoginContext.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/WebAuthentication.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/WebServiceAuthentication.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/Authentication.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/PasswordEncryption.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/Password.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/LoginCookie.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/IRegistration.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/Registration.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/AuthenticatedUser.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/CaptchaService.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/IAccountActivation.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/AccountActivation.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/IPostRegistration.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/PostRegistration.php');
?>