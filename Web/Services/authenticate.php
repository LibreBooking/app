<?php

$service = new AuthenticationWebService();
$service->Authenticate();

class AuthenticationWebService extends JsonWebService
{

	public function Authenticate()
	{
		$response = new AuthenticationResponse();
		$this->Respond($response);
	}
}

class AuthenticationResponse extends JsonResponse
{
	
}

class JsonResponse
{
	
}

abstract class JsonWebService
{
	public function GetPost($variableName)
	{
		return json_decode($_POST[$variableName]);
	}

	public function Respond(JsonResponse $objectToSerialize)
	{
		header('Content-type: application/json');
		echo json_encode($objectToSerialize);
	}
}

abstract class SecureJsonWebService extends JsonWebService
{
	public function __construct()
	{
	    // if not authenticated, respond with error
	}
	
	public function GetUser()
	{
		// get user session by token and ip?
	}
}
?>