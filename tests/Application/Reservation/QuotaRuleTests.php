<?php
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'tests/Domain/Reservation/TestReservationSeries.php');

class QuotaRuleTests extends TestBase
{
	/**
	 * @var IReservationViewRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	public $reservationRepository;

	/**
	 * @var IQuotaRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	public $quotaRepository;

	public function setup()
	{
		parent::setup();
		
		$this->reservationRepository = $this->getMock('IReservationViewRepository');
		$this->quotaRepository = $this->getMock('IQuotaRepository');
	}

	public function teardown()
	{
		parent::teardown();
	}

	public function testWhenTotalHoursForAnyReservationIsMoreThanQuotaAllowsForNewReservation()
	{
		$userId = 10;
		$resourceId = 20;
		$resourceId2 = 22;
		$begin = Date::Now();
		$begin->SetTimeString('3:30');
		$end = Date::Now();
		$end->SetTimeString('4:30');

		$repeatDailyForOneWeek = new RepeatDaily(1, $begin->AddDays(7));
		
		$reservationDate = new DateRange($begin, $end);
		$series = ReservationSeries::Create($userId, $resourceId, 1, null, null, $reservationDate, $repeatDailyForOneWeek);
		$series->AddResource($resourceId2);

		$quota1 = new TestQuota(1);
		$quota2 = new TestQuota(2);
		$quota4 = new TestQuota(4);
		
		$resource1Quotas = array($quota1, $quota2);
		$resource2Quotas = array($quota1, $quota4);

		$this->quotaRepository->expects($this->at(0))
			->method('GetQuotas')
			->with($this->equalTo($resourceId))
			->will($this->returnValue($resource1Quotas));

		$this->quotaRepository->expects($this->at(1))
			->method('GetQuotas')
			->with($this->equalTo($resourceId2))
			->will($this->returnValue($resource2Quotas));
					
		$rule = new QuotaRule($this->quotaRepository);
		$result = $rule->Validate($series);

		$this->assertTrue($result->IsValid(), 'no quotas were exceeded');
		$this->assertEquals($series, $quota1->ExceedsCalledWith);
		$this->assertEquals($series, $quota2->ExceedsCalledWith);
		$this->assertEquals($series, $quota4->ExceedsCalledWith);
	}

	public function testWhenFirstQuotaIsExceededTheOtherChecksAreSkipped()
	{
		$resourceId = 90123;
		$series = ReservationSeries::Create(1, $resourceId, 1, null, null, new TestDateRange(), new RepeatNone());

		$quota1 = new TestQuota(1, true);
		$quota2 = new TestQuota(2);
		$quota4 = new TestQuota(4);

		$resource1Quotas = array($quota1, $quota2, $quota4);

		$this->quotaRepository->expects($this->at(0))
			->method('GetQuotas')
			->with($this->equalTo($resourceId))
			->will($this->returnValue($resource1Quotas));;

		$rule = new QuotaRule($this->quotaRepository);
		$result = $rule->Validate($series);

		$this->assertFalse($result->IsValid(), 'first quotas was exceeded');
		$this->assertEquals($series, $quota1->ExceedsCalledWith);
		$this->assertNull($quota2->ExceedsCalledWith, 'should fail after first quota problem');
		$this->assertNull($quota4->ExceedsCalledWith);
	}
}

class TestQuota extends Quota
{
	/**
	 * @var ReservationSeries
	 */
	public $ExceedsCalledWith;

	/**
	 * @var bool
	 */
	public $ShouldExceed;
	
	public function __construct($quotaId, $shouldExceed = false)
	{
		$this->ShouldExceed = $shouldExceed;
		
		parent::__construct($quotaId);
	}

	public function ExceedsQuota($reservationSeries)
	{
		$this->ExceedsCalledWith = $reservationSeries;
		return $this->ShouldExceed;
	}
}
?>