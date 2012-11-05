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

//require_once(ROOT_DIR . 'lib/WebService/RestAction.php');

class RestServiceLink
{
	public $href;
	public $title;

	public function __construct($href, $title)
	{
		$this->href = $href;
		$this->title = $title;
	}
}

class RestResponse
{
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

	private function AddServiceLink(RestServiceLink $link)
	{
		$this->links[] = $link;
	}
}

class NullRestResponse extends RestResponse
{

}

class NotFoundResponse extends RestResponse
{
	public function __construct()
	{
		$this->StatusCode = 404;
	}
}

?>