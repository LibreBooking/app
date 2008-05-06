<?php
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
		
		$this->assertEquals(new GetDashboardAnnouncementsCommand($now), $this->db->_Commands[0]);
		$this->assertEquals($expectedAnnouncements, $this->page->_LastAnnouncements);
		$this->assertTrue($this->db->GetReader(0)->_FreeCalled);
	}
	
	public function testNext()
	{
		$this->markTestIncomplete();
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

class FakeDashboardPage implements IDashboardPage 
{
	public $_LastAnnouncements = array();
	
	public function SetAnnouncements($announcements)
	{
		$this->_LastAnnouncements = $announcements;
	}
}

?>