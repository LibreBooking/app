<?php
/**
Copyright 2012-2018 Nick Korbel

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

require_once(ROOT_DIR . 'lib/WebService/namespace.php');

class FakeRestServer implements IRestServer
{
	/**
	 * @var mixed
	 */
	public $_Request;

	/**
	 * @var array|string[]
	 */
	public $_ServiceUrls = array();

	/**
	 * @var RestResponse
	 */
	public $_LastResponse;

	public $_LastResponseCode;

	/**
	 * @var string
	 */
	public $_Url;

	/**
	 * @var WebServiceUserSession
	 */
	public $session;

	private $queryStringKeys = array();

	public function __construct()
	{
		$this->SetSession(new FakeWebServiceUserSession(123));

	}
	public function GetRequest()
	{
		return $this->_Request;
	}

	public function WriteResponse(RestResponse $restResponse, $statusCode = 200)
	{
		$this->_LastResponse = $restResponse;
		$this->_LastResponseCode = $statusCode;
	}

	public function GetServiceUrl($serviceName, $params = array())
	{
		if (isset($this->_ServiceUrls[$serviceName]))
		{
			return $this->_ServiceUrls[$serviceName];
		}
		return null;
	}

	public function SetRequest($request)
	{
		$this->_Request = $request;
	}

	public function GetUrl()
	{
		return $this->_Url;
	}

	public function GetFullServiceUrl($serviceName, $params = array())
	{
		// TODO: Implement GetFullServiceUrl() method.
	}

	public function GetHeader($headerName)
	{
		// TODO: Implement GetHeader() method.
	}

	public function SetSession(WebServiceUserSession $session)
	{
		$this->session = $session;
	}

	/**
	 * @return null|WebServiceUserSession
	 */
	public function GetSession()
	{
		return $this->session;
	}

	public function SetQueryString($key, $value)
	{
		$this->queryStringKeys[$key] = $value;
	}

	public function GetQueryString($queryStringKey)
	{
		if (array_key_exists($queryStringKey, $this->queryStringKeys))
		{
			return $this->queryStringKeys[$queryStringKey];
		}
		return null;
	}
}