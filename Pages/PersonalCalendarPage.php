<?php
/**
 * Copyright 2011-2019 Nick Korbel
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

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/Calendar/PersonalCalendarPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/CalendarSubscriptionService.php');

class PersonalCalendarPage extends CommonCalendarPage implements ICommonCalendarPage
{
	/**
	 * @var PersonalCalendarPresenter
	 */
	private $presenter;

	public function __construct()
	{
		parent::__construct('MyCalendar', 0);

		$userRepository = new UserRepository();
		$subscriptionService = new CalendarSubscriptionService($userRepository, new ResourceRepository(), new ScheduleRepository());
		$resourceRepository = new ResourceRepository();
		$resourceService = new ResourceService($resourceRepository,
											   PluginManager::Instance()->LoadPermission(),
											   new AttributeService(new AttributeRepository()),
											   $userRepository,
											   new AccessoryRepository());

		$this->presenter = new PersonalCalendarPresenter(
				$this,
				new ReservationViewRepository(),
				new CalendarFactory(),
				$subscriptionService,
				$userRepository,
				$resourceService,
				new ScheduleRepository());
	}

	public function ProcessPageLoad()
	{
		$user = ServiceLocator::GetServer()->GetUserSession();
		$this->presenter->PageLoad($user);

		$this->Set('HeaderLabels', Resources::GetInstance()->GetDays('full'));
		$this->Set('Today', Date::Now()->ToTimezone($user->Timezone));
		$this->Set('TimeFormat', Resources::GetInstance()->GetDateFormat('calendar_time'));
		$this->Set('DateFormat', Resources::GetInstance()->GetDateFormat('calendar_dates'));
        $this->Set('CreateReservationPage', Pages::RESERVATION);

        $this->Display('Calendar/mycalendar.tpl');
	}

    public function RenderSubscriptionDetails()
    {
        $this->Display('Calendar/mycalendar.subscription.tpl');
    }

    public function ProcessAction()
    {
        $this->presenter->ProcessAction();
    }

    public function ProcessDataRequest($dataRequest)
    {
        $this->presenter->ProcessDataRequest($dataRequest);
    }
}

class PersonalCalendarUrl
{
	private $url;

	private function __construct($year, $month, $day, $type)
	{
		$resourceId = ServiceLocator::GetServer()->GetQuerystring(QueryStringKeys::RESOURCE_ID);
		$scheduleId = ServiceLocator::GetServer()->GetQuerystring(QueryStringKeys::SCHEDULE_ID);

		$format = Pages::MY_CALENDAR . '?'
				. QueryStringKeys::DAY . '=%d&'
				. QueryStringKeys::MONTH . '=%d&'
				. QueryStringKeys::YEAR
				. '=%d&'
				. QueryStringKeys::CALENDAR_TYPE . '=%s&'
				. QueryStringKeys::RESOURCE_ID . '=%s&'
				. QueryStringKeys::SCHEDULE_ID . '=%s';

		$this->url = sprintf($format, $day, $month, $year, $type, $resourceId, $scheduleId);
	}

	/**
	 * @static
	 * @param $date Date
	 * @param $type string
	 * @return PersonalCalendarUrl
	 */
	public static function Create($date, $type)
	{
		return new PersonalCalendarUrl($date->Year(), $date->Month(), $date->Day(), $type);
	}

	public function __toString()
	{
		return $this->url;
	}
}