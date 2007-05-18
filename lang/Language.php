<?php
class Language
{
	var $Charset = 'iso-8859-1';
	var $Dates = array();
	var $Strings = array();
	var $Emails = array();
	var $Days = array();
	var $Months = array();
	var $Letters = array();

	function Language()
	{
		$this->_LoadDates();
		$this->_LoadStrings();
		$this->_LoadEmails();
		$this->_LoadDays();
		$this->_LoadMonths();
		$this->_LoadLetters();
	}
	
	function _LoadDates()
	{
		die('Not implemented');
	}
	
	function _LoadStrings()
	{
		die('Not implemented');
	}
	
	function _LoadEmails()
	{
		die('Not implemented');
	}
	
	function _LoadDays()
	{
		die('Not implemented');
	}
	
	function _LoadMonths()
	{
		die('Not implemented');
	}
	
	function _LoadLetters()
	{
		die('Not implemented');
	}
}
?>