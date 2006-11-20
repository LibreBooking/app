<?php

@define('BASE_DIR', dirname(__FILE__) . '/..');
require_once(BASE_DIR . '/lib/Resource.class.php');

class FakeResource extends Resource
{

	var $machid = 'fakeid';	
	var $db;
	var $properties = array();
	
	function FakeResource() {
		$this->properties['name'] = 'resource1';
		$this->properties['location'] = 'location1';
	}
}
?>