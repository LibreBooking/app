<?php
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

class RestAction
{
	/**
	 * @var string
	 */
	public $Href;

	public function __construct($url)
	{
		$this->Href = $url;
	}
}

?>