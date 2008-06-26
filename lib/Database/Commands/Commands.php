<?php
require_once(ROOT_DIR . 'lib/Database/SqlCommand.php');

class AuthorizationCommand extends SqlCommand
{
	public function __construct($username)
	{
		parent::__construct(Queries::VALIDATE_USER);
		$this->AddParameter(new Parameter(ParameterNames::USER_NAME, strtolower($username)));	
	}
}

class AutoAssignPermissionsCommand extends SqlCommand 
{
	public function __construct($userId)
	{
		parent::__construct(Queries::AUTO_ASSIGN_PERMISSIONS);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, strtolower($userId)));	
	}
}

class CheckEmailCommand extends SqlCommand
{
	public function __construct($emailAddress)
	{
		parent::__construct(Queries::CHECK_EMAIL);
		$this->AddParameter(new Parameter(ParameterNames::EMAIL_ADDRESS, $emailAddress));	
	}
}

class CheckUserExistanceCommand extends SqlCommand
{
	public function __construct($username, $emailAddress)
	{
		parent::__construct(Queries::CHECK_USER_EXISTANCE);
		$this->AddParameter(new Parameter(ParameterNames::USER_NAME, $username));	
		$this->AddParameter(new Parameter(ParameterNames::EMAIL_ADDRESS, $emailAddress));	
	}
}

class CheckUsernameCommand extends SqlCommand
{
	public function __construct($username)
	{
		parent::__construct(Queries::CHECK_USERNAME);
		$this->AddParameter(new Parameter(ParameterNames::USER_NAME, $username));	
	}
}

class CookieLoginCommand extends SqlCommand
{
	public function __construct($userid)
	{
		parent::__construct(Queries::COOKIE_LOGIN);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userid));	
	}
}

class GetAllSchedulesCommand extends SqlCommand 
{
	public function __construct()
	{
		parent::__construct(Queries::GET_ALL_SCHEDULES);
	}
}

class GetDashboardAnnouncementsCommand extends SqlCommand 
{
	public function __construct($currentDate)
	{
		parent::__construct(Queries::GET_DASHBOARD_ANNOUNCEMENTS);
		$this->AddParameter(new Parameter(ParameterNames::CURRENT_DATE, $currentDate->ToDatabase()));
	}
}

class GetReservationsCommand extends SqlCommand
{
	public function __construct($startDate, $endDate, $scheduleId)
	{
		parent::_construct(Queries::GET_RESERVATIONS_COMMAND);
		$this->AddParameter(new Parameter(ParameterNames::START_DATE), $startDate->ToDatabase());
		$this->AddParameter(new Parameter(ParameterNames::END_DATE), $endDate->ToDatabase());
		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_ID), $scheduleId);
	}
}

class GetUserRoleCommand extends SqlCommand
{
	public function __construct($userid)
	{
		parent::__construct(Queries::GET_USER_ROLES);		
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userid));
	}
}

class LoginCommand extends SqlCommand
{
	public function __construct($username)
	{
		parent::__construct(Queries::LOGIN_USER);
		$this->AddParameter(new Parameter(ParameterNames::USER_NAME, strtolower($username)));		
	}
}

class MigratePasswordCommand extends SqlCommand 
{
	public function __construct($userid, $password, $salt)
	{
		parent::__construct(Queries::MIGRATE_PASSWORD);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userid));
		$this->AddParameter(new Parameter(ParameterNames::PASSWORD, $password));
		$this->AddParameter(new Parameter(ParameterNames::SALT, $salt));
	}
}

class RegisterUserCommand extends SqlCommand 
{
	public function __construct($username, $email, $fname, $lname, $password, $salt, $timezone, $homepageId, $phone, $institution, $position)
	{
		parent::__construct(Queries::REGISTER_USER);
		
		$this->AddParameter(new Parameter(ParameterNames::USER_NAME, $username));	
		$this->AddParameter(new Parameter(ParameterNames::EMAIL_ADDRESS, $email));
		$this->AddParameter(new Parameter(ParameterNames::FIRST_NAME, $fname));
		$this->AddParameter(new Parameter(ParameterNames::LAST_NAME, $lname));
		$this->AddParameter(new Parameter(ParameterNames::PASSWORD, $password));
		$this->AddParameter(new Parameter(ParameterNames::SALT, $salt));
		$this->AddParameter(new Parameter(ParameterNames::TIMEZONE, $timezone));
		$this->AddParameter(new Parameter(ParameterNames::HOMEPAGE_ID, $homepageId));
		$this->AddParameter(new Parameter(ParameterNames::PHONE, $phone));
		$this->AddParameter(new Parameter(ParameterNames::INSTITUTION, $institution));
		$this->AddParameter(new Parameter(ParameterNames::POSITION, $position));	
	}
}

class UpdateLoginTimeCommand extends SqlCommand
{
	public function __construct($userid, $lastlogin)
	{
		parent::__construct(Queries::UPDATE_LOGINTIME);
		$this->AddParameter(new Parameter(ParameterNames::LAST_LOGIN, $lastlogin));
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userid));	
	}
}

class UpdateUserFromLdapCommand extends SqlCommand 
{
	public function __construct($username, $email, $fname, $lname, $password, $salt, $phone, $institution, $position)
	{
		parent::__construct(Queries::UPDATE_USER_BY_USERNAME);
		$this->AddParameter(new Parameter(ParameterNames::USER_NAME, $username));	
		$this->AddParameter(new Parameter(ParameterNames::EMAIL_ADDRESS, $email));
		$this->AddParameter(new Parameter(ParameterNames::FIRST_NAME, $fname));
		$this->AddParameter(new Parameter(ParameterNames::LAST_NAME, $lname));
		$this->AddParameter(new Parameter(ParameterNames::PASSWORD, $password));
		$this->AddParameter(new Parameter(ParameterNames::SALT, $salt));
		$this->AddParameter(new Parameter(ParameterNames::PHONE, $phone));
		$this->AddParameter(new Parameter(ParameterNames::INSTITUTION, $institution));
		$this->AddParameter(new Parameter(ParameterNames::POSITION, $position));
	}
}
?>