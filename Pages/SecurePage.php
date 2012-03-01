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

require_once(ROOT_DIR . 'Pages/Page.php');
require_once(ROOT_DIR . 'Pages/ActionPage.php');
require_once(ROOT_DIR . 'lib/Config/namespace.php');

abstract class SecurePage extends Page
{
	public function __construct($titleKey = '', $pageDepth = 0)
	{
		parent::__construct($titleKey, $pageDepth);

		if (!$this->IsAuthenticated())
		{
			$this->Redirect($this->GetResumeUrl());
			die();
		}
	}
	
	protected function GetResumeUrl()
	{
		return sprintf("%s%s?%s=%s", $this->path, Pages::LOGIN, QueryStringKeys::REDIRECT, $this->server->GetUrl());
	}
}

class SecureActionPageDecorator extends ActionPage
{
	/**
	 * @var ActionPage
	 */
	private $page;

	public function __construct(ActionPage $page)
	{
		$this->page = $page;

		if (!$this->page->IsAuthenticated())
		{
			$this->Redirect($this->GetResumeUrl());
			die();
		}
	}

	public function ProcessAction()
	{
		$this->page->ProcessAction();
	}

	public function ProcessDataRequest()
	{
		$this->page->ProcessDataRequest();
	}

	public function PageLoad()
	{
		$this->page->PageLoad();
	}

	protected function GetResumeUrl()
	{
		return sprintf("%s%s?%s=%s", $this->page->path, Pages::LOGIN, QueryStringKeys::REDIRECT, $this->page->server->GetUrl());
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
		return $this->page->GetAction();
	}

	public function GetDataRequest()
	{
		return $this->page->GetDataRequest();
	}

	public function IsValid()
	{
		return $this->page->IsValid();
	}

	public function Redirect($url)
	{
		$this->page->Redirect($url);
	}

	public function RedirectToError($errorMessageId = ErrorMessages::UNKNOWN_ERROR, $lastPage = '')
	{
		$this->page->RedirectToError($errorMessageId, $lastPage);
	}

	public function GetLastPage($defaultPage = '')
	{
		return $this->page->GetLastPage($defaultPage);
	}

	public function IsPostBack()
	{
		return $this->page->IsPostBack();
	}

	public function RegisterValidator($validatorId, $validator)
	{
		$this->page->RegisterValidator($validatorId, $validator);
	}
}

class SecurePageDecorator extends Page implements IPage
{
	/**
	 * @var Page
	 */
	private $page;

	public function __construct(Page $page)
	{
		$this->page = $page;

		if (!$this->page->IsAuthenticated())
		{
			$this->Redirect($this->GetResumeUrl());
			die();
		}
	}

	public function PageLoad()
	{
		$this->page->PageLoad();
	}

	public function Redirect($url)
	{
		$this->page->Redirect($url);
	}

	public function RedirectToError($errorMessageId = ErrorMessages::UNKNOWN_ERROR, $lastPage = '')
	{
		$this->page->RedirectToError($errorMessageId, $lastPage);
	}

	public function IsPostBack()
	{
		return $this->page->IsPostBack();
	}

	public function IsValid()
	{
		return $this->page->IsValid();
	}

	public function GetLastPage()
	{
		return $this->page->GetLastPage();
	}

	public function RegisterValidator($validatorId, $validator)
	{
		$this->page->RegisterValidator($validatorId, $validator);
	}

	protected function GetResumeUrl()
	{
		return sprintf("%s%s?%s=%s", $this->page->path, Pages::LOGIN, QueryStringKeys::REDIRECT, $this->page->server->GetUrl());
	}
}
?>