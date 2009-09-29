<?php

interface IScheduleRepository
{
	/**
	 * Gets all schedules
	 * @return array list of Schedule objects
	 */
	public function GetAll();
	
	/**
	 * @param int $scheduleId
	 * @param string $timezone
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
							$row[ColumnNames::SCHEDULE_START],
							$row[ColumnNames::SCHEDULE_END],
							$row[ColumnNames::SCHEDULE_WEEKDAY_START],
							$row[ColumnNames::SCHEDULE_ADMIN_ID],
							$row[ColumnNames::SCHEDULE_DAYS_VISIBLE]
						);
		}
		
		$reader->Free();
		
		return $schedules;
	}
	
	public function GetLayout($scheduleId, $timezone)
	{
		throw new Exception("not implemented");
	}
}

?>