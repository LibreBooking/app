<?php
require_once(ROOT_DIR . 'Presenters/ReservationHandler.php');

class ReservationApprovalPresenter
{
	/**
	 * @var IReservationApprovalPage
	 */
	private $page;

	/**
	 * @var \IUpdateReservationPersistenceService
	 */
	private $persistenceService;

	/**
	 * @var \IReservationHandler
	 */
	private $handler;

	public function __construct(
		IReservationApprovalPage $page,
		IUpdateReservationPersistenceService $persistenceService,
		IReservationHandler $handler)
	{
		$this->page = $page;
		$this->persistenceService = $persistenceService;
		$this->handler = $handler;
	}

	public function PageLoad()
	{
		$referenceNumber = $this->page->GetReferenceNumber();
		
		$series = $this->persistenceService->LoadByReferenceNumber($referenceNumber);
		$this->handler->Handle($series, $this->page);

		$this->page->SetResult(true);
	}
}
