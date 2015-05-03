<?php
/**
Copyright 2012-2015 Nick Korbel

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
	public function __construct($titleKey, $pageDepth = 0)
	{
		parent::__construct($titleKey, $pageDepth);
	}

	public function PageLoad()
	{
		try
		{
			if ($this->TakingAction())
			{
				$this->ProcessAction();
			}
			else
			{
				if ($this->RequestingData())
				{
					$this->ProcessDataRequest($this->GetDataRequest());
				}
				else
				{
					$this->ProcessPageLoad();
				}
			}
		}
		catch (Exception $ex)
		{
			Log::Error('Error loading page. %s', $ex);
			throw $ex;
		}
	}
	/**
	 * @return bool
	 */
	public function TakingAction()
	{
		$action = $this->GetAction();
		return !empty($action);
	}

	/**
	 * @return bool
	 */
	public function RequestingData()
	{
		$dataRequest = $this->GetDataRequest();
		return !empty($dataRequest);
	}

	/**
	 * @return null|string
	 */
	public function GetAction()
	{
		return $this->GetQuerystring(QueryStringKeys::ACTION);
	}

	/**
	 * @return null|string
	 */
	public function GetDataRequest()
	{
		return $this->GetQuerystring(QueryStringKeys::DATA_REQUEST);
	}

	/**
	 * @return bool
	 */
	public function IsValid()
	{
		if (parent::IsValid())
		{
			Log::Debug('Action passed all validations');
			return true;
		}

		$errors = new ActionErrors();

		foreach ($this->smarty->failedValidators as $id => $validator)
		{
			Log::Debug('Failed validator %s', $id);
			$errors->Add($id, $validator->Messages());
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
	 * @param $dataRequest string
	 * @return void
	 */
	public abstract function ProcessDataRequest($dataRequest);

	/**
	 * @abstract
	 * @return void
	 */
	public abstract function ProcessPageLoad();
}

class ActionErrors
{
    public $ErrorIds = array();
	public $Messages = array();

    public function Add($id, $messages = array())
    {
        $this->ErrorIds[] = $id;
		$this->Messages[$id] = $messages;
    }
}
?>