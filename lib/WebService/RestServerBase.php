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

require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/WebService/IRestServer.php');
require_once(ROOT_DIR . 'lib/WebService/RestConstants.php');

abstract class RestServerBase implements IRestServer
{
	/**
	 * @return bool
	 */
	public function IsPost()
	{
		return ServiceLocator::GetServer()->GetRequestMethod() == RequestType::POST;
	}

	/**
	 * @return bool
	 */
	public function IsGet()
	{
		return ServiceLocator::GetServer()->GetRequestMethod() == RequestType::GET;
	}

	public function GetPost($variableName)
	{
		return ServiceLocator::GetServer()->GetForm($variableName);
	}
	
	public function GetQueryString($variableName)
	{
		return ServiceLocator::GetServer()->GetQuerystring($variableName);
	}

	public function GetUserSession()
	{
		return ServiceLocator::GetServer()->GetUserSession();
	}

	public function GetServiceAction()
	{
		return $this->GetQueryString(QueryStringKeys::WEB_SERVICE_ACTION);
	}

    public function RespondExact(IExactRestResponse $response)
    {
        $response->Respond();
    }
}

interface IExactRestResponse
{
    /**
     * Output the exact response needed, including all header information
     *
     * @abstract
     * return void
     */
    public function Respond();
}

?>