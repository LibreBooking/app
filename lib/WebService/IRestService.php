<?php
interface IRestService
{
	/**
	 * @abstract
	 * @param IRestServer $server
	 * @return RestResponse
	 */
	public function HandlePost(IRestServer $server);

	/**
	 * @abstract
	 * @param IRestServer $server
	 * @return RestResponse
	 */
	public function HandleGet(IRestServer $server);
}
?>