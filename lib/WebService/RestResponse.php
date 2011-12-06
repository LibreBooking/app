<?php
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