<?php

require_once(ROOT_DIR . 'lib/external/Slim/Slim.php');
require_once(ROOT_DIR . 'lib/WebService/IRestServer.php');

class SlimServer implements IRestServer
{
    /**
     * @var Slim\Slim
     */
    private $slim;

    /**
     * @var WebServiceUserSession
     */
    private $session;

    public function __construct(Slim\Slim $slim)
    {
        $this->slim = $slim;
    }

    public function GetRequest()
    {
        return json_decode($this->slim->request()->getBody());
    }

    public function WriteResponse(RestResponse $restResponse, $statusCode = 200)
    {
        $this->slim->response()->header('Content-Type', 'application/json');
        $this->slim->response()->status($statusCode);
        $this->slim->response()->write(json_encode($restResponse));
        unset($restResponse);
    }

    public function GetServiceUrl($serviceName, $params = [])
    {
        return $this->slim->urlFor($serviceName, $params);
    }

    public function GetUrl()
    {
        return $this->slim->environment()->offsetGet('slim.url_scheme') . '://' . $this->slim->environment()->offsetGet('HOST');
    }

    public function GetFullServiceUrl($serviceName, $params = [])
    {
        return $this->GetUrl() . $this->GetServiceUrl($serviceName, $params);
    }

    public function GetHeader($headerName)
    {
        return $this->slim->request()->headers($headerName);
    }

    public function SetSession(WebServiceUserSession $session)
    {
        $this->session = $session;
    }

    public function GetSession()
    {
        return $this->session;
    }

    /**
     * @param string $queryStringKey
     * @return string|null
     */
    public function GetQueryString($queryStringKey)
    {
        return $this->slim->request()->get($queryStringKey);
    }
}
