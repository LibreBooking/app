<?php
/**
Copyright 2011-2013 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Authorization/namespace.php');
require_once(ROOT_DIR . 'lib/Server/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/SchedulePageBuilder.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');

interface ISchedulePresenter {

    public function PageLoad(UserSession $user);
}

class SchedulePresenter extends ActionPresenter implements ISchedulePresenter {

    /**
     * @var ISchedulePage
     */
    private $_page;

    /**
     * @var IScheduleRepository
     */
    private $_scheduleRepository;

    /**
     * @var IResourceService
     */
    private $_resourceService;

    /**
     * @var ISchedulePageBuilder
     */
    private $_builder;

    /**
     * @var IReservationService
     */
    private $_reservationService;

    /**
     * @param ISchedulePage $page
     * @param IScheduleRepository $scheduleRepository
     * @param IResourceService $resourceService
     * @param ISchedulePageBuilder $schedulePageBuilder
     * @param IReservationService $reservationService
     * @param IDailyLayoutFactory $dailyLayoutFactory
     */
    public function __construct(
        ISchedulePage $page,
        IScheduleRepository $scheduleRepository,
        IResourceService $resourceService,
        ISchedulePageBuilder $schedulePageBuilder,
        IReservationService $reservationService,
        IDailyLayoutFactory $dailyLayoutFactory
    )
    {
		parent::__construct($page);
        $this->_page = $page;
        $this->_scheduleRepository = $scheduleRepository;
        $this->_resourceService = $resourceService;
        $this->_builder = $schedulePageBuilder;
        $this->_reservationService = $reservationService;
        $this->_dailyLayoutFactory = $dailyLayoutFactory;
    }

    public function PageLoad(UserSession $user)
    {
        $targetTimezone = $user->Timezone;

        $showInaccessibleResources = $this->_page->ShowInaccessibleResources();

        $schedules = $this->_scheduleRepository->GetAll();
        $currentSchedule = $this->_builder->GetCurrentSchedule($this->_page, $schedules, $user);
        $activeScheduleId = $currentSchedule->GetId();
        $this->_builder->BindSchedules($this->_page, $schedules, $currentSchedule);

        $scheduleDates = $this->_builder->GetScheduleDates($user, $currentSchedule, $this->_page);
        $this->_builder->BindDisplayDates($this->_page, $scheduleDates, $user, $currentSchedule);

        $layout = $this->_scheduleRepository->GetLayout($activeScheduleId, new ScheduleLayoutFactory($targetTimezone));

        $reservationListing = $this->_reservationService->GetReservations($scheduleDates, $activeScheduleId, $targetTimezone);
        $dailyLayout = $this->_dailyLayoutFactory->Create($reservationListing, $layout);
        $resources = $this->_resourceService->GetScheduleResources($activeScheduleId, $showInaccessibleResources, $user);

        $this->_builder->BindReservations($this->_page, $resources, $dailyLayout);
    }

	public function GetLayout(UserSession $user)
	{
		$scheduleId = $this->_page->GetScheduleId();
		$layoutDate = $this->_page->GetLayoutDate();

		$requestedDate = Date::Parse($layoutDate, $user->Timezone);

		$layout = $this->_scheduleRepository->GetLayout($scheduleId, new ScheduleLayoutFactory($user->Timezone));
		$periods = $layout->GetLayout($requestedDate);

		Log::Debug('Getting layout for scheduleId=%s, layoutDate=%s, periods=%s', $scheduleId, $layoutDate,var_export($periods, true));
		$this->_page->SetLayoutResponse(new ScheduleLayoutSerializable($periods));
	}
}

?>