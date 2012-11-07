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
	/**
	 * @var string
	 */
	public $_Url;

	public function GetRequest()
	{
		return $this->_Request;
	}

	public function WriteResponse(RestResponse $restResponse)
	{
		$this->_LastResponse = $restResponse;
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
		return $this->queryStringKeys[$queryStringKey];
	}
}
?>