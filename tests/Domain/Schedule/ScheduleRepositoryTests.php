<?php
/**
 * Copyright 2011-2018 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
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
			$schedule = new Schedule(
					$item[ColumnNames::SCHEDULE_ID],
					$item[ColumnNames::SCHEDULE_NAME],
					$item[ColumnNames::SCHEDULE_DEFAULT],
					$item[ColumnNames::SCHEDULE_WEEKDAY_START],
					$item[ColumnNames::SCHEDULE_DAYS_VISIBLE],
					$item[ColumnNames::TIMEZONE_NAME]
			);
			$schedule->SetAdminGroupId($item[ColumnNames::SCHEDULE_ADMIN_GROUP_ID]);
			$schedule->SetAvailability(Date::FromDatabase($item[ColumnNames::SCHEDULE_AVAILABLE_START_DATE]), Date::FromDatabase($item[ColumnNames::SCHEDULE_AVAILABLE_END_DATE]));
			$expected[] = $schedule;
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
				ColumnNames::BLOCK_CODE => PeriodTypes::RESERVABLE,
				ColumnNames::BLOCK_TIMEZONE => $timezone,
				ColumnNames::BLOCK_DAY_OF_WEEK => null,
		);

		$layoutRows[] = array(
				ColumnNames::BLOCK_START => '03:00:00',
				ColumnNames::BLOCK_END => '04:00:00',
				ColumnNames::BLOCK_LABEL => 'PERIOD2',
				ColumnNames::BLOCK_CODE => PeriodTypes::RESERVABLE,
				ColumnNames::BLOCK_TIMEZONE => $timezone,
				ColumnNames::BLOCK_DAY_OF_WEEK => null,
		);

		$layoutRows[] = array(
				ColumnNames::BLOCK_START => '04:00:00',
				ColumnNames::BLOCK_END => '05:00:00',
				ColumnNames::BLOCK_LABEL => 'PERIOD3',
				ColumnNames::BLOCK_CODE => PeriodTypes::NONRESERVABLE,
				ColumnNames::BLOCK_TIMEZONE => $timezone,
				ColumnNames::BLOCK_DAY_OF_WEEK => null,
		);

		$this->db->SetRows($layoutRows);

		$scheduleId = 109;

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

		$start = $layoutDate->SetTime(new Time(2, 0, 0));
		$end = $layoutDate->SetTime(new Time(3, 0, 0));

		$period = new SchedulePeriod($start, $end, 'PERIOD1');
		$this->assertEquals($period, $periods[0]);
	}

	public function testCanGetLayoutForScheduleWhenDaily()
	{
		$timezone = 'America/New_York';

		$layoutRows[] = array(
				ColumnNames::BLOCK_START => '02:00:00',
				ColumnNames::BLOCK_END => '03:00:00',
				ColumnNames::BLOCK_LABEL => 'PERIOD1',
				ColumnNames::BLOCK_CODE => PeriodTypes::RESERVABLE,
				ColumnNames::BLOCK_TIMEZONE => $timezone,
				ColumnNames::BLOCK_DAY_OF_WEEK => DayOfWeek::SUNDAY,
		);

		$layoutRows[] = array(
				ColumnNames::BLOCK_START => '03:00:00',
				ColumnNames::BLOCK_END => '04:00:00',
				ColumnNames::BLOCK_LABEL => 'PERIOD2',
				ColumnNames::BLOCK_CODE => PeriodTypes::RESERVABLE,
				ColumnNames::BLOCK_TIMEZONE => $timezone,
				ColumnNames::BLOCK_DAY_OF_WEEK => DayOfWeek::SUNDAY,
		);

		$layoutRows[] = array(
				ColumnNames::BLOCK_START => '04:00:00',
				ColumnNames::BLOCK_END => '05:00:00',
				ColumnNames::BLOCK_LABEL => 'PERIOD3',
				ColumnNames::BLOCK_CODE => PeriodTypes::NONRESERVABLE,
				ColumnNames::BLOCK_TIMEZONE => $timezone,
				ColumnNames::BLOCK_DAY_OF_WEEK => DayOfWeek::MONDAY,
		);

		$layoutRows[] = array(
				ColumnNames::BLOCK_START => '04:00:00',
				ColumnNames::BLOCK_END => '05:00:00',
				ColumnNames::BLOCK_LABEL => 'PERIOD3',
				ColumnNames::BLOCK_CODE => PeriodTypes::NONRESERVABLE,
				ColumnNames::BLOCK_TIMEZONE => $timezone,
				ColumnNames::BLOCK_DAY_OF_WEEK => DayOfWeek::TUESDAY,
		);

		$this->db->SetRows($layoutRows);

		$scheduleId = 109;

		$layoutFactory = $this->getMock('ILayoutFactory');
		$expectedLayout = new ScheduleLayout($timezone);

		$layoutFactory->expects($this->once())
					  ->method('CreateLayout')
					  ->will($this->returnValue($expectedLayout));

		$layout = $this->scheduleRepository->GetLayout($scheduleId, $layoutFactory);

		$this->assertEquals(new GetLayoutCommand($scheduleId), $this->db->_Commands[0]);
		$this->assertTrue($this->db->GetReader(0)->_FreeCalled);

		$sunday = Date::Parse("2013-01-06", $timezone);
		$periods = $layout->GetLayout($sunday);
		$this->assertEquals(2, count($periods));

		$start = $sunday->SetTime(new Time(2, 0, 0));
		$end = $sunday->SetTime(new Time(3, 0, 0));

		$period = new SchedulePeriod($start, $end, 'PERIOD1');
		$this->assertEquals($period, $periods[0]);

		$monday = Date::Parse("2013-01-07", $timezone);
		$periods = $layout->GetLayout($monday);
		$this->assertEquals(1, count($periods));

		$tuesday = Date::Parse("2013-01-08", $timezone);
		$periods = $layout->GetLayout($tuesday);
		$this->assertEquals(1, count($periods));
	}

	public function testLoadsPeakTimesWithLayout()
	{
		$timezone = 'America/New_York';
		$scheduleId = 109;

		$layoutFactory = $this->getMock('ILayoutFactory');
		$expectedLayout = new ScheduleLayout($timezone);

		$layoutFactory->expects($this->once())
					  ->method('CreateLayout')
					  ->will($this->returnValue($expectedLayout));

		$layoutRows = array(
						ColumnNames::BLOCK_START => '02:00:00',
						ColumnNames::BLOCK_END => '03:00:00',
						ColumnNames::BLOCK_LABEL => 'PERIOD1',
						ColumnNames::BLOCK_CODE => PeriodTypes::RESERVABLE,
						ColumnNames::BLOCK_TIMEZONE => $timezone,
						ColumnNames::BLOCK_DAY_OF_WEEK => DayOfWeek::SUNDAY,
				);
		$peakTimeRows = array(ColumnNames::PEAK_ALL_DAY => 0,
				ColumnNames::PEAK_START_TIME => '08:30 am',
				ColumnNames::PEAK_END_TIME => '05:45 pm',
				ColumnNames::PEAK_EVERY_DAY => 0,
				ColumnNames::PEAK_DAYS => '1,3,5',
				ColumnNames::PEAK_ALL_YEAR => 0,
				ColumnNames::PEAK_BEGIN_MONTH => 2,
				ColumnNames::PEAK_BEGIN_DAY => 22,
				ColumnNames::PEAK_END_MONTH => 4,
				ColumnNames::PEAK_END_DAY => 10,
		);
		$this->db->SetRow(0, array($layoutRows));
		$this->db->SetRow(1, array($peakTimeRows));

		$layout = $this->scheduleRepository->GetLayout($scheduleId, $layoutFactory);

		$peakTimes = $layout->GetPeakTimes();
		
		$this->assertEquals(false, $peakTimes->IsAllDay());
		$this->assertEquals(Time::Parse("08:30 am", $timezone), $peakTimes->GetBeginTime());
		$this->assertEquals(Time::Parse("05:45 pm", $timezone), $peakTimes->GetEndTime());
		$this->assertEquals(false, $peakTimes->IsAllDay());
		$this->assertEquals(array(1,3,5), $peakTimes->GetWeekdays());
		$this->assertEquals(false, $peakTimes->IsAllYear());
		$this->assertEquals(2, $peakTimes->GetBeginMonth());
		$this->assertEquals(22, $peakTimes->GetBeginDay());
		$this->assertEquals(4, $peakTimes->GetEndMonth());
		$this->assertEquals(10, $peakTimes->GetEndDay());
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
		$allowSubscription = 1;
		$publicId = '123';

		$fakeSchedules = new FakeScheduleRepository();
		$expectedSchedule = new Schedule($id,
										 $name,
										 $isDefault,
										 $weekdayStart,
										 $daysVisible,
										 $timezone,
										 $layoutId);
		$expectedSchedule->WithSubscription($allowSubscription);
		$expectedSchedule->WithPublicId($publicId);

		$this->db->SetRows(array($fakeSchedules->GetRow($id, $name, $isDefault, $weekdayStart, $daysVisible, $timezone,
														$layoutId, $allowSubscription, $publicId)));
		$actualSchedule = $this->scheduleRepository->LoadById($id);

		$this->assertEquals($expectedSchedule, $actualSchedule);
		$this->assertEquals(new GetScheduleByIdCommand($id), $this->db->_LastCommand);
	}

	public function testCanGetScheduleByPublicId()
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
		$subscriptionEnabled = true;
		$adminGroupId = 123;
        $begin = Date::Now();
        $end = Date::Now()->AddDays(1);

		$schedule = new Schedule($id,
								 $name,
								 $isDefault,
								 $weekdayStart,
								 $daysVisible);

		$schedule->EnableSubscription();
		$publicId = $schedule->GetPublicId();
		$schedule->SetAdminGroupId($adminGroupId);
		$schedule->SetAvailability($begin, $end);

		$this->scheduleRepository->Update($schedule);

		$this->assertEquals(new UpdateScheduleCommand($id, $name, $isDefault, $weekdayStart, $daysVisible, $subscriptionEnabled, $publicId, $adminGroupId, $begin, $end),
							$this->db->_LastCommand);
	}

	public function testCanChangeLayout()
	{
		$scheduleId = 89;
		$layoutId = 90;
		$timezone = 'America/New_York';

		$start1 = new Time(0, 0);
		$end1 = new Time(12, 0);
		$label1 = 'label 1';

		$start2 = new Time(12, 0);
		$end2 = new Time(0, 0);

		$slots = array(
				new LayoutPeriod($start1, $end1, PeriodTypes::RESERVABLE, $label1),
				new LayoutPeriod($start2, $end2, PeriodTypes::NONRESERVABLE),
		);

		$layout = $this->getMock('ILayoutCreation');

		$layout->expects($this->once())
			   ->method('UsesDailyLayouts')
			   ->will($this->returnValue(false));

		$layout->expects($this->once())
			   ->method('Timezone')
			   ->will($this->returnValue($timezone));

		$layout->expects($this->once())
			   ->method('GetSlots')
			   ->with($this->isNull())
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
		$expectedUpdateScheduleLayout = new UpdateScheduleLayoutCommand($scheduleId, $layoutId);

		$this->assertEquals($expectedInsertBlockGroup, $actualInsertBlockGroup);
		$this->assertEquals($expectedInsertBlockGroup1, $actualInsertBlock1);
		$this->assertEquals($expectedInsertBlockGroup2, $actualInsertBlock2);
		$this->assertEquals($actualInsertScheduleBlock, $actualInsertScheduleBlock);
		$this->assertTrue($this->db->ContainsCommand($expectedUpdateScheduleLayout));
		$this->assertTrue($this->db->ContainsCommand(new DeleteOrphanLayoutsCommand()));
	}

	public function testCanChangeLayoutWithDailySlots()
	{
		$scheduleId = 89;
		$layoutId = 90;
		$timezone = 'America/New_York';

		$start1 = new Time(0, 0);
		$end1 = new Time(12, 0);
		$label1 = 'label 1';

		$start2 = new Time(12, 0);
		$end2 = new Time(0, 0);

		$slots = array(
				new LayoutPeriod($start1, $end1, PeriodTypes::RESERVABLE, $label1),
				new LayoutPeriod($start2, $end2, PeriodTypes::NONRESERVABLE),
		);

		$layout = $this->getMock('ILayoutCreation');

		$layout->expects($this->once())
			   ->method('UsesDailyLayouts')
			   ->will($this->returnValue(true));

		$layout->expects($this->once())
			   ->method('Timezone')
			   ->will($this->returnValue($timezone));

		foreach (DayOfWeek::Days() as $day)
		{
			$layout->expects($this->at($day + 2))
				   ->method('GetSlots')
				   ->with($this->equalTo($day))
				   ->will($this->returnValue($slots));
		}

		$this->db->_ExpectedInsertId = $layoutId;

		$this->scheduleRepository->AddScheduleLayout($scheduleId, $layout);

		$expectedInsertBlockGroup = new AddLayoutCommand($timezone);
		$expectedUpdateScheduleLayout = new UpdateScheduleLayoutCommand($scheduleId, $layoutId);

		$this->assertTrue($this->db->ContainsCommand($expectedInsertBlockGroup));
		foreach (DayOfWeek::Days() as $day)
		{
			$this->assertTrue($this->db->ContainsCommand(new AddLayoutTimeCommand($layoutId, $start1, $end1, PeriodTypes::RESERVABLE, $label1, $day)));
			$this->assertTrue($this->db->ContainsCommand(new AddLayoutTimeCommand($layoutId, $start2, $end2, PeriodTypes::NONRESERVABLE, null, $day)));
		}
		$this->assertTrue($this->db->ContainsCommand($expectedUpdateScheduleLayout));
		$this->assertTrue($this->db->ContainsCommand(new DeleteOrphanLayoutsCommand()));
	}

	public function testCanAddNewSchedule()
	{
		$layoutId = 87;
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
		$this->assertTrue($this->db->ContainsCommand($expectedGetScheduleById));
		$this->assertTrue($this->db->ContainsCommand($expectedInsertScheduleCommand));
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