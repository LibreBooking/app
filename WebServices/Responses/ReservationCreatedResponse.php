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

class ReservationCreatedResponse extends RestResponse
{
	public $referenceNumber;
	public $isPendingApproval;

	public function __construct(IRestServer $server, $referenceNumber, $isPendingApproval)
	{
		$this->message = 'The reservation was created';
		$this->referenceNumber = $referenceNumber;
		$this->isPendingApproval = $isPendingApproval;
		$this->AddService($server, WebServices::GetReservation, array(WebServiceParams::ReferenceNumber => $referenceNumber));
		$this->AddService($server, WebServices::UpdateReservation, array(WebServiceParams::ReferenceNumber => $referenceNumber));
	}

	public static function Example()
	{
		return new ExampleReservationCreatedResponse();
	}
}

class ReservationUpdatedResponse extends RestResponse
{
	public $referenceNumber;
	public $isPendingApproval;

	public function __construct(IRestServer $server, $referenceNumber, $isPendingApproval)
	{
		$this->message = 'The reservation was updated';
		$this->referenceNumber = $referenceNumber;
		$this->isPendingApproval = $isPendingApproval;
		$this->AddService($server, WebServices::GetReservation, array(WebServiceParams::ReferenceNumber => $referenceNumber));
	}

	public static function Example()
	{
		return new ExampleReservationCreatedResponse();
	}
}

class ReservationApprovedResponse extends RestResponse
{
	public $referenceNumber;

	public function __construct(IRestServer $server, $referenceNumber)
	{
		$this->message = 'The reservation was approved';
		$this->referenceNumber = $referenceNumber;
		$this->AddService($server, WebServices::GetReservation, array(WebServiceParams::ReferenceNumber => $referenceNumber));
	}

	public static function Example()
	{
		return new ExampleReservationCreatedResponse();
	}
}

class ReservationCheckedInResponse extends RestResponse
{
	public $referenceNumber;

	public function __construct(IRestServer $server, $referenceNumber)
	{
		$this->message = 'The reservation was checked in';
		$this->referenceNumber = $referenceNumber;
		$this->AddService($server, WebServices::GetReservation, array(WebServiceParams::ReferenceNumber => $referenceNumber));
	}

	public static function Example()
	{
		return new ExampleReservationCreatedResponse();
	}
}

class ReservationCheckedOutResponse extends RestResponse
{
	public $referenceNumber;

	public function __construct(IRestServer $server, $referenceNumber)
	{
		$this->message = 'The reservation was checked out';
		$this->referenceNumber = $referenceNumber;
		$this->AddService($server, WebServices::GetReservation, array(WebServiceParams::ReferenceNumber => $referenceNumber));
	}

	public static function Example()
	{
		return new ExampleReservationCreatedResponse();
	}
}

class ExampleReservationCreatedResponse extends ReservationCreatedResponse
{
	public function __construct()
	{
		$this->referenceNumber = 'referenceNumber';
		$this->isPendingApproval = true;
		$this->AddLink('http://url/to/reservation', WebServices::GetReservation);
		$this->AddLink('http://url/to/update/reservation', WebServices::UpdateReservation);
	}
}