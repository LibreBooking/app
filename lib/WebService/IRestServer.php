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

require_once(ROOT_DIR . 'lib/WebService/RestResponse.php');

interface IRestServer
{
	/**
	 * @abstract
	 * @return bool
	 */
	public function IsPost();

	/**
	 * @abstract
	 * @return bool
	 */
	public function IsGet();

	/**
	 * @abstract
	 * @param RestResponse $response
	 * @return void
	 */
	public function Respond(RestResponse $response);

    /**
     * @abstract
     * @param IExactRestResponse $response
     * @return void
     */
    public function RespondExact(IExactRestResponse $response);

	/**
	 * @abstract
	 * @param string $variableName
	 * @return mixed
	 */
	public function GetPost($variableName);

	/**
	 * @abstract
	 * @param string $variableName
	 * @return mixed
	 */
	public function GetQueryString($variableName);

	/**
	 * @abstract
	 * @return UserSession
	 */
	public function GetUserSession();

	/**
	 * @abstract
	 * @return string|WebServiceAction
	 */
	public function GetServiceAction();

}

?>