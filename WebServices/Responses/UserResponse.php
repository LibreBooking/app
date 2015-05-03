<?php
/**
Copyright 2012-2015 Nick Korbel

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

require_once(ROOT_DIR . 'WebServices/Responses/CustomAttributeResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/ResourceItemResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/GroupItemResponse.php');

class UserResponse extends RestResponse
{
	public $id;
	public $username;
	public $firstName;
	public $lastName;
	public $emailAddress;
	public $phoneNumber;
	public $lastLogin;
	public $statusId;
	public $timezone;
	public $organization;
	public $position;
	public $language;
	public $icsUrl;
	/** @var array|CustomAttributeResponse[] */
	public $customAttributes = array();
	/** @var array|ResourceItemResponse[] */
	public $permissions = array();
	/** @var array|GroupItemResponse[] */
	public $groups = array();

	public function __construct(IRestServer $server, User $user, IEntityAttributeList $attributes)
	{
		$userId = $user->Id();
		$this->id = $userId;
		$this->emailAddress = $user->EmailAddress();
		$this->firstName = $user->FirstName();
		$this->lastName = $user->LastName();
		$this->language = $user->Language();
		$this->lastLogin = Date::FromDatabase($user->LastLogin())->ToIso();
		$this->organization = $user->GetAttribute(UserAttribute::Organization);
		$this->phoneNumber = $user->GetAttribute(UserAttribute::Phone);
		$this->position = $user->GetAttribute(UserAttribute::Position);
		$this->statusId = $user->StatusId();
		$this->timezone = $user->Timezone();
		$this->username = $user->Username();

		$attributeValues = $attributes->GetAttributes($userId);

		if (!empty($attributeValues))
		{
			foreach ($attributeValues as $av)
			{
				$this->customAttributes[] = new CustomAttributeResponse($server, $av->Id(), $av->Label(), $av->Value());
			}
		}

		foreach ($user->AllowedResourceIds() as $allowedResourceId)
		{
			$this->permissions[] = new ResourceItemResponse($server, $allowedResourceId, '');
		}

		foreach ($user->Groups() as $group)
		{
			$this->groups[] = new GroupItemResponse($server, $group->GroupId, $group->GroupName);
		}

		if ($user->GetIsCalendarSubscriptionAllowed())
		{
			$url = new CalendarSubscriptionUrl($user->GetPublicId(), null, null);
			$this->icsUrl = $url->__toString();
		}
	}

	public static function Example()
	{
		return new ExampleUserResponse();
	}
}

class ExampleUserResponse extends UserResponse
{
	public function __construct()
	{
		$date = Date::Now()->ToIso();
		$this->id = 1;
		$this->emailAddress = 'email@address.com';
		$this->firstName = 'first';
		$this->lastName = 'last';
		$this->language = 'language_code';
		$this->lastLogin = $date;
		$this->organization = 'organization';
		$this->phoneNumber = 'phone';
		$this->statusId = 'statusId';
		$this->timezone = 'timezone';
		$this->username = 'username';
		$this->position = 'position';
		$this->icsUrl = 'webcal://url/to/calendar';
		$this->customAttributes = array(CustomAttributeResponse::Example());
		$this->permissions = array(ResourceItemResponse::Example());
		$this->groups = array(GroupItemResponse::Example());

	}
}

?>