<?php
require_once(ROOT_DIR . 'lib/WebService/RestConstants.php');

class WebServiceResource
{
    const Authentication = 'Authentication';
    const Bookings = 'Bookings';
    const Resources = 'Resources';
}

class WebServiceAction
{
    const Create = 'create';
    const Delete = 'update';
    const DefaultAction = '';
    const MyBookings = 'mybookings';
    const SignOut = 'signout';
    const Update = 'update';
    const Validate = 'validate';
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
     * @return string
     */
    public function ToUrl()
    {
        return $this->ref;
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
     * @param WebServiceAction|string $action either WebServiceAction::Create or WebServiceAction::Validate
     * @return RestAction
     */
    public static function Captcha($action)
    {
        return new RestAction(
            self::GetUrl(WebServiceResource::Authentication, $action, 'captcha.php'),
            'Captcha',
            RequestType::GET,
            $action);
    }

    /**
     * @static
     * @param string $serviceResource
     * @param string $serviceAction
     * @param string $endpoint
     * @return string
     */
    private static function GetUrl($serviceResource, $serviceAction = WebServiceAction::DefaultAction, $endpoint = '')
    {
        return sprintf('%s/%s/%s?action=%s', self::GetBaseServiceUrl(), $serviceResource, $endpoint, $serviceAction);
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