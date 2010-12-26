<?php
require_once(ROOT_DIR . 'Domain/Announcements.php');

class AnnouncementsTests extends TestBase
{
	private $announcements;
	
	public function setup()
	{
		parent::setup();
		
		Date::_SetNow(new Date());
		
		$this->announcements = new Announcements();
	}
	
	public function teardown()
	{
		parent::teardown();
		
		Date::_ResetNow();
		
		$this->announcements = null;
	}
	
	public function testGetFutureCallDBCorrectly()
	{
		$now = Date::Now();
		
		$fakeAnc = new FakeAnnouncements();
		
		$rows = $fakeAnc->GetRows();
		$this->db->SetRow(0, $rows);
		
		$expectedAnnouncements = array();
		foreach($rows as $item)
		{
			$expectedAnnouncements[] = $item[ColumnNames::ANNOUNCEMENT_TEXT];
		}
		
		$actualRows = $this->announcements->GetFuture();
		
		$this->assertEquals(new GetDashboardAnnouncementsCommand($now), $this->db->_Commands[0]);
		$this->assertTrue($this->db->GetReader(0)->_FreeCalled);
		$this->assertEquals($expectedAnnouncements, $actualRows);
	}
}
?>