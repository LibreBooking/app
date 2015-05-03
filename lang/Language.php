<?php
/**
Copyright 2011-2015 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

abstract class Language
{
	public $Charset = 'UTF-8';
	public $Dates = array();
	public $Strings = array();
	public $Days = array();
	public $Months = array();
	public $Letters = array();
	public $HtmlLang;
	public $TextDirection = 'ltr';

	public function __construct()
	{
		$this->_LoadDates();
		$this->_LoadStrings();
		$this->_LoadDays();
		$this->_LoadMonths();
		$this->_LoadLetters();

        $this->HtmlLang = $this->_GetHtmlLangCode();
	}

	abstract protected function _LoadDates();

	abstract protected function _LoadStrings();

	abstract protected function _LoadDays();

	abstract protected function _LoadMonths();

	abstract protected function _LoadLetters();

    abstract protected function _GetHtmlLangCode();
}