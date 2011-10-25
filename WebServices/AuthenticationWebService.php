<?php
require_once(ROOT_DIR . 'lib/WebService/IRestService.php');

class AuthenticationWebService implements IRestService
{
	public function Authenticate()
	{
		return new AuthenticationResponse();
	}

	/**
	 * @param IRestServer $server
	 * @return RestResponse
	 */
	public function HandlePost(IRestServer $server)
	{
		return $this->Authenticate();
	}

	/**
	 * @param IRestServer $server
	 * @return RestResponse
	 */
	public function HandleGet(IRestServer $server)
	{
		//return new NotFoundResponse();

		return $this->Authenticate();
	}
}

class AuthenticationResponse extends RestResponse
{
	public function __construct()
	{
	    $this->Body = "some response goes here";
		$this->AddActionUrl('http://localhost/login.php');
	}
}

?>