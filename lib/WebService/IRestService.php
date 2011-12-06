<?php
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
				$this->getActions[$action->GetServiceAction()] = $action;
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
					$this->postActions[$action->GetServiceAction()] = $action;
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
		if (in_array($serviceAction, $this->postActions))
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
		if (in_array($serviceAction, $this->getActions))
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