<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');

class ReservationTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testUpdatingANewReservation()
	{
		$userId = 32;
		$resourceId = 10;
		$title = 'Title';
		$description = 'some long decription';
		
		$startDateCst = '2010-02-02 12:15';
		$endDateCst = '2010-02-04 17:15';
		
		$startDateUtc = Date::Parse($startDateCst, 'CST')->ToUtc();
		$endDateUtc = Date::Parse($endDateCst, 'CST')->ToUtc();
		
		$dateRange = DateRange::Create($startDateCst, $endDateCst, 'CST');
		
		$reservation = new Reservation();
		$reservation->Update($userId, $resourceId, $title, $description);
		$reservation->UpdateDuration($dateRange);

		$this->assertEquals($userId, $reservation->UserId());
		$this->assertEquals($resourceId, $reservation->ResourceId());
		$this->assertEquals($title, $reservation->Title());
		$this->assertEquals($description, $reservation->Description());
		$this->assertEquals($startDateUtc, $reservation->StartDate());
		$this->assertEquals($endDateUtc, $reservation->EndDate());
	}
	
	public function testConfigureRepeatOptionsWithANewReservation()
	{				
		$startDateCst = '2010-02-02 12:15';
		$endDateCst = '2010-02-04 17:15';
		
		$dateRange = DateRange::Create($startDateCst, $endDateCst, 'CST');
		
		$repeatOptions = new NoRepetion();
		
		//TODO need a whole fixture just for repetition
		$reservation = new Reservation();
		$reservation->UpdateDuration($dateRange);
		$reservation->Repeats($repeatOptions);
		
		$this->assertEquals($repeatedDates, $reservation->RepeatedDates());
	}
}

class Reservation
{
	/**
	 * @var int
	 */
	private $_userId;

	/**
	 * @return int
	 */
	public function UserId()
	{
		return $this->_userId;
	}

	/**
	 * @var int
	 */
	private $_resourceId;

	/**
	 * @return int
	 */
	public function ResourceId()
	{
		return $this->_resourceId;
	}

	/**
	 * @var string
	 */
	private $_title;

	/**
	 * @return string
	 */
	public function Title()
	{
		return $this->_title;
	}

	/**
	 * @var string
	 */
	private $_description;

	/**
	 * @return string
	 */
	public function Description()
	{
		return $this->_description;
	}

	/**
	 * @var Date
	 */
	private $_startDate;
	
	/**
	 * @return Date
	 */
	public function StartDate()
	{
		return $this->_startDate;
	}
	
	/**
	 * @var Date
	 */
	private $_endDate;
	
	/**
	 * @return Date
	 */
	public function EndDate()
	{
		return $this->_endDate;
	}
	
	public function Update($userId, $resourceId, $title, $description)
	{
		$this->_userId = $userId;
		$this->_resourceId = $resourceId;
		$this->_title = $title;
		$this->_description = $description;
	}

	public function UpdateDuration(DateRange $duration)
	{
		$this->_startDate = $duration->GetBegin()->ToUtc();
		$this->_endDate = $duration->GetEnd()->ToUtc();
	}
}