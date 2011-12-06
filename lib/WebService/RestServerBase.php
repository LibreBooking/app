<?php
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