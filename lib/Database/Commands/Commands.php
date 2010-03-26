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
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));	
	}
}

class CheckEmailCommand extends SqlCommand
{
	public function __construct($emailAddress)
	{
		parent::__construct(Queries::CHECK_EMAIL);
		$this->AddParameter(new Parameter(ParameterNames::EMAIL_ADDRESS, strtolower($emailAddress)));	
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

class GetAllUsersByStatusCommand extends SqlCommand
{
	public function __construct($userStatusId)
	{
		parent::__construct(Queries::GET_ALL_USERS_BY_STATUS);
		$this->AddParameter(new Parameter(ParameterNames::USER_STATUS_ID, $userStatusId));
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

class GetLayoutCommand extends SqlCommand
{
	public function __construct($scheduleId)
	{
		parent::__construct(Queries::GET_SCHEDULE_TIME_BLOCK_GROUPS);
		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_ID, $scheduleId));
	}
}

class GetReservationsCommand extends SqlCommand
{
	public function __construct($startDate, $endDate, $scheduleId)
	{
		parent::__construct(Queries::GET_RESERVATIONS_COMMAND);
		$this->AddParameter(new Parameter(ParameterNames::START_DATE, $startDate->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::END_DATE, $endDate->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_ID, $scheduleId));
	}
}

class GetScheduleResourcesCommand extends SqlCommand
{
	public function __construct($scheduleId)
	{
		parent::__construct(Queries::GET_RESOURCE_SCHEDULES);
		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_ID, $scheduleId));
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
	public function __construct($username, $email, $fname, $lname, $password, $salt, $timezone, $homepageId, $phone, $institution, $position, $userStatusId)
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
		$this->AddParameter(new Parameter(ParameterNames::USER_STATUS_ID, $userStatusId));
	}
}

class RegisterMiniUserCommand extends SqlCommand 
{
	public function __construct($username, $email, $fname, $lname, $password, $salt, $timezone, $userStatusId, $userRoleId)
	{
		parent::__construct(Queries::REGISTER_MINI_USER);
		
		$this->AddParameter(new Parameter(ParameterNames::USER_NAME, $username));	
		$this->AddParameter(new Parameter(ParameterNames::EMAIL_ADDRESS, $email));
		$this->AddParameter(new Parameter(ParameterNames::FIRST_NAME, $fname));
		$this->AddParameter(new Parameter(ParameterNames::LAST_NAME, $lname));
		$this->AddParameter(new Parameter(ParameterNames::PASSWORD, $password));
		$this->AddParameter(new Parameter(ParameterNames::SALT, $salt));
		$this->AddParameter(new Parameter(ParameterNames::TIMEZONE, $timezone));
		$this->AddParameter(new Parameter(ParameterNames::USER_STATUS_ID, $userStatusId));
		$this->AddParameter(new Parameter(ParameterNames::USER_ROLE_ID, $userRoleId));
	}
}

class ResourceEditCommand extends SqlCommand 
{
	public function __construct($name, $location, $contact_info, $description, $notes, $isactive, 
								$min_duration, $min_increment, $max_duration, $unit_cost, $autoassign, 
								$requires_approval, $allow_multiple_day_reservations, $max_participants, 
								$min_notice_time, $max_notice_time)//, $long_quota_id, $day_quota_id)
	{
		parent::__construct(Queries::EDIT_RESOURCE);
		
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_NAME, $name));	
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_LOCATION, $location));
		$this->AddParameter(new Parameter(ParameterNames::CONTACT_INFO, $contact_info));
		$this->AddParameter(new Parameter(ParameterNames::DESCRIPTION, $description));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_NOTES, $notes));
		$this->AddParameter(new Parameter(ParameterNames::IS_ACTIVE, $isactive));
		$this->AddParameter(new Parameter(ParameterNames::MIN_DURATION, $min_duration));
		$this->AddParameter(new Parameter(ParameterNames::MIN_INCREMENT, $min_increment));
		$this->AddParameter(new Parameter(ParameterNames::MAX_DURATION, $max_duration));
		$this->AddParameter(new Parameter(ParameterNames::UNIT_COST, $unit_cost));
		$this->AddParameter(new Parameter(ParameterNames::AUTO_ASSIGN, $autoassign));
		$this->AddParameter(new Parameter(ParameterNames::REQUIRES_APPROVAL, $requires_approval));
		$this->AddParameter(new Parameter(ParameterNames::MULTIDAY_RESERVATIONS, $allow_multiple_day_reservations));
		$this->AddParameter(new Parameter(ParameterNames::MAX_PARTICIPANTS, $max_participants));
		$this->AddParameter(new Parameter(ParameterNames::MIN_NOTICE, $min_notice_time));
		$this->AddParameter(new Parameter(ParameterNames::MAX_NOTICE, $max_notice_time));
		/*$this->AddParameter(new Parameter(ParameterNames::RESOURCE_LONG_QUOTA, $long_quota_id));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_DAY_QUOTA, $day_quota_id));*/
	}
}

class SelectUserPermissions extends SqlCommand
{
	public function __construct($userId)
	{
		parent::__construct(Queries::GET_USER_RESOURCE_PERMISSIONS);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));	
	}
}

class SelectUserGroupPermissions extends SqlCommand
{
	public function __construct($userId)
	{
		parent::__construct(Queries::GET_GROUP_RESOURCE_PERMISSIONS);
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));	
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