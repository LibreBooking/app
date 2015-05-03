<?php
/**
Copyright 2011-2015 Nick Korbel

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

class RestResponse
{
	const OK_CODE = 200;
	const CREATED_CODE = 201;
	const BAD_REQUEST_CODE = 400;
	const UNAUTHORIZED_CODE = 401;
	const NOT_FOUND_CODE = 404;
	const SERVER_ERROR = 500;

	/**
	 * @var array|RestServiceLink[]
	 */
	public $links = array();

	/**
	 * @var string
	 */
	public $message = null;

	/**
	 * @param IRestServer $server
	 * @param string $serviceName
	 * @param array $params
	 * @return void
	 */
	public function AddService(IRestServer $server, $serviceName, $params = array())
	{
		$url = $server->GetFullServiceUrl($serviceName, $params);
		$this->AddServiceLink(new RestServiceLink($url, $serviceName));
	}

	/**
	 * @param string $href
	 * @param string $title
	 * @return void
	 */
	public function AddLink($href, $title)
	{
		$this->AddServiceLink(new RestServiceLink($href, $title));
	}

	protected function AddServiceLink(RestServiceLink $link)
	{
		$this->links[] = $link;
	}

	public static function NotFound()
	{
		$response = new RestResponse();
		$response->message = 'The requested resource was not found';
		return $response;
	}

	public static function Unauthorized()
	{
		$response = new RestResponse();
		$response->message = 'You do not have access to the requested resource';
		return $response;
	}
}