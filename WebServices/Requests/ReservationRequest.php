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

require_once(ROOT_DIR . 'WebServices/Requests/ReservationAccessoryRequest.php');
require_once(ROOT_DIR . 'WebServices/Requests/AttributeValueRequest.php');

class ReservationRequest
{
	/**
	 * @var array|ReservationAccessoryRequest[]
	 */
	public $accessories = array();
	/**
	 * @var array|AttributeValueRequest[]
	 */
	public $attributes = array();
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
	public $repeatInterval;
	public $repeatMonthlyType;
	public $repeatType;
	/**
	 * @var array|int[]
	 */
	public $repeatWeekdays = array();
	public $repeatTerminationDate;
	public $resourceId;
	/**
	 * @var array|int[]
	 */
	public $resources = array();
	public $startDateTime;
	public $title;
	public $userId;

	public static function Example()
	{
		$date = Date::Now()->ToIso();
		$request = new ReservationRequest();
		$request->accessories = array(new ReservationAccessoryRequest(1, 2));
		$request->attributes = array(new AttributeValueRequest(2, 'some value'));
		$request->description = 'reservation description';
		$request->endDateTime = $date;
		$request->invitees = array(1,2,3);
		$request->participants = array(1,2);
		$request->repeatInterval = 1;
		$request->repeatMonthlyType = RepeatMonthlyType::DayOfMonth . '|' . RepeatMonthlyType::DayOfWeek . '|null';
		$request->repeatType = RepeatType::Daily . '|' . RepeatType::Monthly . '|' . RepeatType::None . '|' . RepeatType::Weekly . '|' . RepeatType::Yearly;
		$request->repeatWeekdays = array(0,1,2,3,4,5,6);
		$request->repeatTerminationDate = $date;
		$request->resourceId = 1;
		$request->resources = array(2,3);
		$request->startDateTime = $date;
		$request->title = 'reservation title';
		$request->userId = 1;

		return $request;
	}
}

?>