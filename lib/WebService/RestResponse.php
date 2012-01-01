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

require_once(ROOT_DIR . 'lib/WebService/RestAction.php');

class RestResponse
{
	/**
	 * @var array|RestAction[]
	 */
	public $Actions = array();

	/**
	 * @var int
	 */
	public $StatusCode = 200;

	/**
	 * @var mixed
	 */
	public $Body = null;

	/**
	 * @var string
	 */
	public $Message = null;

	/**
	 * @return mixed
	 */
	public function GetBody()
	{
		return $this->Body;
	}

	/**
	 * @param RestAction $action
	 * @return void
	 */
	public function AddAction(RestAction $action)
	{
		$this->Actions[] = $action;
	}

	/**
	 * @param string $url
	 * @return void
	 */
	public function AddActionUrl($url)
	{
		$this->AddAction(new RestAction($url));
	}

	/**
	 * @param $serviceResource string|WebServiceResource
	 * @param $serviceAction string|WebServiceAction|null
	 * @return void
	 */
	public function AddResourceAction($serviceResource, $serviceAction = '')
	{
		$url = Configuration::Instance()->GetScriptUrl();
		$this->AddActionUrl(sprintf('%s/Services/%s?action=%s', $url, $serviceResource, $serviceAction));
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