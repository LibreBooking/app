<?php

class EditReservationPresenterTest extends TestBase
{
    /**
     * @var UserSession
     */
    private $user;

    private $userId;

    /**
     * @var IExistingReservationPage
     */
    private $page;

    /**
     * @var IReservationViewRepository
     */
    private $reservationViewRepository;

    /**
     * @var IReservationPreconditionService
     */
    private $preconditionService;

    /**
     * @var IReservationInitializerFactory
     */
    private $initializerFactory;

    /**
     * @var IReservationInitializer
     */
    private $initializer;

    public function setUp(): void
    {
        parent::setup();

        $this->user = $this->fakeServer->UserSession;
        $this->userId = $this->user->UserId;

        $this->page = $this->createMock('IExistingReservationPage');

        $this->initializerFactory = $this->createMock('IReservationInitializerFactory');
        $this->initializer = $this->createMock('IReservationInitializer');

        $this->preconditionService = $this->createMock('EditReservationPreconditionService');
        $this->reservationViewRepository = $this->createMock('IReservationViewRepository');
    }

    public function teardown(): void
    {
        parent::teardown();
    }

    public function testPullsReservationViewFromRepository()
    {
        $referenceNumber = '1234';

        $reservationView = new ReservationView();

        $this->page->expects($this->once())
            ->method('GetReferenceNumber')
            ->willReturn($referenceNumber);

        $this->reservationViewRepository->expects($this->once())
            ->method('GetReservationForEditing')
            ->with($referenceNumber)
            ->willReturn($reservationView);

        $this->preconditionService->expects($this->once())
            ->method('CheckAll')
            ->with($this->page, $this->user, $reservationView);

        $this->initializerFactory->expects($this->once())
            ->method('GetExistingInitializer')
            ->with($this->equalTo($this->page), $this->equalTo($reservationView))
            ->willReturn($this->initializer);

        $this->initializer->expects($this->once())
            ->method('Initialize');

        $presenter = new EditReservationPresenter($this->page, $this->initializerFactory, $this->preconditionService, $this->reservationViewRepository);

        $presenter->PageLoad();
    }
}
