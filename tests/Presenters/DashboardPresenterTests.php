<?php
/**
Copyright 2011-2013 Nick Korbel

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

require_once(ROOT_DIR . 'Presenters/DashboardPresenter.php');
require_once(ROOT_DIR . 'Pages/DashboardPage.php');

class DashboardPresenterTests extends TestBase
{
	private $presenter;
	private $page;

	public function setup()
	{
		parent::setup();

		Date::_SetNow(mktime());

		$this->page = new FakeDashboardPage();

		$this->presenter = new DashboardPresenter($this->page);
	}

	public function teardown()
	{
		parent::teardown();

		Date::_SetNow(null);
	}
}

class FakeDashboardPage implements IDashboardPage
{
	function AddItem(DashboardItem $item)
	{
		// TODO: Implement AddItem() method.
	}
}

?>