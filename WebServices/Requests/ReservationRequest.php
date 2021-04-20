<?php

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
