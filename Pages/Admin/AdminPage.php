<?php
/**
Copyright 2011-2019 Nick Korbel

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
			$this->RedirectResume(sprintf("%s%s?%s=%s", $this->page->path, Pages::LOGIN, QueryStringKeys::REDIRECT, urlencode($this->page->server->GetUrl())));
			die();
		}

		$this->page->PageLoad();
	}

	public function IsValid()
	{
		return $this->page->IsValid();
	}

	public function ProcessAction()
	{
		$this->page->ProcessAction();
	}

	public function ProcessDataRequest($dataRequest)
	{
		$this->page->ProcessDataRequest($dataRequest);
	}

	public function ProcessPageLoad()
	{
		$this->page->ProcessPageLoad();
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
			$this->RedirectResume(sprintf("%s%s?%s=%s", $this->path, Pages::LOGIN, QueryStringKeys::REDIRECT, urlencode($this->server->GetUrl())));
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
		$inlineErrors = array();

		foreach ($this->smarty->failedValidators as $validator)
		{
			Log::Debug('Failed validator %s', $validator);
			$errors->Add($validator);

			if ($validator->ReturnsErrorResponse())
			{
				http_response_code(400);
				array_merge($validator->Messages(), $inlineErrors);
			}
		}

		if (!empty($inlineErrors))
		{
			$this->SetJson(implode(',', $inlineErrors));
		}
		else{
			$this->SetJson($errors);
		}
		return false;
	}
}