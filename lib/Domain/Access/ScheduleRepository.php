<?php

require_once(ROOT_DIR . 'lib/Domain/ScheduleLayout.php');

interface IScheduleRepository
{
	/**
	 * Gets all schedules
	 * @return array list of Schedule objects
	 */
	public function GetAll();

	/**
	 * @param int $scheduleId
	 * @param string $timezone target timezone of layout
	 * @return IScheduleLayout
	 */
	public function GetLayout($scheduleId, $timezone);
}

class ScheduleRepository implements IScheduleRepository
{
	public function GetAll()
	{
		$schedules = array();

		$reader = ServiceLocator::GetDatabase()->Query(new GetAllSchedulesCommand());

		while ($row = $reader->GetRow())
		{
			$schedules[] = new Schedule(
			$row[ColumnNames::SCHEDULE_ID],
			$row[ColumnNames::SCHEDULE_NAME],
			$row[ColumnNames::SCHEDULE_DEFAULT],
			$row[ColumnNames::SCHEDULE_WEEKDAY_START],
			$row[ColumnNames::SCHEDULE_DAYS_VISIBLE]
			);
		}

		$reader->Free();

		return $schedules;
	}

	/**
	 * @see IScheduleRepository::GetLayout()
	 */
	public function GetLayout($scheduleId, $timezone)
	{
		$layout = new ScheduleLayout($timezone);

		$reader = ServiceLocator::GetDatabase()->Query(new GetLayoutCommand($scheduleId));

		while ($row = $reader->GetRow())
		{
			$start = Time::Parse($row[ColumnNames::BLOCK_START], 'UTC');
			$end = Time::Parse($row[ColumnNames::BLOCK_END], 'UTC');
			$label = $row[ColumnNames::BLOCK_LABEL];
			$periodType = $row[ColumnNames::BLOCK_CODE];
				
			if ($periodType == PeroidTypes::RESERVABLE)
			{
				$layout->AppendPeriod($start, $end, $label);
			}
			else
			{
				$layout->AppendBlockedPeriod($start, $end, $label);
			}
		}

		$reader->Free();

		return $layout;
	}
}

?>