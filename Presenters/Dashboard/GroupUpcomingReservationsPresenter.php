<?php

require_once(ROOT_DIR . 'Controls/Dashboard/GroupUpcomingReservations.php');

class GroupUpcomingReservationsPresenter
{
    /**
     * @var IGroupUpcomingReservationsControl
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

    public function __construct(IGroupUpcomingReservationsControl $control, IReservationViewRepository $repository)
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
        




        $userGroupIds = $this->GetUserGroups();                 //Obter Grupos do user
        echo '<pre>' , var_dump($userGroupIds) , '</pre>';


        $groupResourceIds = [];
        foreach ($userGroupIds as $userGroup){
            $groupResourceIds = array_merge($groupResourceIds, $this->GetGroupResources($userGroup));
            echo '<pre>' , var_dump($groupResourceIds) , '</pre>';
        }




        $lastDate = $now->AddDays(13-$dayOfWeek-1);
        $consolidated = $this->repository->GetReservations($now, $lastDate, $this->searchUserId, $this->searchUserLevel, null, $groupResourceIds,true);
        $tomorrow = $today->AddDays(1);                                         //segundo null tem de ser substituido pelos id's das resources

        $startOfNextWeek = $today->AddDays(7-$dayOfWeek);

        $todays = [];
        $tomorrows = [];
        $thisWeeks = [];
        $nextWeeks = [];

        /* @var $reservation ReservationItemView */
        foreach ($consolidated as $reservation) {
            $start = $reservation->StartDate->ToTimezone($timezone);

            if ($start->DateEquals($today)) {
                $todays[] = $reservation;
            } elseif ($start->DateEquals($tomorrow)) {
                $tomorrows[] = $reservation;
            } elseif ($start->LessThan($startOfNextWeek)) {
                $thisWeeks[] = $reservation;
            } else {
                $nextWeeks[] = $reservation;
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
        $this->control->BindNextWeek($nextWeeks);
    }

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

    private function GetGroupResources($groupId){
        if(ServiceLocator::GetServer()->GetUserSession()->IsResourceAdmin){
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
        return null;
    }

}
