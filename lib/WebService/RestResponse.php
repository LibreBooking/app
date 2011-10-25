<?php
class RestResponse
{
	public $Actions = array();
	public $StatusCode = '200';
	public $Body = null;
}

class NullRestResponse extends RestResponse
{

}

class NotFoundResponse
{
	
}

?>