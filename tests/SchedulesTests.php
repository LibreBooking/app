<?php
require_once(ROOT_DIR . 'lib/Domain/Access/namespace.php');

class SchedulesTests extends TestBase
{
	private $schedules;
	
	public function setup()
	{
		parent::setup();
		
		$this->schedules = new ScheduleRepository();
	}
	
	public function teardown()
	{
		parent::teardown();
		
		$this->schedules = null;
	}
	
	public function testCanGetAllSchedules()
	{
		$fakeSchedules = new FakeScheduleRepository();
		
		
		$rows = $fakeSchedules->GetRows();
		$this->db->SetRow(0, $rows);
		
		$expected = array();
		foreach ($rows as $item)
		{
			$expected[] = new Schedule(
							$item[ColumnNames::SCHEDULE_ID],
							$item[ColumnNames::SCHEDULE_NAME],
							$item[ColumnNames::SCHEDULE_DEFAULT],
							$item[ColumnNames::SCHEDULE_START],
							$item[ColumnNames::SCHEDULE_END],
							$item[ColumnNames::SCHEDULE_WEEKDAY_START],
							$item[ColumnNames::SCHEDULE_ADMIN_ID],
							$item[ColumnNames::SCHEDULE_DAYS_VISIBLE]
						);
		}
		
		$actualSchedules = $this->schedules->GetAll();
		
		$this->assertEquals(new GetAllSchedulesCommand(), $this->db->_Commands[0]);
		$this->assertTrue($this->db->GetReader(0)->_FreeCalled);
		$this->assertEquals($expected, $actualSchedules);
	}
}

?>