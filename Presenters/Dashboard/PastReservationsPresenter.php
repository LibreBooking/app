<?php

require_once(ROOT_DIR . 'Controls/Dashboard/PastReservations.php');

class PastReservationsPresenter
{
    /**
     * @var IPastReservationsControl
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

    public function __construct(IPastReservationsControl $control, IReservationViewRepository $repository)
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

        $firstDate = $now->AddDays(-(13-$dayOfWeek-1));
        $consolidated = $this->repository->GetReservations($firstDate, $now, $this->searchUserId, $this->searchUserLevel, null, null, true);
        $yesterday = $today->AddDays(-1);

        // echo '<pre>' , var_dump($today) , '</pre>';
        // echo '<pre>' , var_dump($firstDate) , '</pre>';
        // echo '<pre>' , var_dump($yesterday) , '</pre>';
        // echo '<pre>' , var_dump($consolidated) , '</pre>';


        $startOfPreviousWeek = $today->AddDays(-(7+$dayOfWeek));   //CERTO       //SEGUNDA ->1 TERCA->2 ,....

        // echo '<pre>' , var_dump($dayOfWeek) , '</pre>';     
        // echo '<pre>' , var_dump($startOfPreviousWeek) , '</pre>';

        // $teste = $startOfPreviousWeek->AddDays(7);
        // echo '<pre>' , var_dump($teste) , '</pre>';

        $todays = [];
        $yesterdays = [];
        $thisWeeks = [];
        $previousWeeks = [];

        /* @var $reservation ReservationItemView */
        foreach ($consolidated as $reservation) {
            $start = $reservation->StartDate->ToTimezone($timezone);

            if ($start->DateEquals($today)) {
                $todays[] = $reservation;
            } elseif ($start->DateEquals($yesterday)) {
                $yesterdays[] = $reservation;
            } elseif ($start->GreaterThan($startOfPreviousWeek->AddDays(7))) {          //TA MAL -> Nada é menor que 1º dia da semana passada
                $thisWeeks[] = $reservation;
            } else {
                $previousWeeks[] = $reservation;
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

        $this->control->BindToday($todays);             //BindToday (-)
        $this->control->BindYesterday($yesterdays);       //BindYesterday
        $this->control->BindThisWeek($thisWeeks);       //BindThisWeek (-)
        $this->control->BindPreviousWeek($previousWeeks);       //BindPreviousWeek
    }
}
