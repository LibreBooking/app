<?php

require_once(ROOT_DIR . 'Controls/Dashboard/DashboardItem.php');
require_once(ROOT_DIR . 'Presenters/Dashboard/PendingApprovalReservationsPresenter.php');
require_once(ROOT_DIR . 'Domain/Access/ReservationViewRepository.php');

//This section of the dashboard doesn't show pending approval reservations as orange because all of them are pending

class PendingApprovalReservations extends DashboardItem implements IPendingApprovalReservationsControl
{
    /**
     * @var PendingApprovalReservationsPresenter
     */
    protected $presenter;

    public function __construct(SmartyPage $smarty)
    {
        parent::__construct($smarty);
        $this->presenter = new PendingApprovalReservationsPresenter($this, new ReservationViewRepository());
    }

    public function PageLoad()
    {
        $this->Set('DefaultTitle', Resources::GetInstance()->GetString('NoTitleLabel'));
        $this->presenter->SetSearchCriteria(ReservationViewRepository::ALL_USERS, ReservationUserLevel::ALL);
        $this->presenter->PageLoad();
        $this->Display('pending__approval_reservations.tpl');
    }

    public function SetTimezone($timezone)
    {
        $this->Set('Timezone', $timezone);
    }

    public function SetTotal($total)
    {
        $this->Set('Total', $total);
    }

    public function SetUserId($userId)
    {
        $this->Set('UserId', $userId);
    }

    public function BindToday($reservations)
    {
        $this->Set('TodaysReservations', $reservations);
    }

    public function BindTomorrow($reservations)
    {
        $this->Set('TomorrowsReservations', $reservations);
    }

    public function BindThisWeek($reservations)
    {
        $this->Set('ThisWeeksReservations', $reservations);
    }

    public function BindThisMonth($reservations)
    {
        $this->Set('ThisMonthsReservations', $reservations);
    }

    public function BindThisYear($reservations)
    {
        $this->Set('ThisYearsReservations', $reservations);
    }

    public function BindRemaining($reservations)
    {
        $this->Set('RemainingReservations', $reservations);
    }

    public function SetAllowCheckin($allowCheckin)
    {
        $this->Set('allowCheckin', $allowCheckin);
    }

    public function SetAllowCheckout($allowCheckout)
    {
        $this->Set('allowCheckout', $allowCheckout);
    }
}

interface IPendingApprovalReservationsControl
{
    public function SetTimezone($timezone);
    public function SetTotal($total);
    public function SetUserId($userId);

    public function SetAllowCheckin($allowCheckin);
    public function SetAllowCheckout($allowCheckout);

    public function BindToday($reservations);
    public function BindTomorrow($reservations);
    public function BindThisWeek($reservations);
    public function BindThisMonth($reservations);
    public function BindThisYear($reservations);
    public function BindRemaining($reservations);
}