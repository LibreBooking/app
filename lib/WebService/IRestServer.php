<?php

require_once(ROOT_DIR . 'lib/WebService/RestResponse.php');
require_once(ROOT_DIR . 'Domain/Values/WebService/WebServiceUserSession.php');

interface IRestServer
{
    /**
     * @return mixed
     */
    public function GetRequest();

    /**
     * @param RestResponse $restResponse
     * @param int $statusCode
     * @return void
     */
    public function WriteResponse(RestResponse $restResponse, $statusCode = 200);

    /**
     * @param string $serviceName
     * @param array $params
     * @return string
     */
    public function GetServiceUrl($serviceName, $params = []);

    /**
     * @return string
     */
    public function GetUrl();

    /**
     * @param string $serviceName
     * @param array $params
     * @return string
     */
    public function GetFullServiceUrl($serviceName, $params = []);

    /**
     * @param string $headerName
     * @return string|null
     */
    public function GetHeader($headerName);

    /**
     * @param WebServiceUserSession $session
     * @return void
     */
    public function SetSession(WebServiceUserSession $session);

    /**
     * @return WebServiceUserSession|null
     */
    public function GetSession();

    /**
     * @param string $queryStringKey
     * @return string|null
     */
    public function GetQueryString($queryStringKey);
}
