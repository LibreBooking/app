<?php
/**
Copyright 2011-2014 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'Pages/SchedulePage.php');
require_once(ROOT_DIR . 'Presenters/SchedulePresenter.php');
require_once(ROOT_DIR . 'lib/Application/Authorization/ViewSchedulePermissionServiceFactory.php');

class ViewSchedulePage extends SchedulePage
{
	public function __construct()
	{
		parent::__construct();
		$scheduleRepository = new ScheduleRepository();
		$userRepository = new UserRepository();
		$resourceService = new ResourceService(new ResourceRepository(), new ViewSchedulePermissionService(), new AttributeService(new AttributeRepository()), $userRepository);
		$pageBuilder = new SchedulePageBuilder();
		$reservationService = new ReservationService(new ReservationViewRepository(), new ReservationListingFactory());
		$dailyLayoutFactory = new DailyLayoutFactory();

		$this->_presenter = new SchedulePresenter(
			$this,
			new ScheduleService($scheduleRepository, $resourceService),
			$resourceService,
			$pageBuilder,
			$reservationService,
			$dailyLayoutFactory);
	}

	public function ProcessPageLoad()
	{
		$user = new NullUserSession();
		$this->_presenter->PageLoad($user);
		$viewReservations = Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_VIEW_RESERVATIONS, new BooleanConverter());
		$this->Set('DisplaySlotFactory', new DisplaySlotFactory());
		$this->Set('SlotLabelFactory', $viewReservations ? new SlotLabelFactory($user) : new NullSlotLabelFactory());
		$this->Display('Schedule/view-schedule.tpl');
	}

    public function ShowInaccessibleResources()
    {
        return true;
    }

	protected function GetShouldAutoLogout()
	{
		return false;
	}

	public function GetDisplayTimezone(UserSession $user, Schedule $schedule)
	{
		return $schedule->GetTimezone();
	}
}