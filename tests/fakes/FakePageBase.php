<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'Pages/IPage.php');

class FakePageBase implements IPage
{
	public $_RedirectCalled = false;
	public $_RedirectDestination = '';
	public $_IsPostBack = false;
	public $_IsValid = true;
	public $_Validators = array();
	public $_LastPage = '';
	
	public function Redirect($destination)
	{
		$this->_RedirectCalled = true;
		$this->_RedirectDestination = $destination;
	}
	
	public function RedirectToError($errorMessageId = ErrorMessages::UNKNOWN_ERROR, $lastPage = '')
	{
		// implement me?
	}
	
	public function IsPostBack()
	{
		return $this->_IsPostBack;
	}
	
	public function IsValid()
	{
		return $this->_IsValid;
	}
	
	public function RegisterValidator($validatorId, $validator)
	{
		$this->_Validators[$validatorId] = $validator;
	}
	
	public function GetLastPage()
	{
		return $this->_LastPage;
	}
}