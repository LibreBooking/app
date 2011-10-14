<?php

class ReservationHandlerTests extends TestBase
{
	public function testHandlingReservationCreationDelegatesToServicesForValidationAndPersistenceAndNotification()
	{
		$persistenceService = $this->getMock('IReservationPersistenceService');
		$validationService = $this->getMock('IReservationValidationService');
		$notificationService = $this->getMock('IReservationNotificationService');
		$page = $this->getMock('IReservationSaveResultsPage');

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
			->method('ShowWarnings')
			->with($this->equalTo($validationResult->GetWarnings()));


		$handler = new ReservationHandler($persistenceService, $validationService, $notificationService);
		$handler->Handle($series, $page);

	}

	public function testPreventsPersistenceAndNotificationAndShowsFailedMessageWhenValidationFails()
	{
		$persistenceService = $this->getMock('IReservationPersistenceService');
		$validationService = $this->getMock('IReservationValidationService');
		$notificationService = $this->getMock('IReservationNotificationService');
		$page = $this->getMock('IReservationSaveResultsPage');
		
		$errorMessage1 = 'e1';
		$errorMessage2 = 'e2';
		$errors = array($errorMessage1, $errorMessage2);

		$builder = new ExistingReservationSeriesBuilder();
		$series = $builder->Build();

		$validationResult = new ReservationValidationResult(false, $errors);

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
			->method('ShowErrors')
			->with($this->equalTo($errors));
		
		$handler = new ReservationHandler($persistenceService, $validationService, $notificationService);
		$handler->Handle($series, $page);
	}
}
?>