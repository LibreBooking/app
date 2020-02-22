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
require_once(ROOT_DIR . 'lib/Application/Authentication/CSRFToken.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/IRegistrationNotificationStrategy.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/RegistrationNotificationStrategy.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/IRegistrationPermissionStrategy.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/RegistrationPermissionStrategy.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/GuestUserService.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/GuestRegistrationNotificationStrategy.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/SetAdminFirstRegistrationStrategy.php');