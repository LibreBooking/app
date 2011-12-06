<?php
require_once(ROOT_DIR . 'lib/WebService/RestResponse.php');

interface IRestServer
{
	/**
	 * @abstract
	 * @return bool
	 */
	public function IsPost();

	/**
	 * @abstract
	 * @return bool
	 */
	public function IsGet();

	/**
	 * @abstract
	 * @param RestResponse $response
	 * @return void
	 */
	public function Respond(RestResponse $response);

    /**
     * @abstract
     * @param IExactRestResponse $response
     * @return void
     */
    public function RespondExact(IExactRestResponse $response);

	/**
	 * @abstract
	 * @param string $variableName
	 * @return mixed
	 */
	public function GetPost($variableName);

	/**
	 * @abstract
	 * @param string $variableName
	 * @return mixed
	 */
	public function GetQueryString($variableName);

	/**
	 * @abstract
	 * @return UserSession
	 */
	public function GetUserSession();

	/**
	 * @abstract
	 * @return string|WebServiceAction
	 */
	public function GetServiceAction();

}

?>