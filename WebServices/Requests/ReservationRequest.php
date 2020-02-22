<?php
/**
 * Copyright 2012-2020 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'WebServices/Requests/ReservationAccessoryRequest.php');
require_once(ROOT_DIR . 'WebServices/Requests/CustomAttributes/AttributeValueRequest.php');
require_once(ROOT_DIR . 'WebServices/Responses/RecurrenceRequestResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/ReminderRequestResponse.php');
require_once(ROOT_DIR . 'WebServices/Responses/Reservation/ReservationRetryParameterRequestResponse.php');

class ReservationRequest
{
	/**
	 * @var array|ReservationAccessoryRequest[]
	 */
	public $accessories = array();
	/**
	 * @var array|AttributeValueRequest[]
	 */
	public $customAttributes = array();
	public $description;
	public $endDateTime;
	/**
	 * @var array|int[]
	 */
	public $invitees = array();
	/**
	 * @var array|int[]
	 */
	public $participants = array();
	/**
	 * @var array|string[]
	 */
	public $participatingGuests = array();
	/**
	 * @var array|string[]
	 */
	public $invitedGuests = array();
	/**
	 * @var RecurrenceRequestResponse
	 */
	public $recurrenceRule;
	public $resourceId;
	/**
	 * @var array|int[]
	 */
	public $resources = array();
	public $startDateTime;
	public $title;
	public $userId;
	/**
	 * @var ReminderRequestResponse
	 */
	public $startReminder;
	/**
	 * @var ReminderRequestResponse
	 */
	public $endReminder;

	/**
	 * @var bool
	 */
	public $allowParticipation;

	/**
	 * @var ReservationRetryParameterRequestResponse[]
	 */
	public $retryParameters;
    /**
     * @var bool
     */
    public $termsAccepted;

    public static function Example()
	{
		$date = Date::Now()->ToIso();
		$request = new ReservationRequest();
		$request->accessories = array(new ReservationAccessoryRequest(1, 2));
		$request->customAttributes = array(new AttributeValueRequest(2, 'some value'));
		$request->description = 'reservation description';
		$request->endDateTime = $date;
		$request->invitees = array(1, 2, 3);
		$request->participants = array(1, 2);
		$request->participatingGuests = array('participating.guest@email.com');
		$request->invitedGuests = array('invited.guest@email.com');
		$request->recurrenceRule = RecurrenceRequestResponse::Example();
		$request->resourceId = 1;
		$request->resources = array(2, 3);
		$request->startDateTime = $date;
		$request->title = 'reservation title';
		$request->userId = 1;
		$request->startReminder = ReminderRequestResponse::Example();
		$request->allowParticipation = true;
		$request->retryParameters = array(ReservationRetryParameterRequestResponse::Example());
		$request->termsAccepted = true;

		return $request;
	}
}