<?php
require_once(ROOT_DIR . 'Presenters/ReservationPresenter.php');
require_once(ROOT_DIR . 'Pages/ReservationPage.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

class NewReservationPresenterTests extends TestBase
{
	/**
	 * @var UserSession
	 */
	private $_user;

	/**
	 * @var int
	 */
	private $_userId;

	public function setup()
	{
		parent::setup();

		$this->_user = $this->fakeServer->UserSession;
		$this->_userId = $this->_user->UserId;
	}

	public function teardown()
	{
		parent::teardown();
	}
	
	public function testPageLoadValidatesAllPreconditionsAndGetsReservationInitializerAndInitializes()
	{
		$page = $this->getMock('INewReservationPage');
		
		$reservationPreconditionService = $this->getMock('INewReservationPreconditionService');
		$reservationPreconditionService->expects($this->once())
			->method('CheckAll')
			->with($this->equalTo($page), $this->equalTo($this->_user));
			
		$reservationInitializerFactory = $this->getMock('IReservationInitializerFactory');
		$initializer = $this->getMock('IReservationInitializer');
		
		$reservationInitializerFactory->expects($this->once())
			->method('GetNewInitializer')
			->with($this->equalTo($page))
			->will($this->returnValue($initializer));
		
		$initializer->expects($this->once())
			->method('Initialize');
			
		$presenter = new ReservationPresenter($page, $reservationInitializerFactory, $reservationPreconditionService);
		$presenter->PageLoad();
	}
}
?>