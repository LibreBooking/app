<?php
require_once(ROOT_DIR . 'Domain/Access/AnnouncementRepository.php');

class AnnouncementRepositoryTests extends TestBase
{
    /**
     * @var AnnouncementRepository
     */
	private $announcements;
	
	public function setup()
	{
		parent::setup();
		
		Date::_SetNow(new Date());
		
		$this->announcements = new AnnouncementRepository();
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
		
		$fakeAnc = new FakeAnnouncementRepository();
		
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

    public function testGetsAllAnnouncements()
    {
        $text1 = 'text1';
        $text2 = 'text2';
        $start1 = null;
        $start2 = '2011-01-01';
        $end1 = null;
        $end2 = '2011-01-01';
        $priority1 = 3;
        $priority2 = null;

        $rows = array();
        $rows[] = $this->GetAnnouncementRow(1, $text1, $start1, $end1, $priority1);
        $rows[] = $this->GetAnnouncementRow(2, $text2, $start2, $end2, $priority2);
        $this->db->SetRows($rows);
        $announcements = $this->announcements->GetAll();

        $expectedAnnouncements = array(
            new Announcement(1, $text1, Date::FromDatabase($start1), Date::FromDatabase($end1), $priority1),
            new Announcement(2, $text2, Date::FromDatabase($start2), Date::FromDatabase($end2), $priority2),
        );

        $this->assertEquals(new GetAllAnnouncementsCommand(), $this->db->_LastCommand);
        $this->assertEquals($expectedAnnouncements, $announcements);
    }

    private function GetAnnouncementRow($id, $text, $startDate, $endDate, $priority)
    {
        return array(
            ColumnNames::ANNOUNCEMENT_ID => $id,
            ColumnNames::ANNOUNCEMENT_TEXT => $text,
            ColumnNames::ANNOUNCEMENT_START => $startDate,
            ColumnNames::ANNOUNCEMENT_END => $endDate,
            ColumnNames::ANNOUNCEMENT_PRIORITY => $priority);
    }
}
?>