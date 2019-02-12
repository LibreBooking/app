<?php
/**
Copyright 2011-2019 Nick Korbel

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

require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class NotificationPreferencesPresenter
{
	/**
	 * @var INotificationPreferencesPage
	 */
	private $page;

	/**
	 * @var UserRepository
	 */
	private $userRepository;

	public function __construct(INotificationPreferencesPage $page, IUserRepository $userRepository)
	{
		$this->page = $page;
		$this->userRepository = $userRepository;
	}

	public function PageLoad()
	{
        $this->page->SetEmailEnabled(Configuration::Instance()->GetKey(ConfigKeys::ENABLE_EMAIL, new BooleanConverter()));
        $this->page->SetParticipationEnabled(!Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_PREVENT_PARTICIPATION, new BooleanConverter()));

        $userSession = ServiceLocator::GetServer()->GetUserSession();
        $user = $this->userRepository->LoadById($userSession->UserId);

        if ($this->page->IsPostBack())
		{
			$this->UpdateProfile($user);
			$this->page->SetPreferencesSaved(true);
		}

        $this->page->SetApproved($user->WantsEventEmail(new ReservationApprovedEvent()));
        $this->page->SetCreated($user->WantsEventEmail(new ReservationCreatedEvent()));
        $this->page->SetUpdated($user->WantsEventEmail(new ReservationUpdatedEvent()));
        $this->page->SetDeleted($user->WantsEventEmail(new ReservationDeletedEvent()));
        $this->page->SetSeriesEnding($user->WantsEventEmail(new ReservationSeriesEndingEvent()));
        $this->page->SetParticipantChanged($user->WantsEventEmail(new ParticipationChangedEvent()));
	}

	private function UpdateProfile(User $user)
	{
        $user->ChangeEmailPreference(new ReservationApprovedEvent(), $this->page->GetApproved());
        $user->ChangeEmailPreference(new ReservationCreatedEvent(), $this->page->GetCreated());
        $user->ChangeEmailPreference(new ReservationUpdatedEvent(), $this->page->GetUpdated());
        $user->ChangeEmailPreference(new ReservationDeletedEvent(), $this->page->GetDeleted());
        $user->ChangeEmailPreference(new ReservationSeriesEndingEvent(), $this->page->GetSeriesEnding());
        $user->ChangeEmailPreference(new ParticipationChangedEvent(), $this->page->GetParticipantChanged());

        $this->userRepository->Update($user);
	}

}

