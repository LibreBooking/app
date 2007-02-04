<?php
/**
* Builds and sends the email for reservation reminders
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 03-16-06
* @package phpScheduleIt
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/

include_once('interfaces/IEmail.php');

class ReminderEmail extends IEmail
{
	var $_mailer = null;
	
	/**
	* Builds a reminder email object from a Reminder
	* @param IMailer $mailer the IMailer object to use for sending the email
	*/
	function ReminderEmail(&$mailer) {
		$this->_mailer =& $mailer;
	}
	
	function send() {
		$this->_mailer->Send();
	}
	
	function addAddress($address, $name = '') {
		$this->_mailer->AddAddress($address);
	}
	
	function addCC($address, $name = '') {
		die('Not implemented');
	}
	
	function addBCC($address, $name = '') {
		die('Not implemented');
	}
	
	function isHTML($isHtml = false) {
		$this->_mailer->IsHTML($isHtml);
	}
	
	function setFrom($address, $name = '') {
		$this->_mailer->From = $address;
		$this->_mailer->FromName = $name;
	}
	
	function setSubject($subject) {
		$this->_mailer->Subject = $subject;
	}
	
	function setBody($body) {
		$this->_mailer->Body = $body;
	}
	
	function buildFromReminder($reminder) {
		$this->addAddress($reminder->email);
		$this->setFrom($reminder->email);
		$this->setSubject($this->_buildSubject($reminder));
		$this->setBody($this->_buildBody($reminder));
		$this->isHTML(false);
	}
	
	function _buildSubject($reminder) {
		return translate('Reminder Subject', array($reminder->resource_name, Time::formatDate($reminder->start_date), Time::formatTime($reminder->start_time)));
	}
	
	function _buildBody($reminder) {
		return translate_email('Reminder Body', $reminder->resource_name, Time::formatDate($reminder->start_date), Time::formatTime($reminder->start_time), Time::formatDate($reminder->end_date), Time::formatTime($reminder->end_time));
	}
}
?>