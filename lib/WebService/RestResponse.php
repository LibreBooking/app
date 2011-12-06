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

class WebServiceResource
{
	const Authentication = 'Authentication';
	const Bookings = 'Bookings';
	const Resources = 'Resources';
}

class WebServiceAction
{
	const Create = 'create';
	const DefaultAction = '';
	const Delete = 'update';
	const MyBookings = 'mybookings';
	const SignOut = 'signout';
	const Update = 'update';
}


class SecureRestAction extends RestAction
{
	public function __construct($url, $description = '', $requestType = RequestType::GET, $serviceAction = WebServiceAction::DefaultAction)
	{
		$token = ServiceLocator::GetServer()->GetUserSession()->SessionToken;
		$url = $url . '&sessionToken=' . $token;

		parent::__construct($url, $description, $requestType, $serviceAction);
	}
}

class RestAction
{
	/**
	 * @var string
	 */
	public $ref;

	/**
	 * @var string
	 */
	public $description;

	/**
	 * @var string|RequestType
	 */
	public $requestType;

	/**
	 * @var string|WebServiceAction
	 */
	private $action;

	/**
	 * @return string|WebServiceAction
	 */
	public function GetServiceAction()
	{
		return $this->action;
	}
	
	public function __construct($url, $description = '', $requestType = RequestType::GET, $serviceAction = WebServiceAction::DefaultAction)
	{
		$this->ref = $url;
		$this->description = $description;
		$this->requestType = $requestType;
		$this->action = $serviceAction;
	}

	/**
	 * @static
	 * @return RestAction
	 */
	public static function SignIn()
	{
		return new RestAction(
			self::GetUrl(WebServiceResource::Authentication),
			'SignIn',
			RequestType::POST);
	}

	/**
	 * @static
	 * @return SecureRestAction
	 */
	public static function SignOut()
	{
		return new SecureRestAction(
			self::GetUrl(WebServiceResource::Authentication, WebServiceAction::SignOut),
			'SignOut',
			RequestType::POST,
			WebServiceAction::SignOut);
	}

	/**
	 * @static
	 * @return SecureRestAction
	 */
	public static function AllBookings()
	{
		return new SecureRestAction(
			self::GetUrl(WebServiceResource::Bookings),
			'AllBookings');
	}

	/**
	 * @static
	 * @return SecureRestAction
	 */
	public static function MyBookings()
	{
		return new SecureRestAction(
			self::GetUrl(WebServiceResource::Bookings, WebServiceAction::MyBookings),
			'MyBookings',
			RequestType::GET,
			WebServiceAction::MyBookings);
	}

	/**
	 * @static
	 * @return SecureRestAction
	 */
	public static function CreateBooking()
	{
		return new SecureRestAction(
			self::GetUrl(WebServiceResource::Bookings, WebServiceAction::Create),
			'CreateBooking',
			RequestType::POST,
			WebServiceAction::Create);
	}

	/**
	 * @static
	 * @param string $serviceResource
	 * @param string $serviceAction
	 * @return string
	 */
	private static function GetUrl($serviceResource, $serviceAction = WebServiceAction::DefaultAction)
	{
		return sprintf('%s/%s?action=%s', self::GetBaseServiceUrl(), $serviceResource, $serviceAction);
	}

	/**
	 * @static
	 * @return string
	 */
	private static function GetBaseServiceUrl()
	{
		$url = Configuration::Instance()->GetScriptUrl();
		return $url . '/Services';
	}
}

?>