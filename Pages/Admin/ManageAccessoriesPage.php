<?php
/**
Copyright 2011-2014 Nick Korbel

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
require_once(ROOT_DIR . 'Presenters/Admin/ManageAccessoriesPresenter.php');

interface IManageAccessoriesPage extends IActionPage
{
	/**
	 * @abstract
	 * @return int
	 */
	public function GetAccessoryId();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetAccessoryName();

	/**
	 * @return int
	 */
	public function GetQuantityAvailable();

	/**
	 * @abstract
	 * @param $accessories AccessoryDto[]
	 * @return void
	 */
	public function BindAccessories($accessories);
}

class ManageAccessoriesPage extends ActionPage implements IManageAccessoriesPage
{
	/**
	 * @var ManageAccessoriesPresenter
	 */
	private $presenter;

	public function __construct()
	{
		parent::__construct('ManageAccessories', 1);
		$this->presenter = new ManageAccessoriesPresenter($this, new ResourceRepository(), new AccessoryRepository());
	}

	public function ProcessPageLoad()
	{
		$this->presenter->PageLoad();

		$this->Display('Admin/manage_accessories.tpl');
	}

	public function BindAccessories($accessories)
	{
		$this->Set('accessories', $accessories);
	}

	public function ProcessAction()
	{
		$this->presenter->ProcessAction();
	}

	/**
	 * @return int
	 */
	public function GetAccessoryId()
	{
		return $this->GetQuerystring(QueryStringKeys::ACCESSORY_ID);
	}

	/**
	 * @return string
	 */
	public function GetAccessoryName()
	{
		return $this->GetForm(FormKeys::ACCESSORY_NAME);
	}

	/**
	 * @return int
	 */
	public function GetQuantityAvailable()
	{
		return $this->GetForm(FormKeys::ACCESSORY_QUANTITY_AVAILABLE);
	}

	public function ProcessDataRequest($dataRequest)
	{
		// no-op
	}
}

?>