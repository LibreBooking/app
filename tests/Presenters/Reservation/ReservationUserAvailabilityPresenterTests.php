<?php
/**
 * Copyright 2018-2019 Nick Korbel
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

require_once(ROOT_DIR . 'Presenters/Reservation/ReservationUserAvailabilityPresenter.php');

class ReservationUserAvailabilityPresenterTests extends TestBase
{

    /**
     * @var ReservationUserAvailabilityPresenter
     */
    private $presenter;

    /**
     * @var FakeReservationUserAvailabilityPage
     */
    private $page;

    /**
     * @var FakeReservationViewRepository
     */
    private $reservationRepository;

    /**
     * @var FakeScheduleRepository
     */
    private $scheduleRepository;

    /**
     * @var FakeUserRepository
     */
    private $userRepository;

    /**
     * @var FakeResourceRepository
     */
    private $resourceRepository;

    public function setup()
    {
        parent::setup();

        $this->page = new FakeReservationUserAvailabilityPage();
        $this->reservationRepository = new FakeReservationViewRepository();
        $this->scheduleRepository = new FakeScheduleRepository();
        $this->userRepository = new FakeUserRepository();
        $this->resourceRepository = new FakeResourceRepository();

        $this->presenter = new ReservationUserAvailabilityPresenter($this->page,
            $this->reservationRepository,
            $this->scheduleRepository,
            $this->userRepository,
            $this->resourceRepository);
    }

    public function testBindsResourceAndUserLayout()
    {
        $tz = $this->fakeUser->Timezone;

        $expectedPeriods = array(new SchedulePeriod(Date::Now(), Date::Now()));
        $expectedInvitees = array(new UserDto(1, 'user1', 'invitee', '1@1.com'));
        $expectedParticipants = array(new UserDto(2, 'user2', 'participant', '2@2.com'));
        $expectedResources = array(new FakeBookableResource(1, 'resource1'));
        $expectedUser = new UserDto('3', 'user3', 'user', '3@3.com');

        $this->page->_ResourceIds = array(1);
        $this->page->_InviteeIds = array(1);
        $this->page->_ParticipantIds = array(2);
        $this->page->_ScheduleId = 1;

        $startDate = Date::Now()->ToTimezone($tz)->AddDays(-1);
        $endDate = Date::Now()->ToTimezone($tz)->AddDays(1);


        $this->page->_StartDate = $startDate->Format('Y-m-d');
        $this->page->_StartTime = '07:29';
        $this->page->_EndDate = $endDate->Format('Y-m-d');
        $this->page->_EndTime = '14:15';
        $this->fakeUser->UserId = 3;

        $listingDates = new DateRange($startDate->SetTimeString($this->page->_StartTime), $endDate->SetTimeString($this->page->_EndTime));


        $this->resourceRepository->_Resource = $expectedResources[0];
        $this->userRepository->_UserDtos[3] = $expectedUser;
        $this->userRepository->_UserDtos[2] = $expectedParticipants[0];
        $this->userRepository->_UserDtos[1] = $expectedInvitees[0];

        $resourceReservation = new TestReservationItemView(1, Date::Now(), Date::Now(), 1);
        $resourceReservation->UserId = 100;
        $resourceReservation->ResourceName = 'resource1';
        $resourceBlackout = new TestBlackoutItemView(1, Date::Now(), Date::Now(), 1);
        $resourceBlackout->ResourceName = 'resource1';
        $participantReservation = new TestReservationItemView(2, Date::Now(), Date::Now(), 100);
        $participantReservation->UserId = 2;
        $participantReservation->FirstName = 'user2';
        $participantReservation->LastName = 'participant';
        $participantReservation->ResourceName = 'whatever2';
        $inviteeReservation = new TestReservationItemView(3, Date::Now(), Date::Now(), 200);
        $inviteeReservation->UserId = 1;
        $inviteeReservation->FirstName = 'user1';
        $inviteeReservation->LastName = 'invitee';
        $inviteeReservation->ResourceName = 'whatever1';
        $userReservation = new TestReservationItemView(3, Date::Now(), Date::Now(), 200);
        $userReservation->UserId = 3;
        $userReservation->FirstName = 'user3';
        $userReservation->LastName = 'user';
        $userReservation->ResourceName = 'whatever3';

        $adjustedParticipantReservation = $participantReservation;
        $adjustedParticipantReservation->ResourceName = 'user2 participant';
        $adjustedParticipantReservation->ResourceId = -2;
        $adjustedInviteeReservation = $inviteeReservation;
        $adjustedInviteeReservation->ResourceName = 'user1 invitee';
        $adjustedInviteeReservation->ResourceId = -1;
        $adjustedUserReservation = $userReservation;
        $adjustedUserReservation->ResourceName = 'user3 user';
        $adjustedUserReservation->ResourceId = -3;

        $this->reservationRepository->_ReservationsIteration[0] = array($resourceReservation);
        $this->reservationRepository->_ReservationsIteration[1] = array($userReservation);
        $this->reservationRepository->_ReservationsIteration[2] = array($participantReservation);
        $this->reservationRepository->_ReservationsIteration[3] = array($inviteeReservation);
        $this->reservationRepository->_Blackouts = array($resourceBlackout);

        $this->page->_StartDate = Date::Now()->AddDays(-1)->Format('Y-m-d');
        $this->page->_StartTime = '07:29';
        $this->page->_EndDate = Date::Now()->AddDays(1)->Format('Y-m-d');

        $listing = new ReservationListing($tz, $listingDates);
        $listing->Add($resourceReservation);
        $listing->AddBlackout($resourceBlackout);
        $listing->Add($adjustedUserReservation);
        $listing->Add($adjustedParticipantReservation);
        $listing->Add($adjustedInviteeReservation);

        $scheduleLayout = new FakeScheduleLayout();
        $scheduleLayout->_Layout = $expectedPeriods;
        $this->scheduleRepository->_Layout = $scheduleLayout;

        $expectedLayout = new DailyLayout($listing, $scheduleLayout);

        $this->presenter->PageLoad($this->fakeUser);

        $start = Date::Parse($this->page->_StartDate . ' ' . $this->page->_StartTime, $this->fakeUser->Timezone);
        $end = Date::Parse($this->page->_EndDate . ' ' . $this->page->_EndTime, $this->fakeUser->Timezone);
        $this->assertEquals(new DateRange($start->GetDate(), $end->GetDate()->AddDays(1)), $this->reservationRepository->_LastRange);
        $this->assertEquals($expectedInvitees, $this->page->_Invitees);
        $this->assertEquals($expectedParticipants, $this->page->_Participants);
        $this->assertEquals($expectedResources, $this->page->_Resources);
        $this->assertEquals($expectedUser, $this->page->_User);
        $this->assertEquals($expectedLayout, $this->page->_Layout);
    }

    public function testDoesNotShowResourcesUserCannotAccess()
    {

    }
}

