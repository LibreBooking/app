<?php
/**
Copyright 2012 Nick Korbel

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

interface IActionPage extends IPage
{
	public function TakingAction();

	public function GetAction();

	public function RequestingData();

	public function GetDataRequest();
}

abstract class ActionPage extends Page implements IActionPage
{
	public function __construct($titleKey, $pageDepth)
	{
		parent::__construct($titleKey, $pageDepth);
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

	/**
	 * @abstract
	 * @return void
	 */
	public abstract function ProcessAction();

	/**
	 * @abstract
	 * @return void
	 */
	public abstract function ProcessDataRequest();
}
?>