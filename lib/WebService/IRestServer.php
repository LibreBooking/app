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
	 * @param $variableName
	 * @return mixed
	 */
	public function GetPost($variableName);

	/**
	 * @abstract
	 * @param $variableName
	 * @return string
	 */
	public function GetQueryString($variableName);
}

?>