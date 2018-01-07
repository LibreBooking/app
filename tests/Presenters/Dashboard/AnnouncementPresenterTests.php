<?php
/**
Copyright 2011-2018 Nick Korbel

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

require_once(ROOT_DIR . 'Presenters/Dashboard/AnnouncementPresenter.php');
require_once(ROOT_DIR . 'Controls/Dashboard/AnnouncementsControl.php');

class AnnouncementPresenterTests extends TestBase
{
	private $permissionService;
	/**
	 * @var AnnouncementPresenter
	 */
	private $presenter;

	/**
	 * @var FakeAnnouncementsControl
	 */
	private $page;

	/**
	 * @var FakeAnnouncementRepository
	 */
	private $announcements;

	public function setup()
	{
		parent::setup();

		Date::_SetNow(new Date());

		$this->page = new FakeAnnouncementsControl();

		$this->announcements = new FakeAnnouncementRepository();
		$this->permissionService = new FakePermissionService();
		$this->presenter = new AnnouncementPresenter($this->page, $this->announcements, $this->permissionService);
	}

	public function teardown()
	{
		parent::teardown();

		Date::_ResetNow();
	}

	public function testShowsAllAnnouncements()
	{
		$now = Date::Now();

		$announcement = new Announcement(1, 'text', $now, $now, 1, array(), array());
		$this->announcements->_ExpectedAnnouncements = array($announcement);

		$this->presenter->PageLoad();

		$this->assertEquals($this->announcements->_ExpectedAnnouncements, $this->page->_LastAnnouncements);
		$this->assertTrue($this->announcements->_GetFutureCalled);
	}
}

class FakeAnnouncementsControl implements IAnnouncementsControl
{
	public $_LastAnnouncements = array();

	public function SetAnnouncements($announcements)
	{
		$this->_LastAnnouncements = $announcements;
	}
}

?>