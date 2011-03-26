<?php
require_once(ROOT_DIR . 'Controls/Dashboard/DashboardItem.php');
require_once(ROOT_DIR . 'Presenters/Dashboard/UpcomingReservationsPresenter.php');
require_once(ROOT_DIR . 'Domain/Access/ReservationViewRepository.php');

class UpcomingReservations extends DashboardItem implements IUpcomingReservationsControl
{
	/**
	 * @var UpcomingReservationsPresenter
	 */
	private $presenter;
	
	public function __construct(SmartyPage $smarty)
	{
		// should this be a Page instead?
		parent::__construct($smarty);
		$this->presenter = new UpcomingReservationsPresenter($this, new ReservationViewRepository());
	}
	
	public function PageLoad()
	{
		$this->presenter->PageLoad();
		$this->Display('upcoming_reservations.tpl');
	}
	
	public function SetTimezone($timezone)
	{
		$this->Assign('Timezone', $timezone);
	}
	
	public function SetTotal($total)
	{
		$this->Assign('Total', $total);
	}
	
	public function BindToday($reservations)
	{
		$this->Assign('TodaysReservations', $reservations);
	}
	
	public function BindTomorrow($reservations)
	{
		$this->Assign('TomorrowsReservations', $reservations);
	}
	
	public function BindThisWeek($reservations)
	{
		$this->Assign('ThisWeeksReservations', $reservations);
	}
	
	public function BindNextWeek($reservations)
	{
		$this->Assign('NextWeeksReservations', $reservations);
	}
}

interface IUpcomingReservationsControl
{
	function SetTimezone($timezone);
	function SetTotal($total);
	
	function BindToday($reservations);
	function BindTomorrow($reservations);
	function BindThisWeek($reservations);
	function BindNextWeek($reservations);
}

?>