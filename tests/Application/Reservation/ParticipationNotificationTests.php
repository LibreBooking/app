<?php
/**
 * Copyright 2019-2020 Nick Korbel
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

class ParticipationNotificationTests extends TestBase
{
    /**
     * @var FakeUserRepository
     */
    private $userRepository;
    /**
     * @var ParticipationNotification
     */
    private $participationNotification;

    public function setUp(): void
    {
        parent::setup();
        $this->userRepository = new FakeUserRepository();
        $this->participationNotification = new ParticipationNotification($this->userRepository);
        $this->fakeConfig->SetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_PREVENT_PARTICIPATION, 'false');
    }
    
    public function testWhenOwnerWantsEmails() 
    {
        $user = new FakeUser();
        $user->_WantsEmail = true;
        $this->userRepository->_User = $user;

        $this->participationNotification->Notify(new TestHelperExistingReservationSeries(), 123, InvitationAction::Accept);

        $this->assertInstanceOf('ReservationParticipationActivityEmail', $this->fakeEmailService->_LastMessage);
    }
    
    public function testWhenOwnerDoesNotWantEmails()
    {
        $user = new FakeUser();
        $user->_WantsEmail = false;
        $this->userRepository->_User = $user;

        $this->participationNotification->NotifyGuest(new TestHelperExistingReservationSeries(), 'guest@guest', InvitationAction::Decline);

        $this->assertEmpty($this->fakeEmailService->_LastMessage);
    }
}