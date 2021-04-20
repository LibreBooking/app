<?php

@define('BASE_DIR', dirname(__FILE__) . '/../..');
require_once(BASE_DIR . '/lib/PHPMailer.class.php');

class FakeMailer extends PHPMailer
{
	var $addresses = array();
	var $Subject = null;
	var $Body = null;
	var $sendWasCalled = false;
	var $isHtml = true;

	function FakeMailer() {

	}

	function AddAddress($address, $name = '') {
		$this->addresses[] = $address;
	}

	function Send() {
		$this->sendWasCalled = true;
	}

	function IsHTML($bool) {
		$this->isHtml = $bool;
	}
}