class FakeReservationUserAvailabilityPage extends ReservationUserAvailabilityPage
{
    /**
     * @var int
     */
    public $_ScheduleId;

    /**
     * @var int[]
     */
    public $_ResourceIds;

    /**
     * @var int[]
     */
    public $_InviteeIds;

    /**
     * @var int[]
     */
    public $_ParticipantIds;

    /**
     * @var UserDto[]
     */
    public $_Invitees;

    /**
     * @var UserDto[]
     */
    public $_Participants;

    /**
     * @var BookableResource[]
     */
    public $_Resources;

    /**
     * @var DailyLayout
     */
    public $_Layout;

    /**
     * @var UserDto
     */
    public $_User;

    /**
     * @var string
     */
    public $_StartDate;
    /**
     * @var string
     */
    public $_StartTime;
    /**
     * @var string
     */
    public $_EndDate;
    /**
     * @var string
     */
    public $_EndTime;

    public function GetScheduleId()
    {
        return $this->_ScheduleId;
    }

    public function GetResourceIds()
    {
        return $this->_ResourceIds;
    }

    public function GetInviteeIds()
    {
        return $this->_InviteeIds;
    }

    public function GetParticipantIds()
    {
        return $this->_ParticipantIds;
    }

    public function Bind($dailyLayout, $resources, $user, $participants, $invitees, $dateRange)
    {
        $this->_Layout = $dailyLayout;
        $this->_Resources = $resources;
        $this->_User = $user;
        $this->_Participants = $participants;
        $this->_Invitees = $invitees;
    }

    public function GetStartDate()
    {
        return $this->_StartDate;
    }

    public function GetStartTime()
    {
        return $this->_StartTime;
    }

    public function GetEndDate()
    {
        return $this->_EndDate;
    }

    public function GetEndTime()
    {
        return $this->_EndTime;
    }
}
