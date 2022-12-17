<?php

require_once(ROOT_DIR . 'Controls/Dashboard/DashboardItem.php');
require_once(ROOT_DIR . 'Presenters/Dashboard/UpcomingReservationsPresenter.php');
require_once(ROOT_DIR . 'Domain/Access/ReservationViewRepository.php');

class UpcomingReservations extends DashboardItem implements IUpcomingReservationsControl
{
    /**
     * @var UpcomingReservationsPresenter
     */
    protected $presenter;

    public function __construct(SmartyPage $smarty)
    {
        parent::__construct($smarty);
        $this->presenter = new UpcomingReservationsPresenter($this, new ReservationViewRepository());
    }

    public function PageLoad()
    {
        $this->Set('DefaultTitle', Resources::GetInstance()->GetString('NoTitleLabel'));
        $this->presenter->SetSearchCriteria(ServiceLocator::GetServer()->GetUserSession()->UserId, ReservationUserLevel::ALL);
        $this->presenter->PageLoad();
        $this->Display('upcoming_reservations.tpl');
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

    public function BindNextWeek($reservations)
    {
        $this->Set('NextWeeksReservations', $reservations);
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

interface IUpcomingReservationsControl
{
    public function SetTimezone($timezone);
    public function SetTotal($total);
    public function SetUserId($userId);

    public function SetAllowCheckin($allowCheckin);
    public function SetAllowCheckout($allowCheckout);

    public function BindToday($reservations);
    public function BindTomorrow($reservations);
    public function BindThisWeek($reservations);
    public function BindNextWeek($reservations);
}

class AllUpcomingReservations extends UpcomingReservations
{
    public function PageLoad()
    {
        $this->Set('DefaultTitle', Resources::GetInstance()->GetString('NoTitleLabel'));
        $this->presenter->SetSearchCriteria(ReservationViewRepository::ALL_USERS, ReservationUserLevel::ALL);
        $this->presenter->PageLoad();
        $this->Display('admin_upcoming_reservations.tpl');
    }
}
