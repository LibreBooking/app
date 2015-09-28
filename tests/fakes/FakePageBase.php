<?php
/**
 * Copyright 2011-2015 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Pages/IPage.php');
require_once(ROOT_DIR . 'Pages/ActionPage.php');

class FakePageBase implements IPage
{
	public $_RedirectCalled = false;
	public $_RedirectDestination = '';
	public $_IsPostBack = false;
	public $_IsValid = true;
	public $_Validators = array();
	public $_LastPage = '';
	public $_InlineEditValidators = array();

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

	public function RegisterInlineEditValidator($validatorId, $validator)
	{
		$this->_InlineEditValidators[$validatorId] = $validator;
	}

	public function GetLastPage()
	{
		return $this->_LastPage;
	}

	public function PageLoad()
	{
		// TODO: Implement PageLoad() method.
	}

	public function EnforceCSRFCheck()
	{
		// TODO: Implement EnforceCSRFCheck() method.
	}
}

class FakeActionPageBase extends FakePageBase implements IActionPage
{

	public function TakingAction()
	{
		// TODO: Implement TakingAction() method.
	}

	public function GetAction()
	{
		// TODO: Implement GetAction() method.
	}

	public function RequestingData()
	{
		// TODO: Implement RequestingData() method.
	}

	public function GetDataRequest()
	{
		// TODO: Implement GetDataRequest() method.
	}

	public function EnforceCSRFCheck()
	{
		// TODO: Implement EnforceCSRFCheck() method.
	}
}