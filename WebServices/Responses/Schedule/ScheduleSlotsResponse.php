<?php

/**
 * Copyright 2014-2020 Nick Korbel
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

class ScheduleSlotResponse extends RestResponse
{
	/**
	 * @var string
	 */
	public $date;

	/**
	 * @var ScheduleSlotResourceResponse[]
	 */
	public $resources;

	public function __construct(IRestServer $server, Date $date)
	{
		$this->date = $date->ToIso();
	}

	public function AddResource(ScheduleSlotResourceResponse $scheduleResource)
	{
		$this->resources[] = $scheduleResource;
	}
}

class ScheduleSlotDetailsResponse extends RestResponse
{
	/**
	 * @var int
	 */
	public $slotSpan;

	/**
	 * @var bool
	 */
	public $isReserved;

	/**
	 * @var string
	 */
	public $label;

	/**
	 * @var bool
	 */
	public $isReservable;

	/**
	 * @var string
	 */
	public $color;

	/**
	 * @var string
	 */
	public $startDateTime;

	/**
	 * @var string
	 */
	public $endDateTime;

	/**
	 * @var ReservationItemResponse|null
	 */
	public $reservation;

	public function __construct(IRestServer $server, IReservationSlot $slot, IPrivacyFilter $privacyFilter)
	{
		$user = $server->GetSession();

		$this->slotSpan = $slot->PeriodSpan();
		$this->isReserved = $slot->IsReserved();
		$this->label = $slot->Label();
		$this->isReservable = $slot->IsReservable();
		$this->color = $slot->Color();
		$this->startDateTime = $slot->BeginDate()->ToIso();
		$this->endDateTime = $slot->EndDate()->ToIso();

		if ($slot->IsReserved())
		{
			/** @var ReservationSlot $slot */
			$reservation = $slot->Reservation();
			$showUser = $privacyFilter->CanViewUser($user, null, $reservation->UserId);
			$showDetails = $privacyFilter->CanViewDetails($user, null, $reservation->UserId);
			$this->reservation = new ReservationItemResponse($reservation, $server, $showUser, $showDetails);
		}
	}
}

class ScheduleSlotResourceResponse extends RestResponse
{
	public $slots = array();

	/**
	 * @var IRestServer
	 */
	private $server;

	/**
	 * @var IPrivacyFilter
	 */
	private $privacyFilter;
	/**
	 * @var int
	 */
	public $resourceId;
	/**
	 * @var string
	 */
	public $resourceName;

	public function __construct(IRestServer $server, ResourceDto $resource, IPrivacyFilter $privacyFilter)
	{
		$this->server = $server;
		$this->privacyFilter = $privacyFilter;

		$this->AddService($server, WebServices::GetResource, array(WebServiceParams::ResourceId => $resource->GetId()));

		$this->resourceId = $resource->GetId();
		$this->resourceName = $resource->GetName();
	}

	public function AddSlot(IReservationSlot $slot)
	{
		$this->slots[] = new ScheduleSlotDetailsResponse($this->server, $slot, $this->privacyFilter);
	}
}

class ScheduleSlotsResponse extends RestResponse
{
	public $dates = array();
	/**
	 * @var int
	 */
	private $scheduleId;

	/**
	 * @param IRestServer $server
	 * @param int $scheduleId
	 * @param IDailyLayout $dailyLayout
	 * @param DateRange $dates
	 * @param ResourceDto[] $resources
	 * @param IPrivacyFilter $privacyFilter
	 */
	public function __construct(IRestServer $server, $scheduleId, IDailyLayout $dailyLayout, DateRange $dates, $resources, IPrivacyFilter $privacyFilter)
	{
		$this->scheduleId = $scheduleId;
		$this->AddService($server, WebServices::GetSchedule, array(WebServiceParams::ScheduleId => $scheduleId));

		foreach ($dates->Dates() as $date)
		{
			$scheduleDate = new ScheduleSlotResponse($server, $date);

			foreach ($resources as $resource)
			{
				$scheduleResource = new ScheduleSlotResourceResponse($server, $resource, $privacyFilter);
				$slots = $dailyLayout->GetLayout($date, $resource->GetId());
				foreach ($slots as $slot)
				{
					$scheduleResource->AddSlot($slot);
				}

				$scheduleDate->AddResource($scheduleResource);
			}

			$this->dates[] = $scheduleDate;
		}
	}

	public static function Example()
	{
		return new ExampleScheduleSlotsResponse();
	}
}

class ExampleScheduleSlotsResponse extends ScheduleSlotsResponse
{
	public function __construct()
	{
		$this->dates = array(new ExampleScheduleSlotResponse());
	}
}

class ExampleScheduleSlotResponse extends ScheduleSlotResponse
{
	public function __construct()
	{
		$this->date = Date::Now()->ToIso();
		$this->resources = array(new ExampleScheduleSlotResourceResponse());
	}
}

class ExampleScheduleSlotResourceResponse extends ScheduleSlotResourceResponse
{
	public function __construct()
	{
		$this->resourceId = 1;
		$this->resourceName = 'resourcename';
		$this->slots = array(new ExampleScheduleSlotDetailsResponse());
	}
}

class ExampleScheduleSlotDetailsResponse extends ScheduleSlotDetailsResponse
{
	public function __construct()
	{
		$this->color = '#ffffff';
		$this->endDateTime = Date::Now()->ToIso();
		$this->isReservable = false;
		$this->isReserved = true;
		$this->label = 'username';
		$this->reservation = ReservationItemResponse::Example();
		$this->slotSpan = 4;
		$this->startDateTime = Date::Now()->ToIso();
	}
}