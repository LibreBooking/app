<?php
require_once(ROOT_DIR . 'Presenters/Admin/ManageReservationsPresenter.php');

class ManageReservationsPresenterTests extends TestBase
{
	/**
	 * @var ManageReservationsPresenter
	 */
	private $presenter;

	/**
	 * @var IManageReservationsPage|PHPUnit_Framework_MockObject_MockObject
	 */
	private $page;

	/**
	 * @var IReservationViewRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $reservationViewRepository;
	
	public function setup()
	{
		parent::setup();

		$this->page = $this->getMock('IManageReservationsPage');
		$this->reservationViewRepository = $this->getMock('IReservationViewRepository');

		$this->presenter = new ManageReservationsPresenter($this->page, $this->reservationViewRepository);
	}
	
	public function testUsesTwoWeekSpanWhenNoDateFilterProvided()
	{
		$userTimezone = 'America/Chicago';
		$defaultStart = Date::Now()->AddDays(-7)->ToTimezone($userTimezone)->GetDate();
		$defaultEnd = Date::Now()->AddDays(7)->ToTimezone($userTimezone)->GetDate();

		$this->page->expects($this->atLeastOnce())
				->method('GetStartDate')
				->will($this->returnValue(null));

		$this->page->expects($this->atLeastOnce())
				->method('GetEndDate')
				->will($this->returnValue(null));

		$filter = $this->GetExpectedFilter($defaultStart, $defaultEnd);
		$data = new PageableData();
		$this->reservationViewRepository->expects($this->once())
				->method('GetList')
				->with($this->anything(), $this->anything(), null, null, $filter)
				->will($this->returnValue($data));

		$this->page->expects($this->once())
				->method('SetStartDate')
				->with($this->equalTo($defaultStart));

		$this->page->expects($this->once())
				->method('SetEndDate')
				->with($this->equalTo($defaultEnd));
		
		$this->presenter->PageLoad($userTimezone);
	}

	/**
	 * @param Date $startDate
	 * @param Date $endDate
	 * @param string $referenceNumber
	 * @param int $scheduleId
	 * @param int $resourceId
	 * @param int $userId
	 * @return ISqlFilter
	 */
	private function GetExpectedFilter($startDate = null, $endDate = null, $referenceNumber = null, $scheduleId = null, $resourceId = null, $userId = null)
	{
		$filter = new SqlFilterNull();

		if ($startDate != null)
		{
			$filter->_And(new SqlFilterGreaterThan(ColumnNames::RESERVATION_START, $startDate->ToDatabase()));
		}

		if ($endDate != null)
		{
			$filter->_And(new SqlFilterLessThan(ColumnNames::RESERVATION_END, $endDate->ToDatabase()));
		}

		return $filter;
	}
}

?>
