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

abstract class ActionPresenter
{
	/**
	 * @var IActionPage
	 */
	private $actionPage;

	/**
	 * @var array
	 */
	private $actions;

	/**
	 * @var array
	 */
	private $validations;

	protected function __construct(IActionPage $page)
	{
		$this->actionPage = $page;
		$this->actions = array();
		$this->validations = array();
	}

	/**
	 * @param string $actionName
	 * @param string $actionMethod
	 * @return void
	 */
	protected function AddAction($actionName, $actionMethod)
	{
		$this->actions[$actionName] = $actionMethod;
	}

	protected function AddValidation($actionName, $validationMethod)
	{
		$this->validations[$actionName] = $validationMethod;
	}

	protected function ActionIsKnown($action)
	{
		return isset($this->actions[$action]);
	}

	protected function LoadValidators($action)
	{
		// Hook for children to load validators
	}

	public function ProcessAction()
	{
		/** @var $action string */
		$action = $this->actionPage->GetAction();

		if ($this->ActionIsKnown($action))
		{
			$this->actionPage->EnforceCSRFCheck();

			$method = $this->actions[$action];
			try
			{
				$this->LoadValidators($action);

				if ($this->actionPage->IsValid())
				{
					Log::Debug("Processing page action. Action %s", $action);
					$this->$method();
				}
			}
			catch (Exception $ex)
			{
				Log::Error("ProcessAction Error. Action %s, Error %s", $action, $ex);
			}
		}
		else
		{
			Log::Error("Unknown action %s", $action);
		}
	}
}