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
	foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory)) as $filename)
	{
	        require_once($filename);
	}
}

class WebServiceIntegrationTests extends PHPUnit_Framework_TestCase
{
	private $url = 'http://localhost/dev/Services';
//	private $url = 'http://localhost/development/Services/index.php';

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

	private function LogIn($username = 'admin', $password = 'password')
	{
		/** @var $response AuthenticationResponse */
		$response = $this->client->Post('Authentication/Authenticate', new AuthenticationRequest($username, $password));

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

	public function testGetsSchedules()
	{
		$authHeaders = $this->LogIn();

		/** @var $schedulesResponse SchedulesResponse */
		$schedulesResponse = $this->client->Get('Schedules/', $authHeaders);

		/** @var $scheduleResponse ScheduleResponse */
		$scheduleResponse = $this->client->GetUrl($schedulesResponse->schedules[0]->links[0]->href, $authHeaders);
	}

	public function testUserLifecycle()
	{
		$authHeaders = $this->LogIn();
		$userId = $this->AddUser($authHeaders);
		$this->UpdateUser($authHeaders, $userId);
		$this->DeleteUser($authHeaders, $userId);
	}

	public function testResourceLifecycle()
	{
		$authHeaders = $this->LogIn();
		$resourceId = $this->AddResource($authHeaders);
		$this->UpdateResource($authHeaders, $resourceId);
		$this->DeleteResource($authHeaders, $resourceId);
	}

	private function AddUser($authHeaders)
	{
		$request = new CreateUserRequest();
		$request->emailAddress = time() . '@test.com';
		$request->userName = time();
		$request->firstName = 'first';
		$request->lastName = 'last';
		$request->language = 'en_us';
		$request->password = 'password';
		$request->timezone = 'America/Chicago';
		$request->customAttributes[] = new AttributeValueRequest(5, 'value');

		/** @var $response UserCreatedResponse */
		$response = $this->client->Post('Users/', $request, $authHeaders);

		if (isset($response->errors))
		{
			foreach ($response->errors as $error)
			{
				echo "$error\n";
			}
		}

		$this->assertNotEmpty($response->userId);

		return $response->userId;
	}

	private function UpdateUser($authHeaders, $userId)
	{
		$request = new UpdateUserRequest();
		$request->emailAddress = time() . '@test.com';
		$request->userName = time();
		$request->firstName = 'first2';
		$request->lastName = 'last2';
		$request->timezone = 'America/New_York';
		$request->customAttributes[] = new AttributeValueRequest(5, 'value');

		/** @var $response UserCreatedResponse */
		$response = $this->client->Post("Users/$userId", $request, $authHeaders);

		if (isset($response->errors))
		{
			foreach ($response->errors as $error)
			{
				echo "$error\n";
			}
		}

		$this->assertNotEmpty($response->userId);
	}

	private function DeleteUser($authHeaders, $userId)
	{
		/** @var $response DeletedResponse */
		$response = $this->client->Delete("Users/$userId", $authHeaders);

		if (isset($response->errors))
		{
			foreach ($response->errors as $error)
			{
				echo "$error\n";
			}
		}
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
		$request->startReminder = new ReminderRequestResponse(15, 'minutes');

		/** @var $response ReservationCreatedResponse|FailedResponse */
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
		$reservationRequest->endReminder = new ReminderRequestResponse(15, 'days');

		/** @var $response ReservationUpdatedResponse|FailedResponse */
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
		/** @var $response DeletedResponse|FailedResponse */
		$response = $this->client->Delete($reservationUrl, $authHeaders);

		if (isset($response->errors))
		{
			foreach ($response->errors as $error)
			{
				echo "$error\n";
			}
			$this->fail('Errors deleting');
		}
	}

	private function AddResource($authHeaders)
	{
		$request = new ResourceRequest();
		$request->name = time() . ' resource';
		$request->scheduleId = 1;
		$request->description = 'description';
		$request->notes = 'notes';
		$request->allowMultiday = 'false';
		$request->customAttributes[] = new AttributeValueRequest(3, 'value3');
		$request->customAttributes[] = new AttributeValueRequest(4, 'value4');

		/** @var $response ResourceCreatedResponse */
		$response = $this->client->Post('Resources/', $request, $authHeaders);

		if (isset($response->errors))
		{
			foreach ($response->errors as $error)
			{
				echo "$error\n";
			}
		}

		$this->assertNotEmpty($response->resourceId);

		return $response->resourceId;
	}

	private function UpdateResource($authHeaders, $resourceId)
	{
		$request = new ResourceRequest();
		$request->name = time() . ' resource';
		$request->scheduleId = 1;
		$request->description = 'description';
		$request->notes = 'notes';
		$request->allowMultiday = 'false';
		$request->customAttributes[] = new AttributeValueRequest(3, 'value3');
		$request->customAttributes[] = new AttributeValueRequest(4, 'value4');
		$request->isOnline = true;

		/** @var $response ResourceUpdatedResponse */
		$response = $this->client->Post("Resources/$resourceId", $request, $authHeaders);

		if (isset($response->errors))
		{
			foreach ($response->errors as $error)
			{
				echo "$error\n";
			}
		}

		$this->assertNotEmpty($response->resourceId);
	}

	private function DeleteResource($authHeaders, $resourceId)
	{
		/** @var $response DeletedResponse */
		$response = $this->client->Delete("Resources/$resourceId", $authHeaders);

		if (isset($response->errors))
		{
			foreach ($response->errors as $error)
			{
				echo "$error\n";
			}
		}
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

		$fullUrl = $this->GetFullUrl($url);
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

	public function GetUrl($fullUrl, $headers)
	{
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

	public function Get($url, $headers = array())
	{
		$fullUrl = $this->GetFullUrl($url);
		return $this->GetUrl($fullUrl, $headers);
	}

	public function Delete($url, $headers = array())
	{
		$fullUrl = $this->GetFullUrl($url);
		$curl_connection = curl_init($fullUrl);
		curl_setopt($curl_connection, CURLOPT_CUSTOMREQUEST, 'DELETE');
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

	private function GetFullUrl($url)
	{
		return $this->baseUrl . '/' . $url;
	}
}

?>