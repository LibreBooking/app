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

		Log::Debug('User: %s, Approving reservation with reference number %s', $referenceNumber);

		$series = $this->persistenceService->LoadByReferenceNumber($referenceNumber);
		$series->Approve(ServiceLocator::GetServer()->GetUserSession());
		$this->handler->Handle($series, $this->page);

		$this->page->SetSaveSuccessfulMessage(true);
	}
}

?>