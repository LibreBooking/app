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

if (!defined('ROOT_DIR'))
{
	define('ROOT_DIR', dirname(__FILE__) . '/../');
}

includeAll(ROOT_DIR . 'WebServices/Requests');
includeAll(ROOT_DIR . 'WebServices/Responses');

function includeAll($directory)
{
	if ($handle = opendir($directory))
	{
		while (false !== ($entry = readdir($handle)))
		{
			if ($entry != '.' && $entry != '..')
			{
				require_once($directory . '/' . $entry);
			}
		}

		closedir($handle);
	}
}

class WebServiceIntegrationTests extends PHPUnit_Framework_TestCase
{
//	private $url = 'http://localhost/dev/Services';
	private $url = 'http://localhost/development/Services/index.php';

	/**
	 * @var HttpClient
	 */
	private $client;

	public function setup()
	{
		$this->client = new HttpClient($this->url);
	}

	private function authHeaders($token, $userId)
	{
		return array("X-phpScheduleIt-SessionToken:$token", "X-phpScheduleIt-UserId:$userId");
	}

	private function LogIn()
	{
		/** @var $response AuthenticationResponse */
		$response = $this->client->Post('Authentication/Authenticate', new AuthenticationRequest('admin', 'password'));

		return $this->authHeaders($response->sessionToken, $response->userId);
	}

	public function testCanLogIn()
	{
		/** @var $response AuthenticationResponse */
		$response = $this->client->Post('Authentication/Authenticate', new AuthenticationRequest('admin', 'password'));

		$this->assertNotEmpty($response->sessionToken);
	}

	public function testReservationLifecycle()
	{
		$authHeaders = $this->LogIn();
		$referenceNumber = $this->CreateReservation($authHeaders);
		$this->UpdateReservation($authHeaders, $referenceNumber);
		$this->RemoveReservation($authHeaders, $referenceNumber);
	}

	private function CreateReservation($authHeaders)
	{
		$request = new ReservationRequest();
		$request->accessories = array(new ReservationAccessoryRequest(1, 1));
		$request->customAttributes = array(new AttributeValueRequest(1, 'att1'), new AttributeValueRequest(2, 'att2'));
		$request->description = 'some description';
		$today = Date::Now()->Format('Y-m-d');
		$request->endDateTime = Date::Parse("$today 12:30", 'America/Chicago')->ToIso();
		$request->resourceId = 1;
		$request->startDateTime = Date::Parse("$today 12:00", 'America/Chicago')->ToIso();
		$request->title = 'some title';

		/** @var $response ReservationCreatedResponse|ReservationFailedResponse */
		$response = $this->client->Post('Reservations/', $request, $authHeaders);

		if (isset($response->errors))
		{
			foreach ($response->errors as $error)
			{
				echo "$error\n";
			}
		}
		$this->assertNotEmpty($response->links[0]);

		return $response->referenceNumber;
	}

	private function UpdateReservation($authHeaders, $referenceNumber)
	{
		$reservationUrl = 'Reservations/' . $referenceNumber;
		/** @var $reservation ReservationResponse */
		$reservation = $this->client->Get($reservationUrl, $authHeaders);

		$reservationRequest = new ReservationRequest();
		foreach ($reservation->accessories as $accessory)
		{
			$reservationRequest->accessories[] = new ReservationAccessoryRequest($accessory->id, $accessory->quantityReserved);
		}
		foreach ($reservation->customAttributes as $attribute)
		{
			$reservationRequest->customAttributes[] = new AttributeValueRequest($attribute->id, $attribute->value);
		}

		$reservationRequest->description = $reservation->description;
		$reservationRequest->endDateTime = $reservation->endDateTime;
		foreach ($reservation->invitees as $invitee)
		{
			$reservationRequest->invitees[] = $invitee->userId;
		}
		foreach ($reservation->participants as $participant)
		{
			$reservationRequest->participants[] = $participant->userId;
		}

		$reservationRequest->recurrenceRule = $reservation->recurrenceRule;
		$reservationRequest->resourceId = $reservation->resourceId;
		foreach ($reservation->resources as $resource)
		{
			$reservationRequest->resources[] = $resource->id;
		}
		$reservationRequest->startDateTime = $reservation->startDateTime;
		$reservationRequest->title = $reservation->title;
		$reservationRequest->userId = $reservation->owner->userId;

		/** @var $response ReservationUpdatedResponse|ReservationFailedResponse */
		$response = $this->client->Post($reservationUrl, $reservationRequest, $authHeaders);

		if (isset($response->errors))
		{
			foreach ($response->errors as $error)
			{
				echo "$error\n";
			}
		}
		$this->assertNotEmpty($response->links[0]);
	}

	private function RemoveReservation($authHeaders, $referenceNumber)
	{
		$reservationUrl = 'Reservations/' . $referenceNumber;
		/** @var $response ReservationDeletedResponse */
		$this->client->Delete($reservationUrl, $authHeaders);
	}
}

class HttpClient
{
	private $baseUrl;

	public function __construct($baseUrl)
	{
		$this->baseUrl = $baseUrl;
	}

	public function Post($url, $data, $headers = array())
	{
		if (is_object($data))
		{
			$data = json_encode($data);
		}

		$fullUrl = $this->GetUrl($url);
		$curl_connection = curl_init($fullUrl);
		curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_connection, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($curl_connection);

		//echo "\nUrl=$fullUrl\nResult=$result";

		curl_close($curl_connection);

		$jsonObject = json_decode($result);

		if ($jsonObject == null)
		{
			echo $result;
		}

		return $jsonObject;
	}

	public function Get($url, $headers = array())
	{
		$fullUrl = $this->GetUrl($url);
		$curl_connection = curl_init($fullUrl);
		curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_connection, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($curl_connection);

		curl_close($curl_connection);

		$jsonObject = json_decode($result);

		if ($jsonObject == null)
		{
			echo $result;
		}

		return $jsonObject;
	}

	public function Delete($url, $headers = array())
	{
		$fullUrl = $this->GetUrl($url);
		$curl_connection = curl_init($fullUrl);
		curl_setopt($curl_connection, CURLOPT_CUSTOMREQUEST, 'DELETE');
		curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl_connection, CURLOPT_HTTPHEADER, $headers);
		curl_exec($curl_connection);

		curl_close($curl_connection);
	}

	private function GetUrl($url)
	{
		return $this->baseUrl . '/' . $url;
	}
}

?>