<?php
require_once(ROOT_DIR . 'lib/Database/SqlCommand.php');

//MPinnegar
//TO-DO: Move this into alphabetical order
class GetAllReservationsByUserCommand /*Give it a very literal name describing what the command is going to do*/extends SqlCommand
{
    //You need to build the constructor so that the command can be put together. The "heavy lifting" is done by SqlCommand.php and the info comes from DataConstant.php
    public function __contruct($userId) //List each parameter to your query. Generally if you are "getting" something from the database you'll only need to pass in whatever columns are the primary keys. Later on down the line these variables you pass in to the constructor will be used to replace @ symbol variables in the SQL query  
    {
        //Use the method on the superclass parent so that the query will be put together properly. The GET_ALL_RESERVATIONS_BY_USER is where the actual text of the SQL query is written
        parent::__construct(Queries::GET_ALL_RESERVATIONS_BY_USER);
        //Here we add the variable to the SQL statement. I assume behind the scenes that the @userId is replaced by the actual userId that we pass in as a string
        //The Parameter::USERNAME tells the Parameter constructor which of the @symbols to replace with the string contained inside of $userId. In this case it will replace @userId
        $this->AddParameter(new Parameter(ParameterNames::USERNAME, $userId));
        //Now you're done! You've essentially "built" the query by first constructing the SQL query with a bunch of empty variables in it, and then by using AddParameter() to replace those variables with actual values
    }
}

class AddReservationSeriesCommand extends SqlCommand
{
	public function __construct(Date $dateCreatedUtc, 
								$title, 
								$description, 
								$repeatType,
								$repeatOptions,
								$scheduleId,
								$reservationTypeId,
								$statusId,
								$ownerId
								)
	{
		parent::__construct(Queries::ADD_RESERVATION_SERIES);	
		
		$this->AddParameter(new Parameter(ParameterNames::DATE_CREATED, $dateCreatedUtc->ToDatabase()));	
		$this->AddParameter(new Parameter(ParameterNames::TITLE, $title));	
		$this->AddParameter(new Parameter(ParameterNames::DESCRIPTION, $description));	
		$this->AddParameter(new Parameter(ParameterNames::REPEAT_TYPE, $repeatType));	
		$this->AddParameter(new Parameter(ParameterNames::REPEAT_OPTIONS, $repeatOptions));	
		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_ID, $scheduleId));	
		$this->AddParameter(new Parameter(ParameterNames::TYPE_ID, $reservationTypeId));	
		$this->AddParameter(new Parameter(ParameterNames::STATUS_ID, $statusId));	
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $ownerId));	
	}
}

class AddReservationResourceCommand extends SqlCommand
{
	public function __construct($seriesId, $resourceId, $resourceLevelId)
	{
		parent::__construct(Queries::ADD_RESERVATION_RESOURCE);
		
		$this->AddParameter(new Parameter(ParameterNames::SERIES_ID, $seriesId));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_ID, $resourceId));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_LEVEL_ID, $resourceLevelId));
	}
}

class AddReservationCommand extends SqlCommand
{
	public function __construct(Date $startDateUtc, 
								Date $endDateUtc,
								$referenceNumber,
								$seriesId)
	{
		parent::__construct(Queries::ADD_RESERVATION);
		$this->AddParameter(new Parameter(ParameterNames::START_DATE, $startDateUtc->ToDatabase()));	
		$this->AddParameter(new Parameter(ParameterNames::END_DATE, $endDateUtc->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::REFERENCE_NUMBER, $referenceNumber));		
		$this->AddParameter(new Parameter(ParameterNames::SERIES_ID, $seriesId));	
	}
}

class AddReservationUserCommand extends SqlCommand
{
	public function __construct($instanceId, $userId, $levelId)
	{
		parent::__construct(Queries::ADD_RESERVATION_USER);
		
		$this->AddParameter(new Parameter(ParameterNames::RESERVATION_INSTANCE_ID, $instanceId));
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userId));
		$this->AddParameter(new Parameter(ParameterNames::RESERVATION_USER_LEVEL_ID, $levelId));
	}
}

