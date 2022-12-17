<?php

require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');

class ReservationCheckinPresenter
{
    /**
     * @var IReservationCheckinPage
     */
    private $page;

    /**
     * @var IUpdateReservationPersistenceService
     */
    private $persistenceService;

    /**
     * @var IReservationHandler
     */
    private $handler;

    /**
     * @var UserSession
     */
    private $userSession;

    public function __construct(
        IReservationCheckinPage $page,
        IUpdateReservationPersistenceService $persistenceService,
        IReservationHandler $handler,
        UserSession $userSession
    ) {
        $this->page = $page;
        $this->persistenceService = $persistenceService;
        $this->handler = $handler;
        $this->userSession = $userSession;
    }

    public function PageLoad()
    {
        $referenceNumber = $this->page->GetReferenceNumber();
        $action = $this->page->GetAction();

        if ($action != ReservationAction::Checkin) {
            $action = ReservationAction::Checkout;
        }

        Log::Debug('User: %s, Checkin/out reservation with reference number %s, action %s', $this->userSession->UserId, $referenceNumber, $action);

        $reservationSeries = $this->persistenceService->LoadByReferenceNumber($referenceNumber);

        if ($action == ReservationAction::Checkin) {
            $reservationSeries->Checkin($this->userSession);
        } else {
            $reservationSeries->Checkout($this->userSession);
        }

        $this->handler->Handle($reservationSeries, $this->page);
    }
}
