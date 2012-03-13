<?php
/**
Copyright 2012 Nick Korbel

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

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Pages/Export/CalendarExportPage.php');

class CalendarExportPresenter
{
	/**
	 * @var \ICalendarExportPage
	 */
	private $page;

	public function __construct(ICalendarExportPage $page, IReservationViewRepository $reservationViewRepository)
	{
		$this->page = $page;
		$this->reservationViewRepository = $reservationViewRepository;
	}

	public function PageLoad()
	{
		//$res = $this->reservationViewRepository->GetReservationForEditing($this->page->GetReferenceNumber());
		$list = $this->reservationViewRepository->GetList(1, 200, null, null, $this->GetFilter());

		$reservations = array();
		/** @var $res ReservationItemView */
		foreach ($list->Results() as $res)
		{
			$reservations[] = new iCalendarReservationView($res);
		}

		$this->page->SetReservations($reservations);
	}

	/**
	 * @return ISqlFilter
	 */
	private function GetFilter()
	{
		$filter = new SqlFilterGreaterThan(ColumnNames::RESERVATION_START, Date::Now()->AddDays(-7)->ToDatabase());
		$filter->_And(new SqlFilterEquals(ColumnNames::REFERENCE_NUMBER, $this->page->GetReferenceNumber()));

		return $filter;
	}
}

class iCalendarReservationView
{
	public $DateCreated;
	public $DateEnd;
	public $DateStart;
	public $Description;
	public $Organizer;
	public $RecurRule;
	public $ReferenceNumber;
	public $Summary;
	public $ReservationUrl;
	public $Location;

	public function __construct(ReservationItemView $res)
	{
		$this->DateCreated = $res->CreatedDate;
		$this->DateEnd = $res->EndDate;
		$this->DateStart = $res->StartDate;
		$this->Description = $res->Description;
		$this->Organizer = $res->OwnerEmailAddress;
		$this->RecurRule = $this->CreateRecurRule($res);
		$this->ReferenceNumber = $res->ReferenceNumber;
		$this->Summary = $res->Title;
		$this->ReservationUrl = sprintf("%s?%s=%s", Pages::RESERVATION, QueryStringKeys::REFERENCE_NUMBER, $res->ReferenceNumber);
		$this->Location = $res->ResourceName;
	}

	/**
	 * @param ReservationItemView $res
	 * @return null|string
	 */
	private function CreateRecurRule(ReservationItemView $res)
	{
		if ($res->RepeatType == RepeatType::None)
		{
			return null;
		}

		$freqMapping = array(RepeatType::Daily => 'DAILY', RepeatType::Weekly => 'WEEKLY', RepeatType::Monthly => 'MONTHLY', RepeatType::Yearly => 'YEARLY');
		$freq = $freqMapping[$res->RepeatType];
		$interval = $res->RepeatInterval;
		$format = Resources::GetInstance()->GetDateFormat('ical');
		$end = $res->RepeatTerminationDate->Format($format);
		$rrule = sprintf('FREQ=%s;INTERVAL=%s;UNTIL=%s', $freq, $interval, $end);

		if ($res->RepeatType == RepeatType::Monthly)
		{
			if ($res->RepeatMonthlyType == RepeatMonthlyType::DayOfMonth)
			{
				$rrule .= ';BYMONTHDAY=' . $res->StartDate->Day();
			}
		}

		if (!empty($res->RepeatWeekdays))
		{
			$dayMapping = array('SU', 'MO', 'TU', 'WE', 'TH', 'FR', 'SA');
			$days = '';
			foreach ($res->RepeatWeekdays as $weekDay)
			{
				$days .= ($dayMapping[$weekDay] . ',');
			}
			$days = substr($days, 0, -1);
			$rrule .= (';BYDAY=' . $days);
		}

		return $rrule;
	}
}

?>