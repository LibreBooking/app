<?php
/**
Copyright 2011-2012 Nick Korbel

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

		//$r = array('response' => $response->GetBody(), 'actions' => $response->Actions, 'message' => $response->Message);
		echo json_encode($response);
        //echo json_encode($r);
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