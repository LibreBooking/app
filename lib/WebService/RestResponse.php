<?php

class RestResponse
{
	const OK_CODE = 200;
	const CREATED_CODE = 201;
	const BAD_REQUEST_CODE = 400;
	const UNAUTHORIZED_CODE = 401;
	const NOT_FOUND_CODE = 404;
	const SERVER_ERROR = 500;

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

	protected function AddServiceLink(RestServiceLink $link)
	{
		$this->links[] = $link;
	}

	public static function NotFound()
	{
		$response = new RestResponse();
		$response->message = 'The requested resource was not found';
		return $response;
	}

	public static function Unauthorized()
	{
		$response = new RestResponse();
		$response->message = 'You do not have access to the requested resource';
		return $response;
	}
}
