<?php

require_once(ROOT_DIR . 'WebServices/SchedulesWebService.php');

class SchedulesWebServiceTests extends TestBase
{
	/**
	 * @var SchedulesWebService
	 */
	private $service;

	/**
	 * @var FakeRestServer
	 */
	private $server;

	/**
	 * @var IScheduleRepository
	 */
	private $scheduleRepository;

	/**
	 * @var IPrivacyFilter
	 */
	private $privacyFilter;

	public function setUp(): void
	{
		parent::setup();

		$this->server = new FakeRestServer();
		$this->scheduleRepository = $this->createMock('IScheduleRepository');
		$this->privacyFilter = $this->createMock('IPrivacyFilter');

		$this->service = new SchedulesWebService($this->server, $this->scheduleRepository, $this->privacyFilter);
	}

	public function testGetsAllSchedules()
	{
		$schedules = array(new FakeSchedule());

		$this->scheduleRepository->expects($this->once())
				->method('GetAll')
				->will($this->returnValue($schedules));

		$this->service->GetSchedules();

		$expectedResponse = new SchedulesResponse($this->server, $schedules);
		$this->assertEquals($expectedResponse, $this->server->_LastResponse);
	}

	public function testGetsScheduleById()
	{
		$scheduleId = 89181;

		$schedule = new FakeSchedule($scheduleId);
		$layout = $this->createMock('IScheduleLayout');

		$layout->expects($this->any())
				->method('GetLayout')
				->with($this->anything())
				->will($this->returnValue(array()));

		$this->scheduleRepository->expects($this->once())
				->method('LoadById')
				->with($this->equalTo($scheduleId))
				->will($this->returnValue($schedule));

		$this->scheduleRepository->expects($this->once())
				->method('GetLayout')
				->with($this->equalTo($scheduleId),
					   $this->equalTo(new ScheduleLayoutFactory($this->server->GetSession()->Timezone)))
				->will($this->returnValue($layout));

		$this->service->GetSchedule($scheduleId);

		$expectedResponse = new ScheduleResponse($this->server, $schedule, $layout);
		$this->assertEquals($expectedResponse, $this->server->_LastResponse);
	}

	public function testWhenScheduleNotFound()
	{
		$scheduleId = 89181;
		$this->scheduleRepository->expects($this->once())
				->method('LoadById')
				->with($this->equalTo($scheduleId))
				->will($this->returnValue(null));

		$this->service->GetSchedule($scheduleId);

		$this->assertEquals(RestResponse::NotFound(), $this->server->_LastResponse);
	}

	public function testScheduleResponseReturnsLayoutForEachDayOfWeek()
	{
		$schedule = new FakeSchedule();
		$layout = $this->createMock('IScheduleLayout');
		$timezone = $this->server->GetSession()->Timezone;

		$date1 = Date::Now()->ToTimezone($timezone);
		$date2 = $date1->AddDays(1);
		$date3 = $date1->AddDays(2);
		$date4 = $date1->AddDays(3);
		$date5 = $date1->AddDays(4);
		$date6 = $date1->AddDays(5);
		$date7 = $date1->AddDays(6);

		$periods1 = array(new SchedulePeriod($date1, $date1));
		$periods2 = array(new SchedulePeriod($date2, $date2));
		$periods3 = array(new SchedulePeriod($date3, $date3));
		$periods4 = array(new SchedulePeriod($date4, $date4));
		$periods5 = array(new SchedulePeriod($date5, $date5));
		$periods6 = array(new SchedulePeriod($date6, $date6));
		$periods7 = array(new SchedulePeriod($date7, $date7));

		$layout->expects($this->at(0))
				->method('GetLayout')
				->with($this->equalTo($date1))
				->will($this->returnValue($periods1));
		$layout->expects($this->at(1))
				->method('GetLayout')
				->with($this->equalTo($date2))
				->will($this->returnValue($periods2));
		$layout->expects($this->at(2))
				->method('GetLayout')
				->with($this->equalTo($date3))
				->will($this->returnValue($periods3));
		$layout->expects($this->at(3))
				->method('GetLayout')
				->with($this->equalTo($date4))
				->will($this->returnValue($periods4));
		$layout->expects($this->at(4))
				->method('GetLayout')
				->with($this->equalTo($date5))
				->will($this->returnValue($periods5));
		$layout->expects($this->at(5))
				->method('GetLayout')
				->with($this->equalTo($date6))
				->will($this->returnValue($periods6));
		$layout->expects($this->at(6))
				->method('GetLayout')
				->with($this->equalTo($date7))
				->will($this->returnValue($periods7));

		$response = new ScheduleResponse($this->server, $schedule, $layout);

		$this->assertEquals(array(new SchedulePeriodResponse($periods1[0])), $response->periods[$date1->Weekday()]);
		$this->assertEquals(array(new SchedulePeriodResponse($periods2[0])), $response->periods[$date2->Weekday()]);
		$this->assertEquals(array(new SchedulePeriodResponse($periods3[0])), $response->periods[$date3->Weekday()]);
		$this->assertEquals(array(new SchedulePeriodResponse($periods4[0])), $response->periods[$date4->Weekday()]);
		$this->assertEquals(array(new SchedulePeriodResponse($periods5[0])), $response->periods[$date5->Weekday()]);
		$this->assertEquals(array(new SchedulePeriodResponse($periods6[0])), $response->periods[$date6->Weekday()]);
		$this->assertEquals(array(new SchedulePeriodResponse($periods7[0])), $response->periods[$date7->Weekday()]);
	}
}
