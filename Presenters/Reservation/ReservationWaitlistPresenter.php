<?php

require_once(ROOT_DIR . 'Pages/Ajax/ReservationWaitlistPage.php');

class ReservationWaitlistPresenter
{
    /**
     * @var IReservationWaitlistPage
     */
    private $page;
    /**
     * @var UserSession
     */
    private $user;
    /**
     * @var IReservationWaitlistRepository
     */
    private $repository;

    public function __construct(IReservationWaitlistPage $page, UserSession $user, IReservationWaitlistRepository $repository)
    {
        $this->page = $page;
        $this->user = $user;
        $this->repository = $repository;
    }

    public function PageLoad()
    {
        $duration = $this->GetReservationDuration();
        $resourceId = $this->page->GetResourceId();

        $request = ReservationWaitlistRequest::Create($this->page->GetUserId(), $duration->GetBegin(), $duration->GetEnd(), $resourceId);
        $this->repository->Add($request);
    }

    /**
     * @return DateRange
     */
    private function GetReservationDuration()
    {
        $startDate = $this->page->GetStartDate();
        $startTime = $this->page->GetStartTime();
        $endDate = $this->page->GetEndDate();
        $endTime = $this->page->GetEndTime();

        $timezone = $this->user->Timezone;
        return DateRange::Create($startDate . ' ' . $startTime, $endDate . ' ' . $endTime, $timezone);
    }
}