class AddResourceCommand extends SqlCommand 
{
	public function __construct($name, $location, $contact_info, $description, $notes, $isactive, 
								$min_duration, $min_increment, $max_duration, $unit_cost, $autoassign, 
								$requires_approval, $allow_multiday, $max_participants, 
								$min_notice_time, $max_notice_time)
	{
		parent::__construct(Queries::ADD_RESOURCE);
		
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_NAME, $name));	
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_LOCATION, $location));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_CONTACT, $contact_info));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_DESCRIPTION, $description));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_NOTES, $notes));
		$this->AddParameter(new Parameter(ParameterNames::IS_ACTIVE, $isactive));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_MINDURATION, $min_duration));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_MININCREMENT, $min_increment));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_MAXDURATION, $max_duration));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_COST, $unit_cost));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_AUTOASSIGN, $autoassign));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_REQUIRES_APPROVAL, $requires_approval));
		$this->AddParameter(new Parameter(ParameterNames::RESOURE_ALLOW_MULTIDAY, $allow_multiday));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_MAX_PARTICIPANTS, $max_participants));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_MINNOTICE, $min_notice_time));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_MAXNOTICE, $max_notice_time));
	}
}

class AuthorizationCommand extends SqlCommand
{
	public function __construct($username)
	{
		parent::__construct(Queries::VALIDATE_USER);
		$this->AddParameter(new Parameter(ParameterNames::USERNAME, strtolower($username)));	
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
		$this->AddParameter(new Parameter(ParameterNames::USERNAME, $username));	
		$this->AddParameter(new Parameter(ParameterNames::EMAIL_ADDRESS, $emailAddress));	
	}
}

class CheckUsernameCommand extends SqlCommand
{
	public function __construct($username)
	{
		parent::__construct(Queries::CHECK_USERNAME);
		$this->AddParameter(new Parameter(ParameterNames::USERNAME, $username));	
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

class GetReservationForEditingCommand extends SqlCommand
{
	public function __construct($referenceNumber)
	{
		parent::__construct(Queries::GET_RESERVATION_FOR_EDITING);
		$this->AddParameter(new Parameter(ParameterNames::REFERENCE_NUMBER, $referenceNumber));
		$this->AddParameter(new Parameter(ParameterNames::RESERVATION_USER_LEVEL_ID, ReservationUserLevel::OWNER));
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_LEVEL_ID, ResourceLevel::Primary));
	}
}

class GetReservationParticipantsCommand extends SqlCommand
{
	public function __construct($instanceId)
	{
		parent::__construct(Queries::GET_RESERVATION_PARTICIPANTS);
		$this->AddParameter(new Parameter(ParameterNames::RESERVATION_INSTANCE_ID, $instanceId));
	}
}

class GetReservationResourcesCommand extends SqlCommand
{
	public function __construct($seriesId)
	{
		parent::__construct(Queries::GET_RESERVATION_RESOURCES);
		$this->AddParameter(new Parameter(ParameterNames::SERIES_ID, $seriesId));
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

class GetReservationByIdCommand extends SqlCommand
{
	public function __construct($reservationId)
	{
		parent::__construct(Queries::GET_RESERVATION_BY_ID);
		$this->AddParameter(new Parameter(ParameterNames::RESERVATION_INSTANCE_ID, $reservationId));
	}
}

class GetReservationSeriesInstances extends SqlCommand
{
	public function __construct($seriesId)
	{
		parent::__construct(Queries::GET_RESERVATION_SERIES_INSTANCES);
		$this->AddParameter(new Parameter(ParameterNames::SERIES_ID, $seriesId));
	}
}

class GetResourceByIdCommand extends SqlCommand
{
	public function __construct($resourceId)
	{
		parent::__construct(Queries::GET_RESOURCE_BY_ID);
		$this->AddParameter(new Parameter(ParameterNames::RESOURCE_ID, $resourceId));
	}
}


class GetScheduleResourcesCommand extends SqlCommand
{
	public function __construct($scheduleId)
	{
		parent::__construct(Queries::GET_SCHEDULE_RESOURCES);
		$this->AddParameter(new Parameter(ParameterNames::SCHEDULE_ID, $scheduleId));
	}
}

class GetUserByIdCommand extends SqlCommand
{
	public function __construct($userid)
	{
		parent::__construct(Queries::GET_USER_BY_ID);		
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userid));
	}
}

