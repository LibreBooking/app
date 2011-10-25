<?php
require_once(ROOT_DIR . 'lib/WebService/RestServerBase.php');

class JsonRestServer extends RestServerBase implements IRestServer
{
	/**
	 * @param RestResponse $response
	 * @return void
	 */
	public function Respond(RestResponse $response)
	{
		header('Content-type: application/json', true, $response->StatusCode);

		$r = array('response' => $response->Body, 'actions' => $response->Actions);
		echo json_encode($r);
	}

	public function GetPost($variableName)
	{
		return json_decode(parent::GetPost($variableName));
	}
}


//abstract class SecureJsonRestServer extends JsonRestServer
//{
//	public function __construct()
//	{
//	    // if not authenticated, respond with error
//	}
//
//	public function GetUser()
//	{
//		// get user session by token and ip?
//	}
//}
?>