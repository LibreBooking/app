<?php

require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Schedule/namespace.php');
require_once(ROOT_DIR . 'Pages/Ajax/ReservationUserAvailabilityPage.php');

class ReservationUserAvailabilityPresenter
{
    /**
     * @var IReservationUserAvailabilityPage
     */
    private $page;
    /**
     * @var IReservationViewRepository
     */
    private $reservationViewRepository;
    /**
     * @var IScheduleRepository
     */
    private $scheduleRepository;
    /**
     * @var IUserRepository
     */
    private $userRepository;
    /**
     * @var IResourceRepository
     */
    private $resourceRepository;

    public function __construct(
        IReservationUserAvailabilityPage $page,
        IReservationViewRepository $reservationViewRepository,
        IScheduleRepository $scheduleRepository,
        IUserRepository $userRepository,
        IResourceRepository $resourceRepository
    ) {
        $this->page = $page;
        $this->reservationViewRepository = $reservationViewRepository;
        $this->scheduleRepository = $scheduleRepository;
        $this->userRepository = $userRepository;
        $this->resourceRepository = $resourceRepository;
    }

    public function PageLoad(UserSession $userSession)
    {
        $resources = [];
        $user = null;
        $invitees = [];
        $participants = [];

        $resourceIds = $this->page->GetResourceIds();
        $inviteeIds = $this->page->GetInviteeIds();
        $participantIds = $this->page->GetParticipantIds();
        $scheduleId = $this->page->GetScheduleId();

        $dates = $this->GetReservationDuration($userSession);
        $start = $dates->GetBegin()->GetDate();
        $end = $dates->GetEnd()->GetDate()->AddDays(1);
        $scheduleLayout = $this->scheduleRepository->GetLayout($scheduleId, new ScheduleLayoutFactory($userSession->Timezone));

        $reservationListing = new ReservationListing($userSession->Timezone, $dates);

        $resourceReservations = $this->reservationViewRepository->GetReservations($start, $end, null, null, null, $resourceIds);
        $this->AddReservations($reservationListing, $resourceReservations);

        $resourceBlackouts = $this->reservationViewRepository->GetBlackoutsWithin(new DateRange($start, $end), null, $resourceIds);
        $this->AddBlackouts($reservationListing, $resourceBlackouts);

        $userReservations = $this->reservationViewRepository->GetReservations($start, $end, $userSession->UserId, ReservationUserLevel::ALL);
        $this->AddUsers($reservationListing, $userReservations, $userSession->UserId);

        foreach ($participantIds as $participantId) {
            $participantReservations = $this->reservationViewRepository->GetReservations($start, $end, $participantId, ReservationUserLevel::ALL);
            $this->AddUsers($reservationListing, $participantReservations, $participantId);
            $participants[] = $this->userRepository->GetById($participantId);
        }
        foreach ($inviteeIds as $inviteeId) {
            $inviteeReservations = $this->reservationViewRepository->GetReservations($start, $end, $inviteeId, ReservationUserLevel::ALL);
            $this->AddUsers($reservationListing, $inviteeReservations, $inviteeId);
            $invitees[] = $this->userRepository->GetById($inviteeId);
        }

        foreach ($resourceIds as $resourceId) {
            $resources[] = $this->resourceRepository->LoadById($resourceId);
        }

        $user = $this->userRepository->GetById($userSession->UserId);

        $this->page->Bind(
            new DailyLayout($reservationListing, $scheduleLayout),
            $resources,
            $user,
            $participants,
            $invitees,
            $dates
        );
    }

    /**
     * @param ReservationListing $reservationListing
     * @param ReservationItemView[] $reservations
     */
    private function AddReservations($reservationListing, $reservations)
    {
        foreach ($reservations as $r) {
            $reservationListing->Add($r);
        }
    }

    /**
     * @param ReservationListing $reservationListing
     * @param BlackoutItemView[] $reservations
     */
    private function AddBlackouts($reservationListing, $reservations)
    {
        foreach ($reservations as $r) {
            $reservationListing->AddBlackout($r);
        }
    }

    /**
     * @param ReservationListing $reservationListing
     * @param ReservationItemView[] $reservations
     * @param int $userId
     */
    private function AddUsers($reservationListing, $reservations, $userId)
    {
        foreach ($reservations as $r) {
            $r->ResourceId = $userId * -1;
            $name = new FullName($r->FirstName, $r->LastName);
            $r->ResourceName = $name->__toString();
            $reservationListing->Add($r);
        }
    }

    /**
     * @param UserSession $userSession
     * @return DateRange
     */
    private function GetReservationDuration(UserSession $userSession)
    {
        $startDate = $this->page->GetStartDate();
        $startTime = $this->page->GetStartTime();
        $endDate = $this->page->GetEndDate();
        $endTime = $this->page->GetEndTime();

        $timezone = $userSession->Timezone;
        return DateRange::Create($startDate . ' ' . $startTime, $endDate . ' ' . $endTime, $timezone);
    }
}
