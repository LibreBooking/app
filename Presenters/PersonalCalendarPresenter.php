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

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');

class PersonalCalendarActions
{
    const ActionEnableSubscription = 'enable';
    const ActionDisableSubscription = 'disable';
}

class PersonalCalendarPresenter extends ActionPresenter
{
	/**
	 * @var \IPersonalCalendarPage
	 */
	private $page;

	/**
	 * @var \IReservationViewRepository
	 */
	private $repository;

	/**
	 * @var \ICalendarFactory
	 */
	private $calendarFactory;

    /**
     * @var ICalendarSubscriptionService
     */
    private $subscriptionService;

    /**
     * @var IUserRepository
     */
    private $userRepository;

	public function __construct(
        IPersonalCalendarPage $page,
        IReservationViewRepository $repository,
        ICalendarFactory $calendarFactory,
        ICalendarSubscriptionService $subscriptionService,
        IUserRepository $userRepository)
	{
        parent::__construct($page);

		$this->page = $page;
		$this->repository = $repository;
		$this->calendarFactory = $calendarFactory;
		$this->subscriptionService = $subscriptionService;
		$this->userRepository = $userRepository;

        $this->AddAction(PersonalCalendarActions::ActionEnableSubscription, 'EnableSubscription');
        $this->AddAction(PersonalCalendarActions::ActionDisableSubscription, 'DisableSubscription');
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

		$calendar = $this->calendarFactory->Create($type, $year, $month, $day, $timezone);
		$reservations = $this->repository->GetReservationList($calendar->FirstDay(), $calendar->LastDay(), $userId, ReservationUserLevel::ALL);
		$calendar->AddReservations(CalendarReservation::FromViewList($reservations, $timezone));
		$this->page->BindCalendar($calendar);

		$this->page->SetDisplayDate($calendar->FirstDay());

        $details = $this->subscriptionService->ForUser($userId);
        $this->page->BindSubscription($details);
	}

    public function EnableSubscription()
    {
        $userId = ServiceLocator::GetServer()->GetUserSession()->UserId;
        Log::Debug('Enabling calendar subscription for userId: %s', $userId);

        $user = $this->userRepository->LoadById($userId);
        $user->EnableSubscription();
        $this->userRepository->Update($user);
    }

    public function DisableSubscription()
    {
        $userId = ServiceLocator::GetServer()->GetUserSession()->UserId;
        Log::Debug('Disabling calendar subscription for userId: %s', $userId);

        $user = $this->userRepository->LoadById($userId);
        $user->DisableSubscription();
        $this->userRepository->Update($user);
    }
}
?>