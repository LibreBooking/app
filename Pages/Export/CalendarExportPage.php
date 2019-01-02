<?php
/**
Copyright 2011-2019 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Pages/Export/CalendarExportDisplay.php');
require_once(ROOT_DIR . 'Presenters/CalendarExportPresenter.php');

interface ICalendarExportPage
{
	/**
	 * @return string
	 */
	public function GetReferenceNumber();

	/**
	 * @param array|iCalendarReservationView[] $reservations
	 */
	public function SetReservations($reservations);

	/**
	 * @return int
	 */
	public function GetScheduleId();

	/**
	 * @return int
	 */
	public function GetResourceId();

	/**
	 * @return int
	 */
	public function GetAccessoryName();
}

class CalendarExportPage extends Page implements ICalendarExportPage
{
	/**
	 * @var \CalendarExportPresenter
	 */
	private $presenter;

	/**
	 * @var array|iCalendarReservationView[]
	 */
	private $reservations = array();

	public function __construct()
	{
		$authorization = new ReservationAuthorization(PluginManager::Instance()->LoadAuthorization());
		$this->presenter = new CalendarExportPresenter($this,
													   new ReservationViewRepository(),
													   new NullCalendarExportValidator(),
													   new PrivacyFilter($authorization));
		parent::__construct('', 1);
	}

	public function PageLoad()
	{
		$this->presenter->PageLoad(ServiceLocator::GetServer()->GetUserSession());

		header("Content-Type: text/Calendar");
		header("Content-Disposition: inline; filename=calendar.ics");

		$display = new CalendarExportDisplay();
		echo $display->Render($this->reservations);
	}

	public function GetReferenceNumber()
	{
		return $this->GetQuerystring(QueryStringKeys::REFERENCE_NUMBER);
	}

	public function SetReservations($reservations)
	{
		$this->reservations = $reservations;
	}

	public function GetScheduleId()
	{
		return $this->GetQuerystring(QueryStringKeys::SCHEDULE_ID);
	}

	public function GetResourceId()
	{
		return $this->GetQuerystring(QueryStringKeys::RESOURCE_ID);
	}

	public function GetAccessoryName()
	{
		return $this->GetQuerystring(QueryStringKeys::ACCESSORY_NAME);
	}
}

class NullCalendarExportValidator implements ICalendarExportValidator
{
	function IsValid()
	{
		return true;
	}
}