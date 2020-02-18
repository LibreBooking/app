<?php

/**
 * Copyright 2011-2019 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */
class ReservationHandlerTests extends TestBase
{
	public function testHandlingReservationCreationDelegatesToServicesForValidationAndPersistenceAndNotification()
	{
		$persistenceService = $this->createMock('IReservationPersistenceService');
		$validationService = $this->createMock('IReservationValidationService');
		$notificationService = $this->createMock('IReservationNotificationService');
		$page = $this->createMock('IReservationSaveResultsView');

		$builder = new ExistingReservationSeriesBuilder();
		$series = $builder->Build();
		$instance = new Reservation($series, NullDateRange::Instance());
		$series->WithCurrentInstance($instance);

		$validationResult = new ReservationValidationResult();

		$validationService->expects($this->once())
						  ->method('Validate')
						  ->with($this->equalTo($series))
						  ->will($this->returnValue($validationResult));

		$persistenceService->expects($this->once())
						   ->method('Persist')
						   ->with($this->equalTo($series));

		$notificationService->expects($this->once())
							->method('Notify')
							->with($this->equalTo($series));

		$page->expects($this->once())
			 ->method('SetSaveSuccessfulMessage')
			 ->with($this->equalTo(true));

		$page->expects($this->once())
			 ->method('SetWarnings')
			 ->with($this->equalTo($validationResult->GetWarnings()));


		$handler = new ReservationHandler($persistenceService, $validationService, $notificationService);
		$handler->Handle($series, $page);

	}

	public function testPreventsPersistenceAndNotificationAndShowsFailedMessageWhenValidationFails()
	{
        $this->fakeConfig->SetSectionKey(ConfigSection::RESERVATION, ConfigKeys::RESERVATION_ALLOW_WAITLIST, true);
		$persistenceService = $this->createMock('IReservationPersistenceService');
		$validationService = $this->createMock('IReservationValidationService');
		$notificationService = $this->createMock('IReservationNotificationService');
		$page = $this->createMock('IReservationSaveResultsView');

		$errorMessage1 = 'e1';
		$errorMessage2 = 'e2';
		$errors = array($errorMessage1, $errorMessage2);

		$builder = new ExistingReservationSeriesBuilder();
		$series = $builder->Build();

        $validationResult = new ReservationValidationResult(false, $errors, null, false, array(), array(), true);

		$validationService->expects($this->once())
						  ->method('Validate')
						  ->with($this->equalTo($series))
						  ->will($this->returnValue($validationResult));

		$persistenceService->expects($this->never())
						   ->method('Persist');

		$notificationService->expects($this->never())
							->method('Notify');

		$page->expects($this->once())
			 ->method('SetSaveSuccessfulMessage')
			 ->with($this->equalTo(false));

		$page->expects($this->once())
			 ->method('SetErrors')
			 ->with($this->equalTo($errors));

        $page->expects($this->once())
			 ->method('SetCanJoinWaitList')
			 ->with($this->equalTo(true));

		$handler = new ReservationHandler($persistenceService, $validationService, $notificationService);
		$handler->Handle($series, $page);
	}

	public function testPreventsPersistenceAndNotificationAndShowsRetryMessageIfCanBeRetried()
	{
		$persistenceService = $this->createMock('IReservationPersistenceService');
		$validationService = $this->createMock('IReservationValidationService');
		$notificationService = $this->createMock('IReservationNotificationService');
		$page = new FakeReservationSavePage();
		$page->retryParameters = array();

		$errorMessage1 = 'e1';
		$errorMessage2 = 'e2';
		$errors = array($errorMessage1, $errorMessage2);

		$retryMessages = array('m1', 'm2');

		$retryParams = array(new ReservationRetryParameter('name', 'value'));

		$builder = new ExistingReservationSeriesBuilder();
		$series = $builder->Build();

		$validationResult = new ReservationValidationResult(false, $errors, null, true, $retryParams, $retryMessages);

		$validationService->expects($this->once())
						  ->method('Validate')
						  ->with($this->equalTo($series), $this->equalTo($page->retryParameters))
						  ->will($this->returnValue($validationResult));

		$persistenceService->expects($this->never())
						   ->method('Persist');

		$notificationService->expects($this->never())
							->method('Notify');

		$handler = new ReservationHandler($persistenceService, $validationService, $notificationService);
		$handler->Handle($series, $page);

		$this->assertFalse($page->saveSuccessful);
		$this->assertEquals($errors, $page->errors);
		$this->assertTrue($page->canBeRetried);
		$this->assertEquals($retryParams, $page->retryParameters);
		$this->assertEquals($retryMessages, $page->retryMessages);
	}

    public function testCanJoinWaitListIfTurnedOnAndNotRecurringSeriesAndOnlyErrorIsAvailability()
    {

        $persistenceService = $this->createMock('IReservationPersistenceService');
        $validationService = $this->createMock('IReservationValidationService');
        $notificationService = $this->createMock('IReservationNotificationService');
        $page = $this->createMock('IReservationSaveResultsView');

        $errorMessage1 = 'e1';
        $errorMessage2 = 'e2';
        $errors = array($errorMessage1, $errorMessage2);

        $builder = new ExistingReservationSeriesBuilder();
        $series = $builder->Build();

        $validationResult = new ReservationValidationResult(false, $errors, null, false, array(), array(), true);

        $validationService->expects($this->once())
            ->method('Validate')
            ->with($this->equalTo($series))
            ->will($this->returnValue($validationResult));

        $persistenceService->expects($this->never())
            ->method('Persist');

        $notificationService->expects($this->never())
            ->method('Notify');

        $page->expects($this->once())
            ->method('SetSaveSuccessfulMessage')
            ->with($this->equalTo(false));

        $page->expects($this->once())
            ->method('SetErrors')
            ->with($this->equalTo($errors));

        $handler = new ReservationHandler($persistenceService, $validationService, $notificationService);
        $handler->Handle($series, $page);
    }
}