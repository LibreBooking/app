<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

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
        $this->Set('DefaultTitle', Resources::GetInstance()->GetString('NoTitleLabel'));
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