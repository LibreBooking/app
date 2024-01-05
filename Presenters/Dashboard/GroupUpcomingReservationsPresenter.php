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
        $lastDate = $now->AddDays(13-$dayOfWeek-1);

        $consolidated = [];
        $resourceIds = $this->GetUserAdminResources();

        if($resourceIds != null){
            $consolidated = $this->repository->GetReservations($now, $lastDate, $this->searchUserId, $this->searchUserLevel, null, $resourceIds,true);
        } 

        $tomorrow = $today->AddDays(1);
        $startOfNextWeek = $today->AddDays(7-$dayOfWeek);

        $todays = [];
        $tomorrows = [];
        $thisWeeks = [];
        $nextWeeks = [];

        if ($consolidated != null){
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
    }

    /**
     * Gets the resources of which the groups of the user are in charge of
     */
    private function GetUserAdminResources(){
        $resourceIds = [];

        if (ServiceLocator::GetServer()->GetUserSession()->IsResourceAdmin){    
            $command = new GetResourceAdminResourcesCommand(ServiceLocator::GetServer()->GetUserSession()->UserId);
            $reader = ServiceLocator::GetDatabase()->Query($command);

            while ($row = $reader->GetRow()) {
                $resourceId = $row[ColumnNames::RESOURCE_ID];

                if (!array_key_exists($resourceId, $resourceIds)) {
                    $resourceIds[$resourceId] = $resourceId;
                } 
            }
            $reader->Free();
        }

        if (ServiceLocator::GetServer()->GetUserSession()->IsScheduleAdmin){
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
