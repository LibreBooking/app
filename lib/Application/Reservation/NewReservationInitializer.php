<?php
/**
 * Copyright 2011-2020 Nick Korbel
 *
 * This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Pages/Reservation/NewReservationPage.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/ReservationInitializerBase.php');

class NewReservationInitializer extends ReservationInitializerBase
{
    /**
     * @var INewReservationPage
     */
    private $page;

    /**
     * @var int
     */
    private $scheduleId;

    /**
     * @var IScheduleRepository
     */
    private $scheduleRepository;

    /**
     * @var IResourceRepository
     */
    private $resourceRepository;

    public function __construct(
        INewReservationPage $page,
        IReservationComponentBinder $userBinder,
        IReservationComponentBinder $dateBinder,
        IReservationComponentBinder $resourceBinder,
        UserSession $userSession,
        IScheduleRepository $scheduleRepository,
        IResourceRepository $resourceRepository,
        ITermsOfServiceRepository $termsOfServiceRepository
    )
    {
        $this->page = $page;
        $this->scheduleRepository = $scheduleRepository;
        $this->resourceRepository = $resourceRepository;

        parent::__construct(
            $page,
            $userBinder,
            $dateBinder,
            $resourceBinder,
            $userSession,
            $termsOfServiceRepository);
    }

    public function Initialize()
    {
        parent::Initialize();

        $this->SetDefaultReminders();
    }

    protected function SetSelectedDates(Date $startDate, Date $endDate, $startPeriods, $endPeriods)
    {
        parent::SetSelectedDates($startDate, $endDate, $startPeriods, $endPeriods);
        $this->basePage->SetRepeatTerminationDate($endDate);
    }

    public function GetOwnerId()
    {
        return ServiceLocator::GetServer()->GetUserSession()->UserId;
    }

    public function GetResourceId()
    {
        return $this->page->GetRequestedResourceId();
    }

    public function GetScheduleId()
    {
        if (!empty($this->scheduleId)) {
            return $this->scheduleId;
        }

        $this->scheduleId = $this->page->GetRequestedScheduleId();

        if (empty($this->scheduleId)) {
            $requestedResourceId = $this->page->GetRequestedResourceId();
            if (!empty($requestedResourceId)) {
                $resource = $this->resourceRepository->LoadById($requestedResourceId);
                $this->scheduleId = $resource->GetScheduleId();
            }
            else {
                $schedules = $this->scheduleRepository->GetAll();

                foreach ($schedules as $s) {
                    if ($s->GetIsDefault()) {
                        $this->scheduleId = $s->GetId();
                        break;
                    }
                }
            }
        }

        return $this->scheduleId;
    }

    public function GetReservationDate()
    {
        return $this->page->GetReservationDate();
    }

    public function GetStartDate()
    {
        return $this->page->GetStartDate();
    }

    public function GetEndDate()
    {
        return $this->page->GetEndDate();
    }

    public function GetTimezone()
    {
        return ServiceLocator::GetServer()->GetUserSession()->Timezone;
    }

    public function IsNew()
    {
        return true;
    }

    private function SetDefaultReminders()
    {
        $start = $this->GetReminderPieces(Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_START_REMINDER));
        $end = $this->GetReminderPieces(Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_END_REMINDER));

        if ($start != null) {
            $this->page->SetStartReminder($start['value'], $start['interval']);
        }

        if ($start != null) {
            $this->page->SetEndReminder($end['value'], $end['interval']);
        }

    }

    private function GetReminderPieces($reminder)
    {
        if (!empty($reminder)) {
            $parts = explode(' ', strtolower($reminder));

            if (count($parts) == 2) {
                $interval = trim($parts[1]);
                $pieces['value'] = intval($parts[0]);
                $pieces['interval'] = ($interval == 'minutes' || $interval == 'hours' || $interval == 'days') ? $interval : 'minutes';
                return $pieces;
            }
        }

        return null;
    }
}

class BindableResourceData
{
    /**
     * @var ResourceDto
     */
    public $ReservationResource;

    /**
     * @var array|ResourceDto[]
     */
    public $AvailableResources;

    /**
     * @var int
     */
    public $NumberAccessible = 0;

    public function __construct()
    {
        $this->ReservationResource = new NullResourceDto();
        $this->AvailableResources = array();
    }

    /**
     * @param $resource ResourceDto
     * @return void
     */
    public function SetReservationResource($resource)
    {
        $this->ReservationResource = $resource;
    }

    /**
     * @param $resource ResourceDto
     * @return void
     */
    public function AddAvailableResource($resource)
    {
        $this->NumberAccessible++;
        $this->AvailableResources[] = $resource;
    }
}