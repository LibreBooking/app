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

require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageAttributesPresenter.php');

interface IManageAttributesPage extends IActionPage
{
}

class ManageAttributesPage extends AdminPage implements IManageAttributesPage
{
	/**
	 * @var ManageAttributesPresenter
	 */
	private $presenter;

	public function __construct()
	{
		parent::__construct('CustomAttributes');
		$this->presenter = new ManageAttributesPresenter($this);
	}

	public function PageLoad()
	{
		$this->presenter->PageLoad();

		$this->Display('manage_attributes.tpl');
	}


	public function ProcessAction()
	{
		$this->presenter->ProcessAction();
	}
}

?>