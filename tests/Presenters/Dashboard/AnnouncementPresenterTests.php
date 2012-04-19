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

require_once(ROOT_DIR . 'Presenters/Dashboard/AnnouncementPresenter.php');
require_once(ROOT_DIR . 'Controls/Dashboard/AnnouncementsControl.php');

class AnnouncementPresenterTests extends TestBase
{
	private $presenter;
	private $page;
	private $announcements;
	
	public function setup()
	{
		parent::setup();
		
		Date::_SetNow(new Date());
		
		$this->page = new FakeAnnouncementsControl();
		
		$this->announcements = new FakeAnnouncementRepository();
		$this->presenter = new AnnouncementPresenter($this->page, $this->announcements);
	}
	
	public function teardown()
	{
		parent::teardown();
		
		Date::_ResetNow();
	}
	
	public function testShowsAllAnnouncements()
	{
		$now = Date::Now();
		
		$announcements = $this->GetAnnouncementRows();
		$this->db->SetRow(0, $announcements);
		
		$expectedAnnouncements = array();
		foreach($announcements as $item)
		{
			$expectedAnnouncements[] = $item[ColumnNames::ANNOUNCEMENT_TEXT];
		}
		
		$this->presenter->PageLoad();
		
		$this->assertEquals($this->announcements->_ExpectedAnnouncements, $this->page->_LastAnnouncements);
		$this->assertTrue($this->announcements->_GetFutureCalled);
	}
	
	private function GetAnnouncementRows()
	{
		return array(
			array (ColumnNames::ANNOUNCEMENT_TEXT => 'announcement 1'),
			array (ColumnNames::ANNOUNCEMENT_TEXT => 'announcement 2'),
			array (ColumnNames::ANNOUNCEMENT_TEXT => 'announcement 3')
		);
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