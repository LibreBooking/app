<?php
/**
* Interface for sending emails
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 03-23-06
* @package Interfaces
*
* Copyright (C) 2003 - 2006 phpScheduleIt
* License: GPL, see LICENSE
*/

$basedir = dirname(__FILE__) . '/../..';
require_once($basedir . '/lib/PHPMailer.class.php');

class IEmail 
{
	var $_mailer = null;
	
	function send() {
		die('Not implemented');
	}
	
	function addAddress($address, $name = '') {
		die('Not implemented');
	}
	
	function addCC($address, $name = '') {
		die('Not implemented');
	}
	
	function addBCC($address, $name = '') {
		die('Not implemented');
	}
	
	function isHTML($isHtml = false) {
		die('Not implemented');
	}
	
	function setFrom($address, $name = '') {
		die('Not implemented');
	}
	
	function setSubject($subject) {
		die('Not implemented');
	}
	
	function setBody($body) {
		die('Not implemented');
	}
}
?>
