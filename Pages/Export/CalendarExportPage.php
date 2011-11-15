<?php
require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

interface ICalendarExportPage
{
	/**
	 * @abstract
	 * @return string
	 */
	public function GetReferenceNumber();

	/**
	 * @abstract
	 * @param Date $dateCreated
	 * @return void
	 */
	public function SetDateCreated($dateCreated);

	/**
	 * @abstract
	 * @param Date $dateEnd
	 * @return void
	 */
	public function SetDateEnd($dateEnd);

	/**
	 * @abstract
	 * @param Date $dateStart
	 * @return void
	 */
	public function SetDateStart($dateStart);

	/**
	 * @abstract
	 * @param string $description
	 * @return void
	 */
	public function SetDescription($description);

	/**
	 * @abstract
	 * @param string $organizer
	 * @return void
	 */
	public function SetOrganizer($organizer);

	/**
	 * @abstract
	 * @param string $recurRule
	 * @return void
	 */
	public function SetRecurRule($recurRule);

	/**
	 * @abstract
	 * @param string $referenceNumber
	 * @return void
	 */
	public function SetReferenceNumber($referenceNumber);

	/**
	 * @abstract
	 * @param string $summary
	 * @return void
	 */
	public function SetSummary($summary);

	/**
	 * @abstract
	 * @param string $location
	 * @return void
	 */
	public function SetLocation($location);

	/**
	 * @abstract
	 * @param string $url
	 * @return void
	 */
	public function SetReservationUrl($url);
}

class CalendarExportPage extends SecurePage implements ICalendarExportPage
{
	/**
	 * @var \CalendarExportPresenter
	 */
	private $presenter;

	public function __construct()
	{
		$this->presenter = new CalendarExportPresenter($this, new ReservationViewRepository());
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
	 * @param Date $dateCreated
	 * @return void
	 */
	public function SetDateCreated($dateCreated)
	{
		$this->Set('DateCreated', $dateCreated);
	}

	/**
	 * @param Date $dateEnd
	 * @return void
	 */
	public function SetDateEnd($dateEnd)
	{
		$this->Set('DateEnd', $dateEnd);
	}

	/**
	 * @param Date $dateStart
	 * @return void
	 */
	public function SetDateStart($dateStart)
	{
		$this->Set('DateStart', $dateStart);
	}

	/**
	 * @param string $description
	 * @return void
	 */
	public function SetDescription($description)
	{
		$this->Set('Description', $description);
	}

	/**
	 * @param string $organizer
	 * @return void
	 */
	public function SetOrganizer($organizer)
	{
		$this->Set('OwnerEmail', $organizer);
	}

	/**
	 * @param string $recurRule
	 * @return void
	 */
	public function SetRecurRule($recurRule)
	{
		$this->Set('RecurRule', $recurRule);
	}

	/**
	 * @param string $referenceNumber
	 * @return void
	 */
	public function SetReferenceNumber($referenceNumber)
	{
		$this->Set('ReferenceNumber', $referenceNumber);
	}

	/**
	 * @param string $summary
	 * @return void
	 */
	public function SetSummary($summary)
	{
		$this->Set('Summary', $summary);
	}

	/**
	 * @param string $location
	 * @return void
	 */
	public function SetLocation($location)
	{
		$this->Set('ResourceName', $location);
	}

	/**
	 * @param string $url
	 * @return void
	 */
	public function SetReservationUrl($url)
	{
		$this->Set('ReservationUrl', $url);
	}
}

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
		$res = $this->reservationViewRepository->GetReservationForEditing($this->page->GetReferenceNumber());

		$this->page->SetDateCreated($res->DateCreated);
		$this->page->SetDateEnd($res->EndDate);
		$this->page->SetDateStart($res->StartDate);
		$this->page->SetDescription($res->Description);
		$this->page->SetOrganizer($res->OwnerEmailAddress);
		$this->page->SetRecurRule($this->CreateRecurRule($res));
		$this->page->SetReferenceNumber($res->ReferenceNumber);
		$this->page->SetSummary($res->Title);
		$this->page->SetReservationUrl(sprintf("%s?%s=%s", Pages::RESERVATION, QueryStringKeys::REFERENCE_NUMBER, $res->ReferenceNumber));

		$this->page->SetLocation($res->ResourceName);
		
	}

	/**
	 * @param ReservationView $res
	 * @return null|string
	 */
	private function CreateRecurRule(ReservationView $res)
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
