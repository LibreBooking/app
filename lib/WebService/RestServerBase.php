<?php
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/WebService/IRestServer.php');

class RestParams
{
	const UserName = 'username';
	const Password = 'password';
}

abstract class RestServerBase implements IRestServer
{
	/**
	 * @return bool
	 */
	public function IsPost()
	{
		return ServiceLocator::GetServer()->GetRequestMethod() == 'POST';
	}

	/**
	 * @return bool
	 */
	public function IsGet()
	{
		return ServiceLocator::GetServer()->GetRequestMethod() == 'GET';
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
		return $this->GetQueryString('action');
	}
}

?>