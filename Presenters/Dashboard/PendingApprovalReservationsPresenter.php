<?php

require_once(ROOT_DIR . 'Controls/Dashboard/PendingApprovalReservations.php');

class PendingApprovalReservationsPresenter
{
    /**
     * @var IPendingApprovalReservationsControl
     */
    private $control;

    /**
     * @var IReservationViewRepository
     */
    private $repository;

    /**
     * @var int
     */
    private $searchUserId = ReservationViewRepository::ALL_USERS;

    /**
     * @var int
     */
    private $searchUserLevel = ReservationUserLevel::ALL;

    public function __construct(IPendingApprovalReservationsControl $control, IReservationViewRepository $repository)
    {
        $this->control = $control;
        $this->repository = $repository;
    }

    public function SetSearchCriteria($userId, $userLevel)
    {
        $this->searchUserId = $userId;
        $this->searchUserLevel = $userLevel;
    }

    public function PageLoad()
    {
        $user = ServiceLocator::GetServer()->GetUserSession();
        $timezone = $user->Timezone;

        $now = Date::Now();
        $today = $now->ToTimezone($timezone)->GetDate();
        $dayOfWeek = $today->Weekday();
        $endOfMonth = $today->AddDays(DateDiff::getMonthRemainingDays($timezone)+1);
        $endOfYear = $today->AddDays(DateDiff::getYearRemainingDays($timezone)+1);

        $consolidated = [];

        if (ServiceLocator::GetServer()->GetUserSession()->IsAdmin){
            $consolidated = $this->repository->GetReservationsPendingApproval($now, $this->searchUserId, $this->searchUserLevel, null, null,true);
        }

        else if (ServiceLocator::GetServer()->GetUserSession()->IsResourceAdmin){
            $groupResourceIds = $this->GetUserAdminResources();
            
            if($groupResourceIds != null){
                $consolidated = array_merge($consolidated, $this->repository->GetReservationsPendingApproval($now, $this->searchUserId, $this->searchUserLevel, null, $groupResourceIds,true));
            }
        }

        $tomorrow = $today->AddDays(1);
        $startOfNextWeek = $today->AddDays(7-$dayOfWeek);

        $todays = [];
        $tomorrows = [];
        $thisWeeks = [];
        $thisMonths = [];
        $thisYears = [];
        $futures = [];

        if ($consolidated != null){
            foreach ($consolidated as $reservation) {
                $start = $reservation->StartDate->ToTimezone($timezone);
                
                if ($start->DateEquals($today)) {
                    $todays[] = $reservation;
                } elseif ($start->DateEquals($tomorrow)) {
                    $tomorrows[] = $reservation;
                } elseif ($start->LessThan($startOfNextWeek)) {
                    $thisWeeks[] = $reservation;
                } elseif ($start->LessThan($endOfMonth)) {
                    $thisMonths[] = $reservation;
                } elseif ($start->LessThan($endOfYear)){
                    $thisYears[] = $reservation;
                } else{
                    $futures[] = $reservation;
                }
            }

            $checkinAdminOnly = Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_CHECKIN_ADMIN_ONLY, new BooleanConverter());
            $checkoutAdminOnly = Configuration::Instance()->GetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_CHECKOUT_ADMIN_ONLY, new BooleanConverter());

            $allowCheckin = $user->IsAdmin || !$checkinAdminOnly;
            $allowCheckout = $user->IsAdmin || !$checkoutAdminOnly;

            $this->control->SetTotal(count($consolidated));
            $this->control->SetTimezone($timezone);
            $this->control->SetUserId($user->UserId);

            $this->control->SetAllowCheckin($allowCheckin);
            $this->control->SetAllowCheckout($allowCheckout);

            $this->control->BindToday($todays);
            $this->control->BindTomorrow($tomorrows);
            $this->control->BindThisWeek($thisWeeks);
            $this->control->BindThisMonth($thisMonths);
            $this->control->BindThisYear($thisYears);
            $this->control->BindRemaining($futures);
        }
    }

    /**
     * Gets the resources of which the groups of the user are in charge of
     */
    private function GetUserAdminResources(){
        $resourceIds = [];

        $command = new GetResourceAdminResourcesCommand(ServiceLocator::GetServer()->GetUserSession()->UserId);
        $reader = ServiceLocator::GetDatabase()->Query($command);

        while ($row = $reader->GetRow()) {
            $resourceId = $row[ColumnNames::RESOURCE_ID];

            if (!array_key_exists($resourceId, $resourceIds)) {
                $resourceIds[$resourceId] = $resourceId;
            } 
        }
        $reader->Free();

        //If a given reservation is pending approval a user who is only a schedule admin can't approve them, only a resource admin that manages the resource of that same reservation
        //However if this schedule admin is a resource admin (even if he does not manage the resource) and that resource is in the schedule he can approve (or reject)
        if (ServiceLocator::GetServer()->GetUserSession()->IsScheduleAdmin && ServiceLocator::GetServer()->GetUserSession()->IsResourceAdmin){
            $command = new GetScheduleAdminResourcesCommand(ServiceLocator::GetServer()->GetUserSession()->UserId);
            $reader = ServiceLocator::GetDatabase()->Query($command);

            while ($row = $reader->GetRow()) {
                $resourceId = $row[ColumnNames::RESOURCE_ID];

                if (!array_key_exists($resourceId, $resourceIds)) {
                    $resourceIds[$resourceId] = $resourceId;
                } 
            }
            $reader->Free();
        }

        return $resourceIds;
    }
}

