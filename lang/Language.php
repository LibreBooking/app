<?php
abstract class Language
{
	public $Charset = 'iso-8859-1';
	public $Dates = array();
	public $Strings = array();
	public $Emails = array();
	public $Days = array();
	public $Months = array();
	public $Letters = array();

	public function __construct()
	{
		$this->_LoadDates();
		$this->_LoadStrings();
		$this->_LoadEmails();
		$this->_LoadDays();
		$this->_LoadMonths();
		$this->_LoadLetters();
	}
	
	abstract protected function _LoadDates();
	
	abstract protected function _LoadStrings();
	
	abstract protected function _LoadEmails();
	
	abstract protected function _LoadDays();
	
	abstract protected function _LoadMonths();
	
	abstract protected function _LoadLetters();
}
?>