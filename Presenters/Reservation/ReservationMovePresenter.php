<?php

require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'Pages/Ajax/ReservationMovePage.php');

class ReservationMovePresenter
{
    /**
     * @var IReservationMovePage
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
     * @var IResourceRepository
     */
    private $resourceRepository;

    /**
     * @var UserSession
     */
    private $userSession;

    public function __construct(
        IReservationMovePage $page,
        IUpdateReservationPersistenceService $persistenceService,
        IReservationHandler $handler,
        IResourceRepository $resourceRepository,
        UserSession $userSession
    ) {
        $this->page = $page;
        $this->persistenceService = $persistenceService;
        $this->handler = $handler;
        $this->resourceRepository = $resourceRepository;
        $this->userSession = $userSession;
    }

    public function PageLoad()
    {
        $referenceNumber = $this->page->GetReferenceNumber();
        $existingSeries = $this->persistenceService->LoadByReferenceNumber($referenceNumber);
        $existingSeries->UpdateBookedBy(ServiceLocator::GetServer()->GetUserSession());
        $existingSeries->ApplyChangesTo(SeriesUpdateScope::ThisInstance);

        $currentDuration = $existingSeries->CurrentInstance()->Duration();
        $newStart = Date::Parse($this->page->GetStartDate(), $this->userSession->Timezone);

        $difference = DateDiff::BetweenDates($currentDuration->GetBegin(), $newStart);

        $newDuration = new DateRange($newStart, $currentDuration->GetEnd()->ApplyDifference($difference));
        $existingSeries->UpdateDuration($newDuration);
        $this->AdjustResource($existingSeries);

        $this->handler->Handle($existingSeries, $this->page);
    }

    private function AdjustResource(ExistingReservationSeries $existingSeries)
    {
        $originalResourceId = $this->page->GetOriginalResourceId();
        $resourceId = $this->page->GetResourceId();

        if ($originalResourceId == $resourceId) {
            return;
        }

        $additionalResources = $existingSeries->AdditionalResources();
        $allResourceIds = $existingSeries->AllResourceIds();
        $newResource = $existingSeries->Resource();

        if (in_array($resourceId, $allResourceIds)) {
            $updatedAdditionalResources = [];

            foreach ($additionalResources as $resource) {
                if ($resourceId != $resource->GetId()) {
                    $updatedAdditionalResources[] = $resource;
                } else {
                    $newResource = $resource;
                }
            }

            $existingSeries->ChangeResources($updatedAdditionalResources);
        } else {
            $newResource = $this->resourceRepository->LoadById($resourceId);
        }

        $existingSeries->Update($existingSeries->UserId(), $newResource, $existingSeries->Title(), $existingSeries->Description(), $this->userSession);
    }
}
