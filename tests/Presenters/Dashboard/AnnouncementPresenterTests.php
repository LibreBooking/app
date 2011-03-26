<?php
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
		
		$this->announcements = new FakeAnnouncements();
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