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

require_once(ROOT_DIR . 'Pages/ActionPage.php');
require_once(ROOT_DIR . 'Pages/SecurePage.php');

class AdminPageDecorator extends ActionPage implements IActionPage
{
	/**
	 * @var ActionPage
	 */
	private $page;

	public function __construct(ActionPage $page)
	{
		$this->page = $page;
	}

	public function PageLoad()
	{
		$user = ServiceLocator::GetServer()->GetUserSession();

		if (!$this->page->IsAuthenticated() || !$user->IsAdmin)
		{
			$this->Redirect($this->GetLastPage());
			die();
		}

		$this->page->PageLoad();
	}

	public function TakingAction()
	{
		return $this->page->TakingAction();
	}

	public function RequestingData()
	{
		return $this->page->RequestingData();
	}

	public function GetAction()
	{
		return $this->page->GetAction(QueryStringKeys::ACTION);
	}

	public function GetDataRequest()
	{
		return $this->page->GetDataRequest(QueryStringKeys::DATA_REQUEST);
	}

	public function IsValid()
	{
		return $this->page->IsValid();
	}

	public function ProcessAction()
	{
		$this->page->ProcessAction();
	}

	public function ProcessDataRequest()
	{
		$this->page->ProcessDataRequest();
	}
}

abstract class AdminPage extends SecurePage implements IActionPage
{
	public function __construct($titleKey = '', $pageDepth = 1)
	{
		parent::__construct($titleKey, $pageDepth);

		$user = ServiceLocator::GetServer()->GetUserSession();

		if (!$user->IsAdmin)
		{
			$this->Redirect($this->GetResumeUrl());
			die();
		}
	}

	public function Display($adminTemplateName)
	{
		parent::Display('Admin/' . $adminTemplateName);
	}

	public function TakingAction()
	{
		$action = $this->GetAction();
		return !empty($action);
	}

	public function RequestingData()
	{
		$dataRequest = $this->GetDataRequest();
		return !empty($dataRequest);
	}

	public function GetAction()
	{
		return $this->GetQuerystring(QueryStringKeys::ACTION);
	}

	public function GetDataRequest()
	{
		return $this->GetQuerystring(QueryStringKeys::DATA_REQUEST);
	}

	public function IsValid()
	{
		if (parent::IsValid())
		{
			Log::Debug('Action passed all validations');
			return true;
		}

		$errors = new ActionErrors();

		foreach ($this->smarty->failedValidatorIds as $validator)
		{
			Log::Debug('Failed validator %s', $validator);
			$errors->AddId($validator);
		}

		$this->SetJson($errors);
		return false;
	}

	public abstract function ProcessAction();
}

?>