class GetUserEmailPreferencesCommand extends SqlCommand
{
	public function __construct($userid)
	{
		parent::__construct(Queries::GET_USER_EMAIL_PREFERENCES);		
		$this->AddParameter(new Parameter(ParameterNames::USER_ID, $userid));
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
		$this->AddParameter(new Parameter(ParameterNames::USERNAME, strtolower($username)));		
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

class RegisterFormSettingsCommand extends SqlCommand 
{
	public function __construct($firstName, $lastName, $username, $email, $password, $organization, $group, $position, $address, $phone, $homepage, $timezone)
	{
		parent::__construct(Queries::REGISTER_FORM_SETTINGS);
		
		$this->AddParameter(new Parameter(ParameterNames::FIRST_NAME_SETTING, $fname));
		$this->AddParameter(new Parameter(ParameterNames::LAST_NAME_SETTING, $lname));
		$this->AddParameter(new Parameter(ParameterNames::USERNAME_SETTING, $username));	
		$this->AddParameter(new Parameter(ParameterNames::EMAIL_ADDRESS_SETTING, $email));
		$this->AddParameter(new Parameter(ParameterNames::PASSWORD_SETTING, $password));
		$this->AddParameter(new Parameter(ParameterNames::ORGANIZATION_SELECTION_SETTING, $organization));
		$this->AddParameter(new Parameter(ParameterNames::GROUP_SETTING, $group));
		$this->AddParameter(new Parameter(ParameterNames::POSITION_SETTING, $position));
		$this->AddParameter(new Parameter(ParameterNames::ADDRESS_SETTING, $address));
		$this->AddParameter(new Parameter(ParameterNames::PHONE_SETTING, $phone));
		$this->AddParameter(new Parameter(ParameterNames::HOMEPAGE_SELECTION_SETTING, $homepage));
		$this->AddParameter(new Parameter(ParameterNames::TIMEZONE_SELECTION_SETTING, $timezone));
	}
}

class RegisterMiniUserCommand extends SqlCommand 
{
	public function __construct($username, $email, $fname, $lname, $password, $salt, $timezone, $userStatusId, $userRoleId, $language)
	{
		parent::__construct(Queries::REGISTER_MINI_USER);
		
		$this->AddParameter(new Parameter(ParameterNames::USERNAME, $username));	
		$this->AddParameter(new Parameter(ParameterNames::EMAIL_ADDRESS, $email));
		$this->AddParameter(new Parameter(ParameterNames::FIRST_NAME, $fname));
		$this->AddParameter(new Parameter(ParameterNames::LAST_NAME, $lname));
		$this->AddParameter(new Parameter(ParameterNames::PASSWORD, $password));
		$this->AddParameter(new Parameter(ParameterNames::SALT, $salt));
		$this->AddParameter(new Parameter(ParameterNames::TIMEZONE_NAME, $timezone));
		$this->AddParameter(new Parameter(ParameterNames::LANGUAGE, $language));
		$this->AddParameter(new Parameter(ParameterNames::USER_STATUS_ID, $userStatusId));
		$this->AddParameter(new Parameter(ParameterNames::USER_ROLE_ID, $userRoleId));
	}
}

class RegisterUserCommand extends SqlCommand 
{
	public function __construct($username, $email, $fname, $lname, $password, $salt, $timezone, $language, $homepageId, $phone, $institution, $position, $userStatusId)
	{
		parent::__construct(Queries::REGISTER_USER);
		
		$this->AddParameter(new Parameter(ParameterNames::USERNAME, $username));	
		$this->AddParameter(new Parameter(ParameterNames::EMAIL_ADDRESS, $email));
		$this->AddParameter(new Parameter(ParameterNames::FIRST_NAME, $fname));
		$this->AddParameter(new Parameter(ParameterNames::LAST_NAME, $lname));
		$this->AddParameter(new Parameter(ParameterNames::PASSWORD, $password));
		$this->AddParameter(new Parameter(ParameterNames::SALT, $salt));
		$this->AddParameter(new Parameter(ParameterNames::TIMEZONE_NAME, $timezone));
		$this->AddParameter(new Parameter(ParameterNames::LANGUAGE, $language));
		$this->AddParameter(new Parameter(ParameterNames::HOMEPAGE_ID, $homepageId));
		$this->AddParameter(new Parameter(ParameterNames::PHONE, $phone));
		$this->AddParameter(new Parameter(ParameterNames::ORGANIZATION, $institution));
		$this->AddParameter(new Parameter(ParameterNames::POSITION, $position));	
		$this->AddParameter(new Parameter(ParameterNames::USER_STATUS_ID, $userStatusId));
	}
}

class RemoveReservationCommand extends SqlCommand
{
	public function __construct($referenceNumber)
	{
		parent::__construct(Queries::REMOVE_RESERVATION_INSTANCE);
		
		$this->AddParameter(new Parameter(ParameterNames::REFERENCE_NUMBER, $referenceNumber));
	}
}

class ReportingCommand extends SqlCommand 
{
	public function __construct($fname, $lname, $username, $organization, $group)
	{
		parent::__construct(Queries::GET_REPORT);
		
		$this->AddParameter(new Parameter(ParameterNames::FIRST_NAME, $fname));
		$this->AddParameter(new Parameter(ParameterNames::LAST_NAME, $lname));
		$this->AddParameter(new Parameter(ParameterNames::USERNAME, $username));	
		$this->AddParameter(new Parameter(ParameterNames::ORGANIZATION, $organization));
		$this->AddParameter(new Parameter(ParameterNames::GROUP, $group));	
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

class UpdateFutureReservationsCommand extends SqlCommand
{
	public function __construct($referenceNumber, $newSeriesId, $currentSeriesId)
	{
		parent::__construct(Queries::UPDATE_FUTURE_RESERVATION_INSTANCES);	
		
		$this->AddParameter(new Parameter(ParameterNames::REFERENCE_NUMBER, $referenceNumber));
		$this->AddParameter(new Parameter(ParameterNames::SERIES_ID, $currentSeriesId));
		$this->AddParameter(new Parameter(ParameterNames::CURRENT_SERIES_ID, $currentSeriesId));
	}
}

class UpdateReservationCommand extends SqlCommand
{
	public function __construct($referenceNumber,
								$seriesId,
								Date $startDate, 
								Date $endDate)
	{
		parent::__construct(Queries::UPDATE_RESERVATION_INSTANCE);	
		
		$this->AddParameter(new Parameter(ParameterNames::REFERENCE_NUMBER, $referenceNumber));
		$this->AddParameter(new Parameter(ParameterNames::SERIES_ID, $seriesId));
		$this->AddParameter(new Parameter(ParameterNames::START_DATE, $startDate->ToDatabase()));
		$this->AddParameter(new Parameter(ParameterNames::END_DATE, $endDate->ToDatabase()));
	}
}

class UpdateReservationSeriesCommand extends SqlCommand
{
	public function __construct($seriesId,
								$title, 
								$description, 
								$repeatType,
								$repeatOptions,
								Date $dateModified								
								)
	{
		parent::__construct(Queries::UPDATE_RESERVATION_SERIES);	
		
		$this->AddParameter(new Parameter(ParameterNames::SERIES_ID, $seriesId));
		$this->AddParameter(new Parameter(ParameterNames::TITLE, $title));	
		$this->AddParameter(new Parameter(ParameterNames::DESCRIPTION, $description));	
		$this->AddParameter(new Parameter(ParameterNames::REPEAT_TYPE, $repeatType));	
		$this->AddParameter(new Parameter(ParameterNames::REPEAT_OPTIONS, $repeatOptions));
		$this->AddParameter(new Parameter(ParameterNames::DATE_MODIFIED, $dateModified->ToDatabase()));	
	}
}

class UpdateUserFromLdapCommand extends SqlCommand 
{
	public function __construct($username, $email, $fname, $lname, $password, $salt, $phone, $organization, $position)
	{
		parent::__construct(Queries::UPDATE_USER_BY_USERNAME);
		$this->AddParameter(new Parameter(ParameterNames::USERNAME, $username));	
		$this->AddParameter(new Parameter(ParameterNames::EMAIL_ADDRESS, $email));
		$this->AddParameter(new Parameter(ParameterNames::FIRST_NAME, $fname));
		$this->AddParameter(new Parameter(ParameterNames::LAST_NAME, $lname));
		$this->AddParameter(new Parameter(ParameterNames::PASSWORD, $password));
		$this->AddParameter(new Parameter(ParameterNames::SALT, $salt));
		$this->AddParameter(new Parameter(ParameterNames::PHONE, $phone));
		$this->AddParameter(new Parameter(ParameterNames::ORGANIZATION, $organization));
		$this->AddParameter(new Parameter(ParameterNames::POSITION, $position));
	}
}
?>