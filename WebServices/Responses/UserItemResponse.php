<?php
/**
Copyright 2012-2020 Nick Korbel

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

require_once(ROOT_DIR . 'lib/WebService/namespace.php');

class UserItemResponse extends RestResponse
{
	public $id;
	public $userName;
	public $firstName;
	public $lastName;
	public $emailAddress;
	public $phoneNumber;
	public $dateCreated;
	public $lastLogin;
	public $statusId;
	public $timezone;
	public $organization;
	public $position;
	public $language;
	/** @var array|CustomAttributeResponse[] */
	public $customAttributes = array();
	public $currentCredits;
	public $reservationColor;

	/**
	 * @param IRestServer $server
	 * @param UserItemView $user
	 * @param array|string[] $attributeLabels
	 */
	public function __construct(IRestServer $server, UserItemView $user, $attributeLabels)
	{
		$userId = $user->Id;
		$this->id = $userId;
		$this->dateCreated = $user->DateCreated->ToIso();
		$this->emailAddress = $user->Email;
		$this->firstName = $user->First;
		$this->lastName = $user->Last;
		$this->language = $user->Language;
		$this->lastLogin = $user->LastLogin->ToIso();
		$this->organization = $user->Organization;
		$this->phoneNumber = $user->Phone;
		$this->position = $user->Position;
		$this->statusId = $user->StatusId;
		$this->timezone = $user->Timezone;
		$this->userName = $user->Username;
		$this->currentCredits = $user->CurrentCreditCount;
		$this->reservationColor = $user->ReservationColor;

		if (!empty($attributeLabels))
		{
			foreach($attributeLabels as $id => $label)
			{
				$this->customAttributes[] = new CustomAttributeResponse($server, $id, $label, $user->GetAttributeValue($id));
			}
		}

		$this->AddService($server, WebServices::GetUser, array(WebServiceParams::UserId => $userId));
	}

	public static function Example()
	{
		return new ExampleUserItemResponse();
	}
}

class ExampleUserItemResponse extends UserItemResponse
{
	public function __construct()
	{
		$date = Date::Now()->ToIso();
		$this->id = 1;
		$this->dateCreated = $date;
		$this->emailAddress = 'email@address.com';
		$this->firstName = 'first';
		$this->lastName = 'last';
		$this->language = 'language_code';
		$this->lastLogin = $date;
		$this->organization = 'organization';
		$this->phoneNumber = 'phone';
		$this->statusId = 'statusId';
		$this->timezone = 'timezone';
		$this->userName = 'username';
		$this->position = 'position';
		$this->customAttributes = array(CustomAttributeResponse::Example());
		$this->currentCredits = '2.50';
		$this->reservationColor = '#000000';
	}
}