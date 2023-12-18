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
        $endOfMonth = $today->AddDays($this->getMonthRemainingDays($timezone)+1);
        $endOfYear = $today->AddDays($this->getYearRemainingDays($timezone)+1);

        $consolidated = [];

        if (ServiceLocator::GetServer()->GetUserSession()->IsAdmin){
            $consolidated = $this->repository->GetReservationsPendingApproval($now, $this->searchUserId, $this->searchUserLevel, null, null,true);
        }

        else if (ServiceLocator::GetServer()->GetUserSession()->IsResourceAdmin){
            $userGroupIds = $this->GetUserGroups();
            
            $groupResourceIds = [];

            foreach ($userGroupIds as $userResource){
                $groupResourceIds = array_merge($groupResourceIds, $this->GetGroupResources($userResource));
            }
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

            //Sort By Date
            $consolidated = $this->BubbleSort($consolidated);

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
     * Gets the groups the user belongs to
     */
    private function GetUserGroups(){
        $groups = [];

        $command = new GetUserGroupsCommand(ServiceLocator::GetServer()->GetUserSession()->UserId, null);
        $reader = ServiceLocator::GetDatabase()->Query($command);

        while ($row = $reader->GetRow()) {
            $groupId = $row[ColumnNames::GROUP_ID];
            if (!array_key_exists($groupId, $groups)) {
                $groups[$groupId] = $groupId;
            }
        }
        $reader->Free();

        return $groups;
    }

    /**
     * Gets the resource ids the group of the user is managing
     */
    private function GetGroupResources($groupId){
        $resources = [];

        $command = new GetGroupResourcesId($groupId);
        $reader = ServiceLocator::GetDatabase()->Query($command);

        while ($row = $reader->GetRow()) {
            $resourceId = $row[ColumnNames::RESOURCE_ID];

            if (!array_key_exists($resourceId, $resources)) {
                $resources[$resourceId] = $resourceId;
            } 
        }
        $reader->Free();

        return $resources;
    }

    /**
     * Implements bubble sort algorithm to sort dates from array
     */
    function BubbleSort($array) {
        for ($i = 0; $i < count($array); $i++){
            $swapped = false;
            for ($j = 0; $j < count($array) - $i - 1; $j++)
            {

                if ($array[$j]->StartDate->DateCompare($array[$j+1]->StartDate) == 1) {
                    $t = $array[$j];
                    $array[$j] = $array[$j+1];
                    $array[$j+1] = $t;
                    $swapped = True;
                }

                else if($array[$j]->StartDate->DateCompare($array[$j+1]->StartDate) == 0){
                    if ($array[$j]->StartDate->CompareTime($array[$j+1]->StartDate) == 1) {
                        $t = $array[$j];
                        $array[$j] = $array[$j+1];
                        $array[$j+1] = $t;
                        $swapped = True;
                    }
                }
            }

            if ($swapped == false){
                break;
            }
        }
        return $array;
    }

    /**
     * Gets the number of remaining days in the present month
     */
    public function getMonthRemainingDays($timezone){
        date_default_timezone_set($timezone);
        $currentDate = new DateTime();
        $endOfMonth = new DateTime($currentDate->format('Y-m-t 23:59:59'));
        $interval = $currentDate->diff($endOfMonth);
        $daysUntilEndOfMonth = $interval->days;

        return $daysUntilEndOfMonth;
    }

    /**
     * Gets the number of remaining days in the present year
     */
    public function getYearRemainingDays($timezone){
        date_default_timezone_set($timezone);
        $currentDate = new DateTime();
        $endOfYear = new DateTime($currentDate->format('Y-12-31 23:59:59'));
        $interval = $currentDate->diff($endOfYear);
        $daysUntilEndOfYear = $interval->days;

        return $daysUntilEndOfYear;
    }
}

