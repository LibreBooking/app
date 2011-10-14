<?php
require_once(ROOT_DIR . 'Pages/Ajax/ReservationApprovalPage.php');
require_once(ROOT_DIR . 'Presenters/ReservationApprovalPresenter.php');

class ReservationApprovalPresenterTests extends TestBase
{
	/**
	 * @var IReservationApprovalPage|PHPUnit_Framework_MockObject_MockObject
	 */
	private $page;

	/**
	 * @var IUpdateReservationPersistenceService|PHPUnit_Framework_MockObject_MockObject
	 */
	private $persistence;

	/**
	 * @var IReservationHandler|PHPUnit_Framework_MockObject_MockObject
	 */
	private $handler;

	/**
	 * @var ReservationApprovalPresenter
	 */
	private $presenter;

	public function setup()
	{
		parent::setup();

		$this->page = $this->getMock('IReservationApprovalPage');
		$this->persistence = $this->getMock('IUpdateReservationPersistenceService');
		$this->handler = $this->getMock('IReservationHandler');

		$this->presenter = new ReservationApprovalPresenter($this->page, $this->persistence, $this->handler);
	}
	
	public function testLoadAndApprovesReservationSendingNotifications()
	{
		$referenceNumber = 'rn';

		$reservation = new ExistingReservationSeries();
		
		$this->page->expects($this->once())
			->method('GetReferenceNumber')
			->will($this->returnValue($referenceNumber));
		
		$this->persistence->expects($this->once())
			->method('LoadByReferenceNumber')
			->with($this->equalTo($referenceNumber))
			->will($this->returnValue($reservation));
					
		$this->handler->expects($this->once())
			->method('Handle')
			->with($this->equalTo($reservation), $this->equalTo($this->page))
			->will($this->returnValue(true));

		$this->page->expects($this->once())
			->method('SetResult')
			->with($this->equalTo(true));
		
		$this->presenter->PageLoad();
	}
}

?>