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

require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class ScheduleRepositoryTests extends TestBase
{
    /**
     * @var ScheduleRepository
     */
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
							$item[ColumnNames::SCHEDULE_WEEKDAY_START],
							$item[ColumnNames::SCHEDULE_DAYS_VISIBLE],
							$item[ColumnNames::TIMEZONE_NAME]
						);
		}
		
		$actualSchedules = $this->scheduleRepository->GetAll();
		
		$this->assertEquals(new GetAllSchedulesCommand(), $this->db->_Commands[0]);
		$this->assertTrue($this->db->GetReader(0)->_FreeCalled);
		$this->assertEquals($expected, $actualSchedules);
	}
	
	public function testCanGetLayoutForSchedule()
	{
		$timezone = 'America/New_York';
		
		$layoutRows[] = array(
						ColumnNames::BLOCK_START => '02:00:00',
						ColumnNames::BLOCK_END => '03:00:00',
						ColumnNames::BLOCK_LABEL => 'PERIOD1',
						//ColumnNames::BLOCK_LABEL_END => 'END PERIOD1',
						ColumnNames::BLOCK_CODE => PeriodTypes::RESERVABLE,
						ColumnNames::BLOCK_TIMEZONE => $timezone,
						);
		
		$layoutRows[] = array(
						ColumnNames::BLOCK_START => '03:00:00',
						ColumnNames::BLOCK_END => '04:00:00',
						ColumnNames::BLOCK_LABEL => 'PERIOD2',
						//ColumnNames::BLOCK_LABEL_END => 'END PERIOD2',
						ColumnNames::BLOCK_CODE => PeriodTypes::RESERVABLE,
						ColumnNames::BLOCK_TIMEZONE => $timezone,
						);
						
		$layoutRows[] = array(
						ColumnNames::BLOCK_START => '04:00:00',
						ColumnNames::BLOCK_END => '05:00:00',
						ColumnNames::BLOCK_LABEL => 'PERIOD3',
						//ColumnNames::BLOCK_LABEL_END => 'END PERIOD3',
						ColumnNames::BLOCK_CODE => PeriodTypes::NONRESERVABLE,
						ColumnNames::BLOCK_TIMEZONE => $timezone,
						);
		
		$this->db->SetRows($layoutRows);
		
		$scheduleId = 109;
		$targetTimezone = 'America/Chicago';
		
		$layoutFactory = $this->getMock('ILayoutFactory');
		$expectedLayout = new ScheduleLayout($timezone);
		
		$layoutFactory->expects($this->once())
			->method('CreateLayout')
			->will($this->returnValue($expectedLayout));
		
		$layout = $this->scheduleRepository->GetLayout($scheduleId, $layoutFactory);
		
		$this->assertEquals(new GetLayoutCommand($scheduleId), $this->db->_Commands[0]);
		$this->assertTrue($this->db->GetReader(0)->_FreeCalled);
		
		$layoutDate = Date::Parse("2010-01-01", $timezone);
		$periods = $layout->GetLayout($layoutDate);
		$this->assertEquals(3, count($periods));
		
		$start = $layoutDate->SetTime(new Time(2,0,0));
		$end = $layoutDate->SetTime(new Time(3,0,0));
		
		$period = new SchedulePeriod($start, $end, 'PERIOD1');
		$this->assertEquals($period, $periods[0]);
	}
	
	public function testCanGetScheduleById()
	{
		$id = 10;
		$name = 'super schedule';
		$isDefault = 0;
		$weekdayStart = 5;
		$daysVisible = 3;
		$timezone = 'America/Chicago';
		$layoutId = 988;
		
		$fakeSchedules = new FakeScheduleRepository();
		$expectedSchedule = new Schedule($id, 
									$name, 
									$isDefault, 
									$weekdayStart, 
									$daysVisible,
									$timezone,
									$layoutId);
									
		$this->db->SetRows(array($fakeSchedules->GetRow($id, $name, $isDefault, $weekdayStart, $daysVisible, $timezone, $layoutId)));
		$actualSchedule = $this->scheduleRepository->LoadById($id);
		
		$this->assertEquals($expectedSchedule, $actualSchedule);
		$this->assertEquals(new GetScheduleByIdCommand($id), $this->db->_LastCommand);
	}

    public function testCanGetScheudleByPublicId()
    {
        $publicId = uniqid();
        $fakeSchedules = new FakeScheduleRepository();

        $this->db->SetRows(array($fakeSchedules->GetRow()));
        $actualSchedule = $this->scheduleRepository->LoadByPublicId($publicId);

        $this->assertNotNull($actualSchedule);
        $this->assertEquals(new GetScheduleByPublicIdCommand($publicId), $this->db->_LastCommand);
    }
	
	public function testCanUpdateSchedule()
	{
		$id = 10;
		$name = 'super schedule';
		$isDefault = 0;
		$weekdayStart = 5;
		$daysVisible = 3;
		
		$schedule = new Schedule($id, 
								$name, 
								$isDefault, 
								$weekdayStart, 
								$daysVisible);
									
		$actualSchedule = $this->scheduleRepository->Update($schedule);
		
		$this->assertEquals(new UpdateScheduleCommand($id, $name, $isDefault, $weekdayStart, $daysVisible), $this->db->_LastCommand);
	}
	
	public function testCanChangeLayout()
	{
		$scheduleId = 89;
		$layoutId = 90;
		$timezone = 'America/New_York';
		
		$start1 = new Time(0,0);
		$end1 = new Time(12,0);
		$label1 = 'label 1';
		
		$start2 = new Time(12,0);
		$end2 = new Time(0,0);
		
		$slots = array(
			new LayoutPeriod($start1, $end1, PeriodTypes::RESERVABLE, $label1),
			new LayoutPeriod($start2, $end2, PeriodTypes::NONRESERVABLE),
			);
		
		$layout = $this->getMock('ILayoutCreation');
		
		$layout->expects($this->once())
			->method('Timezone')
			->will($this->returnValue($timezone));
		
		$layout->expects($this->once())
			->method('GetSlots')
			->will($this->returnValue($slots));
			
		$this->db->_ExpectedInsertId = $layoutId;
		
		$this->scheduleRepository->AddScheduleLayout($scheduleId, $layout);
		
		$actualInsertBlockGroup = $this->db->_Commands[0];
		$actualInsertBlock1 = $this->db->_Commands[1];
		$actualInsertBlock2 = $this->db->_Commands[2];
		$actualInsertScheduleBlock = $this->db->_Commands[3];
		
		$expectedInsertBlockGroup = new AddLayoutCommand($timezone);
		$expectedInsertBlockGroup1 = new AddLayoutTimeCommand($layoutId, $start1, $end1, PeriodTypes::RESERVABLE, $label1);
		$expectedInsertBlockGroup2 = new AddLayoutTimeCommand($layoutId, $start2, $end2, PeriodTypes::NONRESERVABLE, null);
		$expectedUpdateScheudleLayout = new UpdateScheduleLayoutCommand($scheduleId, $layoutId);
		
		$this->assertEquals($expectedInsertBlockGroup, $actualInsertBlockGroup);
		$this->assertEquals($expectedInsertBlockGroup1, $actualInsertBlock1);
		$this->assertEquals($expectedInsertBlockGroup2, $actualInsertBlock2);
		$this->assertEquals($actualInsertScheduleBlock, $actualInsertScheduleBlock);
	}
	
	public function testCanAddNewSchedule()
	{
		$layoutId = 87;
		$scheduleIdOfSourceLayout = 888;
		$name = 'new dude';
		$isDefault = false;
		$weekdayStart = 2;
		$daysVisible = 5;
		$scheduleIdOfSourceLayout = 981;
		
		$schedule = new Schedule(null, $name, $isDefault, $weekdayStart, $daysVisible, null, $layoutId);
		
		$expectedGetScheduleById = new GetScheduleByIdCommand($scheduleIdOfSourceLayout);
		
		$fakeSchedules = new FakeScheduleRepository();
		$this->db->SetRows(array($fakeSchedules->GetRow(9, null, true, 0, 0, null, $layoutId)));
		
		$expectedInsertScheduleCommand = new AddScheduleCommand($name, $isDefault, $weekdayStart, $daysVisible, $layoutId);
		
		$this->scheduleRepository->Add($schedule, $scheduleIdOfSourceLayout);
	}

    public function testCanDeleteSchedule()
    {
        $id = 123;
        $schedule = new Schedule($id, null, false, null, null);

        $deleteScheduleCommand = new DeleteScheduleCommand($id);

        $this->scheduleRepository->Delete($schedule);

        $actualDeleteCommand = $this->db->_LastCommand;

        $this->assertEquals($deleteScheduleCommand, $actualDeleteCommand);
    }
}

?>