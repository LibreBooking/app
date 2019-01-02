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

require_once(ROOT_DIR . 'Pages/CalendarPage.php');
require_once(ROOT_DIR . 'Presenters/Calendar/CalendarPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Authorization/GuestPermissionServiceFactory.php');

class ViewCalendarPage extends CalendarPage
{
    public function __construct()
    {
        parent::__construct();

        $resourceRepository = new ResourceRepository();
        $scheduleRepository = new ScheduleRepository();
        $userRepository = new UserRepository();
        $resourceService = new ResourceService(
            $resourceRepository,
            new GuestPermissionService(),
            new AttributeService(new AttributeRepository()),
            $userRepository,
            new AccessoryRepository());
        $subscriptionService = new CalendarSubscriptionService($userRepository, $resourceRepository, $scheduleRepository);
        $privacyFilter = new PrivacyFilter(new ReservationAuthorization(PluginManager::Instance()->LoadAuthorization()));

        $viewReservations = Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_VIEW_RESERVATIONS, new BooleanConverter());
        $allowGuestBookings = Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_ALLOW_GUEST_BOOKING, new BooleanConverter());
        $factory = ($viewReservations || $allowGuestBookings) ? new SlotLabelFactory() : new NullSlotLabelFactory();

        $this->presenter = new CalendarPresenter($this,
            new CalendarFactory(),
            new ReservationViewRepository(),
            $scheduleRepository,
            new UserRepository(),
            $resourceService,
            $subscriptionService,
            $privacyFilter,
            $factory);
    }

    public function DisplayPage()
    {
        $this->Set('pageUrl', Pages::VIEW_CALENDAR);
        $this->Set('CreateReservationPage', Pages::GUEST_RESERVATION);
        $this->Set('HideCreate', !Configuration::Instance()->GetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_ALLOW_GUEST_BOOKING, new BooleanConverter()));
        parent::DisplayPage();
    }

    public function RenderSubscriptionDetails()
    {
    }
}