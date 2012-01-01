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

interface IRestService
{
    /**
     * @abstract
     * @param IRestServer $server
     * @param string|WebServiceAction $serviceAction
     * @return RestResponse
     */
    public function HandlePost(IRestServer $server, $serviceAction = '');

    /**
     * @abstract
     * @param IRestServer $server
     * @param string|WebServiceAction $serviceAction
     * @return RestResponse
     */
    public function HandleGet(IRestServer $server, $serviceAction = '');
}

abstract class RestServiceBase implements IRestService
{
    /**
     * @var array|callback[]
     */
    private $getActions = array();

    /**
     * @var array|callback[]
     */
    private $postActions = array();

    /**
     * @var null|callback
     */
    private $defaultPostAction = null;

    /**
     * @var null|callback
     */
    private $defaultGetAction = null;

    /**
     * @param RestAction $action
     * @param callback $callback
     */
    protected function Register(RestAction $action, $callback)
    {
        if ($action->requestType == RequestType::GET)
        {

            if ($this->IsDefault($action->GetServiceAction()))
            {
                $this->defaultGetAction = $callback;
            }
            else
            {
                $this->getActions[$action->GetServiceAction()] = $callback;
            }
        }
        else
        {
            if ($action->requestType == RequestType::POST)
            {
                if ($this->IsDefault($action->GetServiceAction()))
                {
                    $this->defaultPostAction = $callback;
                }
                else
                {
                    $this->postActions[$action->GetServiceAction()] = $callback;
                }
            }
        }
    }

    public function HandlePost(IRestServer $server, $serviceAction = '')
    {
        if ($this->IsDefault($serviceAction) && !is_null($this->defaultPostAction))
        {
            return call_user_func($this->defaultPostAction, $server);
        }
        if (array_key_exists($serviceAction, $this->postActions))
        {
            return call_user_func($this->postActions[$serviceAction], $server);
        }

        return new NotFoundResponse();
    }

    public function HandleGet(IRestServer $server, $serviceAction = '')
    {
        if ($this->IsDefault($serviceAction) && !is_null($this->defaultGetAction))
        {
            return call_user_func($this->defaultGetAction, $server);
        }
        if (array_key_exists($serviceAction, $this->getActions))
        {
            return call_user_func($this->getActions[$serviceAction], $server);
        }

        return new NotFoundResponse();
    }


    private function IsDefault($serviceAction)
    {
        return $serviceAction == WebServiceAction::DefaultAction;
    }
}

?>