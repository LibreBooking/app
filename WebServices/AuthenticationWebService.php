<?php
require_once(ROOT_DIR . 'lib/WebService/RestServerBase.php');
require_once(ROOT_DIR . 'lib/WebService/IRestService.php');

class AuthenticationWebService implements IRestService
{
	/**
	 * @var \IAuthentication
	 */
	private $authentication;
	
	public function __construct(IAuthentication $authentication)
	{
		$this->authentication = $authentication;
	}

	/**
	 * @param IRestServer $server
	 * @return AuthenticationResponse
	 */
	public function Authenticate(IRestServer $server)
	{
		$username = $server->GetPost(RestParams::UserName);
		$password = $server->GetPost(RestParams::Password);

		Log::Debug('WebService Authenticate for user %s', $username);
		
		$isValid = $this->authentication->Validate($username, $password);
		if ($isValid)
		{
			Log::Debug('WebService Authenticate, user %s was authenticated', $username);

			$this->authentication->Login($username, false);
			return AuthenticationResponse::Success($server->GetUserSession());
		}

		Log::Debug('WebService Authenticate, user %s was not authenticated', $username);

		return AuthenticationResponse::Failed();
	}


	public function SignOut(IRestServer $server)
	{
		$this->authentication->Logout($server->GetUserSession());

		return new SignOutResponse();
	}

	/**
	 * @param IRestServer $server
	 * @return RestResponse
	 */
	public function HandlePost(IRestServer $server)
	{
		if ($server->GetServiceAction() == WebServiceAction::SignOut)
		{
			return $this->SignOut($server);
		}
		return $this->Authenticate($server);
	}

	/**
	 * @param IRestServer $server
	 * @return RestResponse
	 */
	public function HandleGet(IRestServer $server)
	{
		return new NotFoundResponse();
	}

}

class AuthenticationResponseBody
{
	public $sessionToken = '';
	public $userId = '';
	public $isAuthenticated = false;
	
	public function __construct($sessionToken, $userId)
	{
		$this->sessionToken = $sessionToken;
		$this->userId = $userId;
		$this->isAuthenticated = !empty($sessionToken) && !empty($userId);
	}
}

class SignOutResponse extends RestResponse
{
	public function __construct()
	{
	    $this->Message = 'SignOut successful';
	}
}

class AuthenticationResponse extends RestResponse
{
	public function __construct()
	{
		$this->Body = new AuthenticationResponseBody(null, null);
	}

	/**
	 * @static
	 * @param $userSession UserSession
	 * @return AuthenticationResponse
	 */
	public static function Success($userSession)
	{
		$response = new AuthenticationResponse();
		$response->Body = new AuthenticationResponseBody($userSession->SessionToken, $userSession->UserId);
		
		$response->AddAction(RestAction::AllBookings());
		$response->AddAction(RestAction::MyBookings());
		$response->AddAction(RestAction::CreateBooking());

		return $response;
	}

	/**
	 * @static
	 * @return AuthenticationResponse
	 */
	public static function Failed()
	{
		$response = new AuthenticationResponse();

		return $response;
	}
}

class EchoResponse extends RestResponse
{
	public function __construct(IRestServer $server)
	{
	    $this->Body = $_POST;
	}
}
?>