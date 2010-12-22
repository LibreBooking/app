<?php

require_once(ROOT_DIR . 'Domain/ScheduleLayout.php');

interface IScheduleRepository
{
	/**
	 * Gets all schedules
	 * @return array list of Schedule objects
	 */
	public function GetAll();

	/**
	 * @param int $scheduleId
	 * @param ILayoutFactory $layoutFactory factory to use to create the schedule layout
	 * @return IScheduleLayout
	 */
	public function GetLayout($scheduleId, ILayoutFactory $layoutFactory);
}

interface ILayoutFactory 
{
	/**
	 * @return IScheduleLayout
	 */
	public function CreateLayout();
}

class ScheduleLayoutFactory implements ILayoutFactory
{
	private $_targetTimezone;
	
	/**
	 * @param string $targetTimezone target timezone of layout
	 */
	public function __construct($targetTimezone)
	{
		$this->_targetTimezone = $targetTimezone;
	}
	
	/**
	 * @see ILayoutFactory::CreateLayout()
	 */
	public function CreateLayout()
	{
		return new ScheduleLayout($this->_targetTimezone);
	}
}

class ReservationLayoutFactory implements ILayoutFactory
{
	private $_targetTimezone;
	
	/**
	 * @param string $targetTimezone target timezone of layout
	 */
	public function __construct($targetTimezone)
	{
		$this->_targetTimezone = $targetTimezone;
	}
	
	/**
	 * @see ILayoutFactory::CreateLayout()
	 */
	public function CreateLayout()
	{
		return new ReservationLayout($this->_targetTimezone);
	}
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
	public function GetLayout($scheduleId, ILayoutFactory $layoutFactory)
	{
		$layout = $layoutFactory->CreateLayout();

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