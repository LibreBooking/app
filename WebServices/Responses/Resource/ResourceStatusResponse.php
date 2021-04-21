<?php

require_once(ROOT_DIR . 'lib/WebService/namespace.php');

class ResourceStatusResponse extends RestResponse
{
	public $statuses = array();

	public function __construct()
	{
		$this->statuses = array(
			array('id' => ResourceStatus::HIDDEN, 'name' => 'Hidden'),
			array('id' => ResourceStatus::AVAILABLE, 'name' => 'Available'),
			array('id' => ResourceStatus::UNAVAILABLE, 'name' => 'Unavailable'),
		);
	}

}

