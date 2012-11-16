<?php
/**
Copyright 2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/WebService/namespace.php');
require_once(ROOT_DIR . 'WebServices/Responses/RecurrenceResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/ResourceItemResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/AccessoryItemResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/CustomAttributeResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/AttachmentResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/ReservationUserResponse.php');

class ReservationResponse extends RestResponse
{
	public $referenceNumber;
	public $startDate;
	public $endDate;
	public $firstName;
	public $lastName;
	public $resourceName;
	public $title;
	public $description;
	public $requiresApproval;
	public $isRecurring;
	public $scheduleId;
	public $userId;
	public $resourceId;
	public $owner;
	public $participants = array();
	public $invitees = array();
	public $customAttributes = array();
	public $recurrenceRule;
	public $attachments = array();
	public $resources = array();
	public $accessories = array();

	public function __construct()
	{
		$this->owner = ReservationUserResponse::Masked();
	}

	/**
	 * @param IRestServer $server
	 * @param ReservationView $reservation
	 * @param IPrivacyFilter $privacyFilter
	 * @param array|CustomAttribute[] $attributes
	 */
	public static function Create(IRestServer $server,
								  ReservationView $reservation,
								  IPrivacyFilter $privacyFilter,
								  $attributes = array())
	{
		$canViewUser = $privacyFilter->CanViewUser($server->GetSession(), $reservation);
		$canViewDetails = $privacyFilter->CanViewDetails($server->GetSession(), $reservation);

		$r = new ReservationResponse();

		$r->referenceNumber = $reservation->ReferenceNumber;
		$r->userId = $reservation->OwnerId;
		$r->scheduleId = $reservation->ScheduleId;
		$r->startDate = $reservation->StartDate->ToIso();
		$r->endDate = $reservation->EndDate->ToIso();
		$r->requiresApproval = $reservation->RequiresApproval();
		$r->isRecurring = $reservation->IsRecurring();
		$r->recurrenceRule = new RecurrenceResponse($reservation->RepeatType, $reservation->RepeatInterval, $reservation->RepeatMonthlyType, $reservation->RepeatWeekdays);

		foreach ($reservation->Resources as $resource)
		{
			$r->resources[] = new ResourceItemResponse($server, $resource->Id(), $resource->GetName());
		}

		foreach ($reservation->Accessories as $accessory)
		{
			$r->accessories[] = new AccessoryItemResponse($server, $accessory->AccessoryId, $accessory->Name, $accessory->QuantityReserved);
		}

		if ($canViewDetails)
		{
			$r->title = $reservation->Title;
			$r->description = $reservation->Description;
			foreach ($attributes as $attribute)
			{
				$r->customAttributes[] = new CustomAttributeResponse($server, $attribute->Id(), $attribute->Label(), $reservation->GetAttributeValue($attribute->Id()));
			}
			foreach ($reservation->Attachments as $attachment)
			{
				$r->attachments[] = new AttachmentResponse($server, $attachment->FileId(), $attachment->FileName(), $reservation->ReferenceNumber);
			}
		}

		if ($canViewUser)
		{
			$r->owner = new ReservationUserResponse($server, $reservation->OwnerId, $reservation->OwnerFirstName, $reservation->OwnerLastName, $reservation->OwnerEmailAddress);
			foreach ($reservation->Participants as $participant)
			{
				$r->participants[] = ReservationUserResponse::Create($server, $participant->UserId,
																	 $participant->FirstName,
																	 $participant->LastName, $participant->Email);
			}
			foreach ($reservation->Invitees as $invitee)
			{
				$r->invitees[] = ReservationUserResponse::Create($server, $invitee->UserId,
																 $invitee->FirstName, $invitee->LastName,
																 $invitee->Email);
			}
		}

		return $r;
	}
}

?>