<?php
/**
Copyright 2012-2019 Nick Korbel

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

require_once(ROOT_DIR . 'lib/WebService/RestResponse.php');
require_once(ROOT_DIR . 'Domain/Values/WebService/WebServiceUserSession.php');

interface IRestServer
{
	/**
	 * @return mixed
	 */
	public function GetRequest();

	/**
	 * @param RestResponse $restResponse
	 * @param int $statusCode
	 * @return void
	 */
	public function WriteResponse(RestResponse $restResponse, $statusCode = 200);

	/**
	 * @param string $serviceName
	 * @param array $params
	 * @return string
	 */
	public function GetServiceUrl($serviceName, $params = array());

	/**
	 * @return string
	 */
	public function GetUrl();

	/**
	 * @param string $serviceName
	 * @param array $params
	 * @return string
	 */
	public function GetFullServiceUrl($serviceName, $params = array());

	/**
	 * @param string $headerName
	 * @return string|null
	 */
	public function GetHeader($headerName);

	/**
	 * @param WebServiceUserSession $session
	 * @return void
	 */
	public function SetSession(WebServiceUserSession $session);

	/**
	 * @return WebServiceUserSession|null
	 */
	public function GetSession();

	/**
	 * @param string $queryStringKey
	 * @return string|null
	 */
	public function GetQueryString($queryStringKey);
}