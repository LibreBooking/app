<?php
/**
Copyright 2014-2019 Nick Korbel

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

require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');

interface IManageResourceStatusPage extends IActionPage
{
	public function BindResourceStatusReasons($statusReasonList);

	public function GetStatusId();

	public function GetDescription();

	public function GetReasonId();
}

class ManageResourceStatusPage extends ActionPage implements IManageResourceStatusPage
{
	/**
	 * @var ManageResourceTypesPresenter
	 */
	protected $presenter;

	public function __construct()
	{
		parent::__construct('ManageResourceStatus', 1);
		$this->presenter = new ManageResourceStatusPresenter($this,
															 ServiceLocator::GetServer()->GetUserSession(),
															 new ResourceRepository());
	}

	public function ProcessPageLoad()
	{
		$this->presenter->PageLoad();

		$this->Display('Admin/Resources/manage_resource_status.tpl');
	}

	/**
	 * @return void
	 */
	public function ProcessAction()
	{
		$this->presenter->ProcessAction();
	}

	/**
	 * @param $dataRequest string
	 * @return void
	 */
	public function ProcessDataRequest($dataRequest)
	{
		$this->presenter->ProcessDataRequest($dataRequest);
	}

	public function BindResourceStatusReasons($statusReasonList)
	{
		$this->Set('StatusReasons', $statusReasonList);
	}

	public function GetStatusId()
	{
		return $this->GetForm(FormKeys::RESOURCE_STATUS_ID);
	}

	public function GetDescription()
	{
		return $this->GetForm(FormKeys::RESOURCE_STATUS_REASON);
	}

	public function GetReasonId()
	{
		return $this->GetQuerystring(QueryStringKeys::RESERVATION_STATUS_REASON_ID);
	}
}