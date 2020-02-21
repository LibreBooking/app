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

require_once(ROOT_DIR . 'lib/Common/Validators/IValidator.php');
require_once(ROOT_DIR . 'lib/Common/Validators/ValidatorBase.php');
require_once(ROOT_DIR . 'lib/Common/Validators/PageValidators.php');
require_once(ROOT_DIR . 'lib/Common/Validators/EmailValidator.php');
require_once(ROOT_DIR . 'lib/Common/Validators/RequiredValidator.php');
require_once(ROOT_DIR . 'lib/Common/Validators/EqualValidator.php');
require_once(ROOT_DIR . 'lib/Common/Validators/RegexValidator.php');
require_once(ROOT_DIR . 'lib/Common/Validators/UniqueEmailValidator.php');
require_once(ROOT_DIR . 'lib/Common/Validators/UniqueUserNameValidator.php');
require_once(ROOT_DIR . 'lib/Common/Validators/PasswordValidator.php');
require_once(ROOT_DIR . 'lib/Common/Validators/CaptchaValidator.php');
require_once(ROOT_DIR . 'lib/Common/Validators/LayoutValidator.php');
require_once(ROOT_DIR . 'lib/Common/Validators/FileTypeValidator.php');
require_once(ROOT_DIR . 'lib/Common/Validators/FileUploadValidator.php');
require_once(ROOT_DIR . 'lib/Common/Validators/PasswordComplexityValidator.php');
require_once(ROOT_DIR . 'lib/Common/Validators/FileExtensionValidator.php');
require_once(ROOT_DIR . 'lib/Common/Validators/RequiredEmailDomainValidator.php');
require_once(ROOT_DIR . 'lib/Common/Validators/TermsOfServiceValidator.php');
require_once(ROOT_DIR . 'lib/Common/Validators/RestrictedGuestValidator.php');