<?php

/**
 * Copyright 2017 Nick Korbel
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

require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'Pages/SearchAvailabilityPage.php');

class SearchAvailabilityPresenter extends ActionPresenter
{
	/**
	 * @var ISearchAvailabilityPage
	 */
	private $page;
	/**
	 * @var IResourceService
	 */
	private $resourceService;
	/**
	 * @var IReservationService
	 */
	private $reservationService;

	/**
	 * @var UserSession
	 */
	private $user;
	/**
	 * @var IScheduleService
	 */
	private $scheduleService;

	public function __construct(ISearchAvailabilityPage $page,
								UserSession $user,
								IResourceService $resourceService,
								IReservationService $reservationService,
								IScheduleService $scheduleService)
	{
		parent::__construct($page);

		$this->page = $page;
		$this->user = $user;
		$this->resourceService = $resourceService;
		$this->reservationService = $reservationService;
		$this->scheduleService = $scheduleService;

		$this->AddAction('search', 'SearchAvailability');
	}

	public function PageLoad()
	{
		$this->page->SetResources($this->resourceService->GetAllResources(false, $this->user));
		$this->page->SetResourceTypes($this->resourceService->GetResourceTypes());
		$this->page->SetResourceAttributes($this->resourceService->GetResourceAttributes());
		$this->page->SetResourceTypeAttributes($this->resourceService->GetResourceTypeAttributes());
	}

	public function SearchAvailability()
	{
		$openings = array();
		$dateRange = $this->GetSearchRange();
		$requestedLength = $this->GetRequestedLength();
		$resources = $this->resourceService->GetAllResources(false, $this->user, $this->GetFilter());

		/** @var ResourceDto $resource */
		foreach ($resources as $resource)
		{
			$scheduleId = $resource->GetScheduleId();
			$resourceId = $resource->GetResourceId();

			$targetTimezone = $this->user->Timezone;
			$reservations = $this->reservationService->GetReservations($dateRange, $scheduleId, $targetTimezone, $resourceId);
			$layout = $this->scheduleService->GetDailyLayout($scheduleId, new ScheduleLayoutFactory($targetTimezone), $reservations);

			foreach ($dateRange->Dates() as $date)
			{
				$slots = $layout->GetLayout($date, $resourceId);

				/** @var IReservationSlot $slot */
				for ($i = 0; $i < count($slots); $i++)
				{
					$opening = $this->GetSlot($i, $i, $slots, $requestedLength, $resource);

					if ($opening != null)
					{
						$openings[] = $opening;
					}
				}
			}
		}

		Log::Debug('Searching for available openings found %s times', count($openings));

		$this->page->ShowOpenings($openings);
	}

	/**
	 * @param int $startIndex
	 * @param int $currentIndex
	 * @param IReservationSlot[] $slots
	 * @param DateDiff $requestedLength
	 * @param ResourceDto $resource
	 * @return AvailableOpeningView|null
	 */
	private function GetSlot($startIndex, $currentIndex, $slots, $requestedLength, $resource)
	{
		if ($currentIndex > count($slots))
		{
			return null;
		}

		$startSlot = $slots[$startIndex];
		$currentSlot = $slots[$currentIndex];

		if ($currentSlot == null || !$currentSlot->IsReservable() || $currentSlot->BeginDate()->LessThan(Date::Now()))
		{
			return null;
		}

		$length = DateDiff::BetweenDates($startSlot->BeginDate(), $currentSlot->EndDate());
		if ($length->GreaterThanOrEqual($requestedLength))
		{
			return new AvailableOpeningView($resource, $startSlot->BeginDate(), $currentSlot->EndDate());

		}

		return $this->GetSlot($startIndex, $currentIndex + 1, $slots, $requestedLength, $resource);
	}

	/**
	 * @return DateRange
	 */
	private function GetSearchRange()
	{
		$range = $this->page->GetRequestedRange();
		$timezone = $this->user->Timezone;

		$today = Date::Now()->ToTimezone($timezone);

		if ($range == 'tomorrow')
		{
			return new DateRange($today->AddDays(1)->GetDate(), $today->AddDays(2)->GetDate());
		}

		if ($range == 'thisweek')
		{
			$weekday = $today->Weekday();
			$adjustedDays = (0 - $weekday);

			if ($weekday < 0)
			{
				$adjustedDays = $adjustedDays - 7;
			}

			$startDate = $today->AddDays($adjustedDays)->GetDate();

			return new DateRange($startDate, $startDate->AddDays(6));
		}

		if ($range == 'daterange')
		{
			$start = $this->page->GetRequestedStartDate();
			$end = $this->page->GetRequestedEndDate();

			if (empty($start))
			{
				$start = Date::Now()->ToTimezone($timezone);
			}
			if (empty($end))
			{
				$end = Date::Now()->ToTimezone($timezone)->AddDays(1);
			}
			return new DateRange(Date::Parse($start, $timezone), Date::Parse($end, $timezone));
		}

		return new DateRange($today->GetDate(), $today->AddDays(1)->GetDate());
	}

	/**
	 * @return DateDiff
	 */
	private function GetRequestedLength()
	{
		$hourSeconds = 3600 * $this->page->GetRequestedHours();
		$minuteSeconds = 60 * $this->page->GetRequestedMinutes();
		return new DateDiff($hourSeconds + $minuteSeconds);
	}

	/**
	 * @return ScheduleResourceFilter
	 */
	private function GetFilter()
	{
		return new ScheduleResourceFilter(null,
										  $this->page->GetResourceType(),
										  $this->page->GetMaxParticipants(),
										  $this->AsAttributeValues($this->page->GetResourceAttributeValues()),
										  $this->AsAttributeValues($this->page->GetResourceTypeAttributeValues()),
										  $this->page->GetResources());
	}

	/**
	 * @param $attributeFormElements AttributeFormElement[]
	 * @return AttributeValue[]
	 */
	private function AsAttributeValues($attributeFormElements)
	{
		$vals = array();
		foreach ($attributeFormElements as $e)
		{
			if (!empty($e->Value) || (is_numeric($e->Value) && $e->Value == 0))
			{
				$vals[] = new AttributeValue($e->Id, $e->Value);
			}
		}
		return $vals;
	}
}

class AvailableOpeningView
{
	/**
	 * @var ResourceDto
	 */
	private $resource;
	/**
	 * @var Date
	 */
	private $start;
	/**
	 * @var Date
	 */
	private $end;

	public function __construct(ResourceDto $resource, Date $start, Date $end)
	{
		$this->resource = $resource;
		$this->start = $start;
		$this->end = $end;
	}

	/**
	 * @return ResourceDto
	 */
	public function Resource()
	{
		return $this->resource;
	}

	/**
	 * @return Date
	 */
	public function Start()
	{
		return $this->start;
	}

	/**
	 * @return Date
	 */
	public function End()
	{
		return $this->end;
	}

	/**
	 * @return bool
	 */
	public function SameDate()
	{
		return $this->Start()->DateEquals($this->End());
	}
}