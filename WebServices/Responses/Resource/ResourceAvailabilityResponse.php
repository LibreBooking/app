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

require_once(ROOT_DIR . 'lib/WebService/namespace.php');

class ResourcesAvailabilityResponse extends RestResponse
{
	/**
	 * @var ResourceAvailabilityResponse[]
	 */
	public $resources;

	/**
	 * @param IRestServer $server
	 * @param ResourceAvailabilityResponse[] $resources
	 */
	public function __construct(IRestServer $server, $resources)
	{
		$this->resources[] = $resources;
	}

	public static function Example()
	{
		return new ExampleResourcesAvailabilityResponse();
	}
}

class ExampleResourcesAvailabilityResponse extends ResourcesAvailabilityResponse
{
	public function __construct()
	{
		$this->resources = array(ResourceAvailabilityResponse::Example());
	}
}

class ResourceAvailabilityResponse extends RestResponse
{
	/**
	 * @var bool
	 */
	public $available;

	/**
	 * @var ResourceReference
	 */
	public $resource;

	/**
	 * @var Date|null
	 */
	public $availableAt;

	/**
	 * @var Date|null
	 */
	public $availableUntil;

	/**
	 * @param IRestServer $server
	 * @param BookableResource $resource
	 * @param ReservationItemView|null $conflictingReservation
	 * @param ReservationItemView|null $nextReservation
	 * @param Date|null $nextAvailableTime
	 * @param Date $lastDateSearched
	 */
	public function __construct(IRestServer $server, $resource, $conflictingReservation, $nextReservation, $nextAvailableTime, $lastDateSearched)
	{
		$this->resource = new ResourceReference($server, $resource);
		$this->available = $conflictingReservation == null;

		$this->AddService($server, WebServices::GetResource, array(WebServiceParams::ResourceId => $resource->GetId()));

		if (!$this->available)
		{
			$this->availableAt = $nextAvailableTime != null ? $nextAvailableTime->ToTimezone($server->GetSession()->Timezone)->ToIso() : null;

			$this->AddService($server, WebServices::GetUser,
							  array(WebServiceParams::UserId => $conflictingReservation->UserId));
			$this->AddService($server, WebServices::GetReservation,
							  array(WebServiceParams::ReferenceNumber => $conflictingReservation->ReferenceNumber));
		}

		if ($nextReservation != null)
		{
			$this->availableUntil = $nextReservation->BufferedTimes()->GetBegin()->ToTimezone($server->GetSession()->Timezone)->ToIso();
		}
		else
		{
			$this->availableUntil = $lastDateSearched->ToTimezone($server->GetSession()->Timezone)->ToIso();
		}
	}

	public static function Example()
	{
		return new ExampleResourceAvailabilityResponse();
	}
}

class ExampleResourceAvailabilityResponse extends ResourceAvailabilityResponse
{
	public function __construct()
	{
		$this->available = true;
		$this->availableAt = Date::Now()->ToIso();
		$this->availableUntil = Date::Now()->ToIso();
		$this->resource = ResourceReference::Example();

		$this->AddServiceLink(new RestServiceLink('http://get-user-url', WebServices::GetUser));
		$this->AddServiceLink(new RestServiceLink('http://get-reservation-url', WebServices::GetReservation));
	}
}