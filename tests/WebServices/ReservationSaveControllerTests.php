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

require_once(ROOT_DIR . 'WebServices/Controllers/ReservationSaveController.php');

class ReservationSaveControllerTests extends TestBase
{
	/**
	 * @var ReservationSaveController
	 */
	private $controller;

	/**
	 * @var IReservationPresenterFactory
	 */
	private $presenterFactory;

	public function setup()
	{
		parent::setup();

		$this->presenterFactory = $this->getMock('IReservationPresenterFactory');
		$this->controller = new ReservationSaveController($this->presenterFactory);
	}

	public function testUsesPresenterToCreateReservation()
	{
		$reservation = new TestReservation();
		$presenter = $this->getMock('IReservationSavePresenter');

		$request = new ReservationRequest();
		$request->resourceId = 1;
		$request->startDateTime = '2012-04-05 01:01:01';
		$request->endDateTime = '2012-04-05 01:01:01';
		$session = new FakeWebServiceUserSession(123);
		$facade = new ReservationRequestResponseFacade($request, $session);

		$this->presenterFactory->expects($this->once())
				->method('Create')
				->with($this->equalTo($facade), $this->equalTo($session))
				->will($this->returnValue($presenter));

		$presenter->expects($this->once())
				->method('BuildReservation')
				->will($this->returnValue($reservation));

		$presenter->expects($this->once())
				->method('HandleReservation')
				->with($this->equalTo($reservation));

		$result = $this->controller->Create($request, $session);

		$expectedResult = new ReservationControllerResult($facade->ReferenceNumber(), $facade->Errors());
		$this->assertEquals($expectedResult, $result);
	}

	public function testUpdatesExistingReservation()
	{
		$reservation = new TestReservation();
		$presenter = $this->getMock('IReservationSavePresenter');
		$referenceNumber = '123';
		$updateScope = SeriesUpdateScope::FullSeries;

		$request = new ReservationRequest();
		$request->resourceId = 1;
		$request->startDateTime = '2012-04-05 01:01:01';
		$request->endDateTime = '2012-04-05 01:01:01';
		$session = new FakeWebServiceUserSession(123);
		$facade = new ReservationUpdateRequestResponseFacade($request, $session, $referenceNumber, $updateScope);

		$this->presenterFactory->expects($this->once())
				->method('Update')
				->with($this->equalTo($facade), $this->equalTo($session))
				->will($this->returnValue($presenter));

		$presenter->expects($this->once())
				->method('BuildReservation')
				->will($this->returnValue($reservation));

		$presenter->expects($this->once())
				->method('HandleReservation')
				->with($this->equalTo($reservation));

		$result = $this->controller->Update($request, $session, $referenceNumber, $updateScope);

		$expectedResult = new ReservationControllerResult($facade->ReferenceNumber(), $facade->Errors());
		$this->assertEquals($expectedResult, $result);
	}

	public function testFacadeProvidesDataFromRequestAndCollectsResponses()
	{
		$session = new FakeWebServiceUserSession(123);
		$timezone = 'America/Chicago';
		$session->Timezone = $timezone;

		$request = new ReservationRequest();

		$endDate = Date::Parse('2012-11-20 05:30', 'UTC');
		$endDateUserTz = $endDate->ToTimezone($timezone);
		$startDate = Date::Parse('2012-11-18 02:30', 'UTC');
		$startDateUserTz = $startDate->ToTimezone($timezone);
		$repeatTerminationDate = Date::Parse('2012-12-13', 'UTC');
		$repeatTerminationUserTz = $repeatTerminationDate->ToTimezone($timezone);

		$accessoryId = 8912;
		$quantity = 1232;
		$attributeId = 3393;
		$attributeValue = '23232';
		$description = 'reservation description';
		$invitees = array(9,8);
		$participants = array(99,88);
		$repeatInterval = 1;
		$repeatMonthlyType = null;
		$repeatType = RepeatType::Weekly;
		$repeatWeekdays = array(0,4,5);
		$resourceId = 122;
		$resources = array(22,23,33);
		$title = 'reservation title';
		$userId = 1;

		$request->accessories = array(new ReservationAccessoryRequest($accessoryId, $quantity));
		$request->attributes = array(new AttributeValueRequest($attributeId, $attributeValue));
		$request->description = $description;
		$request->endDateTime = $endDate->ToIso();
		$request->invitees = $invitees;
		$request->participants = $participants;
		$request->repeatInterval = $repeatInterval;
		$request->repeatMonthlyType = $repeatMonthlyType;
		$request->repeatType = $repeatType;
		$request->repeatWeekdays = $repeatWeekdays;
		$request->repeatTerminationDate = $repeatTerminationDate->ToIso();
		$request->resourceId = $resourceId;
		$request->resources = $resources;
		$request->startDateTime = $startDate->ToIso();
		$request->title = $title;
		$request->userId = $userId;

		$facade = new ReservationRequestResponseFacade($request, $session);

		$referenceNumber = uniqid();
		$errors = array('error', 'error2');

		$facade->SetReferenceNumber($referenceNumber);
		$facade->ShowErrors($errors);

		$accessories = array(AccessoryFormElement::Create($accessoryId, $quantity));
		$attributes = array(new AttributeFormElement($attributeId, $attributeValue));

		$this->assertEquals($accessories, $facade->GetAccessories());
		$this->assertEquals(null, $facade->GetAttachment());
		$this->assertEquals($attributes, $facade->GetAttributes());
		$this->assertEquals($description, $facade->GetDescription());
		$this->assertEquals($endDateUserTz->Format('Y-m-d'), $facade->GetEndDate());
		$this->assertEquals($endDateUserTz->Format('H:i'), $facade->GetEndTime());
		$this->assertEquals($invitees, $facade->GetInvitees());
		$this->assertEquals($participants, $facade->GetParticipants());
		$this->assertEquals($repeatInterval, $facade->GetRepeatInterval());
		$this->assertEquals($repeatMonthlyType, $facade->GetRepeatMonthlyType());
		$this->assertEquals($repeatType, $facade->GetRepeatType());
		$this->assertEquals($repeatWeekdays, $facade->GetRepeatWeekdays());
		$this->assertEquals($repeatTerminationUserTz->Format('Y-m-d'), $facade->GetRepeatTerminationDate());
		$this->assertEquals($resourceId, $facade->GetResourceId());
		$this->assertEquals($resources, $facade->GetResources());
		$this->assertEquals($startDateUserTz->Format('Y-m-d'), $facade->GetStartDate());
		$this->assertEquals($startDateUserTz->Format('H:i'), $facade->GetStartTime());
		$this->assertEquals($title, $facade->GetTitle());
		$this->assertEquals($userId, $facade->GetUserId());

		$this->assertEquals($referenceNumber, $facade->ReferenceNumber());
		$this->assertEquals($errors, $facade->Errors());

	}
}

?>