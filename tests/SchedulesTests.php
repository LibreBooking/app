<?php
require_once(ROOT_DIR . 'lib/Domain/Access/namespace.php');

class SchedulesTests extends TestBase
{
	private $scheduleRepository;
	
	public function setup()
	{
		parent::setup();
		
		$this->scheduleRepository = new ScheduleRepository();
	}
	
	public function teardown()
	{
		parent::teardown();
		
		$this->scheduleRepository = null;
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
		
		$actualSchedules = $this->scheduleRepository->GetAll();
		
		$this->assertEquals(new GetAllSchedulesCommand(), $this->db->_Commands[0]);
		$this->assertTrue($this->db->GetReader(0)->_FreeCalled);
		$this->assertEquals($expected, $actualSchedules);
	}
	
	public function testCanGetLayoutForSchedule()
	{
		throw new Exception("Should be the last thing needed to do to get the schedule to render");
		$scheduleId = 109;
		$targetTimezone = 'US/Central';
		
		$layout = $this->scheduleRepository->GetLayout($scheduleId);
	}
}

?>