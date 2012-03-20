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

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/CalendarExportPresenter.php');

interface ICalendarExportPage
{
	/**
	 * @abstract
	 * @return string
	 */
	public function GetReferenceNumber();

	/**
	 * @abstract
	 * @param array|iCalendarReservationView[] $reservations
	 */
	public function SetReservations($reservations);

    /**
     * @abstract
     * @return int
     */
    public function GetScheduleId();

    /**
     * @abstract
     * @return int
     */
    public function GetResourceId();
}

class CalendarExportPage extends Page implements ICalendarExportPage
{
	/**
	 * @var \CalendarExportPresenter
	 */
	private $presenter;

	public function __construct()
	{
		$this->presenter = new CalendarExportPresenter($this, new ReservationViewRepository(), new NullCalendarExportValidator());
		parent::__construct('', 1);
	}

	public function PageLoad()
	{
		$this->presenter->PageLoad();

		header("Content-Type: text/Calendar");
		header("Content-Disposition: inline; filename=calendar.ics");

		$config = Configuration::Instance();

		$this->Set('phpScheduleItVersion', $config->GetKey(ConfigKeys::VERSION));
		$this->Set('DateStamp', Date::Now());
		$this->Set('ScriptUrl', $config->GetScriptUrl());

		$this->Display('Export/ical.tpl');
	}

	public function GetReferenceNumber()
	{
		return $this->GetQuerystring(QueryStringKeys::REFERENCE_NUMBER);
	}

	/**
	 * @param array|iCalendarReservationView[] $reservations
	 */
	public function SetReservations($reservations)
	{
		$this->Set('Reservations', $reservations);
	}

    /**
     * @return int
     */
    public function GetScheduleId()
    {
        return $this->GetQuerystring(QueryStringKeys::SCHEDULE_ID);
    }

    /**
     * @return int
     */
    public function GetResourceId()
    {
        return $this->GetQuerystring(QueryStringKeys::RESOURCE_ID);
    }
}

class NullCalendarExportValidator implements ICalendarExportValidator
{
    /**
     * @return bool
     */
    function IsValid()
    {
        return true;
    }
}
?>