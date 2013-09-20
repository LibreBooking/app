<?php
/**
Copyright 2011-2013 Nick Korbel

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

require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');

interface IManageResourceTypesPage extends IActionPage
{
	/**
	 * @param ResourceTypes[]|array $types
	 */
	public function BindResourceTypes($types);
}

class ManageResourceTypesPage extends ActionPage implements IManageResourceTypesPage
{
	/**
	 * @var ManageResourcesPresenter
	 */
	protected $_presenter;

	public function __construct()
	{
		parent::__construct('ManageResourceTypes', 1);
		$this->_presenter = new ManageResourceTypesPresenter($this,
															 ServiceLocator::GetServer()->GetUserSession(),
															 new ResourceRepository());
	}

	public function ProcessPageLoad()
	{
		$this->_presenter->PageLoad();

		$this->Display('Admin/manage_resource_types.tpl');
	}

	/**
	 * @return void
	 */
	public function ProcessAction()
	{
		$this->_presenter->ProcessAction();
	}

	/**
	 * @param $dataRequest string
	 * @return void
	 */
	public function ProcessDataRequest($dataRequest)
	{
		// TODO: Implement ProcessDataRequest() method.
	}

	/**
	 * @param ResourceTypes[]|array $types
	 */
	public function BindResourceTypes($types)
	{
		$this->Set('ResourceTypes', $types);
	}
}

?>