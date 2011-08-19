<?php
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class CalendarPresenter
{
	/**
	 * @var \ICalendarPage
	 */
	private $page;

	/**
	 * @var \ICalendarFactory
	 */
	private $calendarFactory;

	/**
	 * @var \IReservationRepository
	 */
	private $reservationRepository;

	/**
	 * @var \IScheduleRepository
	 */
	private $scheduleRepository;

	/**
	 * @var \IResourceRepository
	 */
	private $resourceRepository;

	public function __construct(ICalendarPage $page,
		ICalendarFactory $calendarFactory,
		IReservationRepository $reservationRepository,
		IScheduleRepository $scheduleRepository,
		IResourceRepository $resourceRepository)
	{
		$this->page = $page;
		$this->calendarFactory = $calendarFactory;
		$this->reservationRepository = $reservationRepository;
		$this->scheduleRepository = $scheduleRepository;
		$this->resourceRepository = $resourceRepository;
	}
	
	public function PageLoad($userId, $timezone)
	{
		$type = $this->page->GetCalendarType();

		$year = $this->page->GetYear();
		$month = $this->page->GetMonth();
		$day = $this->page->GetDay();

		$defaultDate = Date::Now()->ToTimezone($timezone);

		if (empty($year))
		{
			$year = $defaultDate->Year();
		}
		if (empty($month))
		{
			$month = $defaultDate->Month();
		}
		if (empty($day))
		{
			$day = $defaultDate->Day();
		}

		$schedules = $this->scheduleRepository->GetAll();
		$resources = $this->resourceRepository->GetResourceList();
		
		$selectedScheduleId = $this->GetScheduleId($schedules);
		$selectedResourceId = $this->page->GetResourceId();

		$calendar = $this->calendarFactory->Create($type, $year, $month, $day, $timezone);
		$reservations = $this->reservationRepository->GetWithin($calendar->FirstDay(), $calendar->LastDay(), $selectedScheduleId);
		$calendar->AddReservations($reservations);
		$this->page->BindCalendar($calendar);

		$this->page->BindFilters(new CalendarFilters($schedules, $resources, $selectedScheduleId, $selectedResourceId));
		
		$this->page->SetDisplayDate($calendar->FirstDay());
	}

	/**
	 * @param array|Schedule[] $schedules
	 * @return void
	 */
	private function GetScheduleId($schedules)
	{
		$scheduleId = $this->page->GetScheduleId();
		if (!is_null($scheduleId))
		{
			return $scheduleId;
		}

		/** @var $schedule Schedule */
		foreach ($schedules as $schedule)
		{
			if ($schedule->GetIsDefault())
			{
				return $schedule->GetId();
			}
		}
	}
}

class CalendarFilters
{
	/**
	 * @var array|ScheduleFilter[]
	 */
	private $filters = array();
	
	/**
	 * @param array|Schedule[] $schedules
	 * @param array|BookableResource[] $resources
	 * @param int $selectedScheduleId
	 * @param int $selectedResourceId
	 */
	public function __construct($schedules, $resources, $selectedScheduleId, $selectedResourceId)
	{
		foreach ($schedules as $schedule)
		{
			$filter = new CalendarFilter('schedule', $schedule->GetId(), $schedule->GetName(), ($selectedScheduleId == $schedule->GetId()));

			foreach ($resources as $resource)
			{
				if ($resource->GetScheduleId() == $schedule->GetId())
				{
					$filter->AddSubFilter(new CalendarFilter('resource', $resource->GetResourceId(), $resource->GetName(), ($selectedResourceId == $resource->GetResourceId())));
				}
			}

			$this->filters[] = $filter;
		}
	}

	/**
	 * @return array|ScheduleFilter[]
	 */
	public function GetFilters()
	{
		return $this->filters;
	}
}

class CalendarFilter
{
	/**
	 * @var array|ScheduleFilter[]
	 */
	private $filters = array();

	/**
	 * @var string
	 */
	private $type;

	/**
	 * @var string
	 */
	private $id;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var bool
	 */
	private $selected;

	public function __construct($type, $id, $name, $selected)
	{
		$this->type = $type;
		$this->id = $id;
		$this->name = $name;
		$this->selected = $selected;
	}

	public function AddSubFilter(CalendarFilter $subfilter)
	{
		$this->filters[] = $subfilter;
	}

	/**
	 * @return array|ScheduleFilter[]
	 */
	public function GetFilters()
	{
		return $this->filters;
	}
		
}
?>