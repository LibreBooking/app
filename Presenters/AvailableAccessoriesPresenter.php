<?php

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/AccessoryAggregation.php');

class AvailableAccessoriesPresenter
{
    /**
     * @var IAvailableAccessoriesPage
     */
    private $page;
    /**
     * @var IAccessoryRepository
     */
    private $accessoryRepository;
    /**
     * @var IReservationViewRepository
     */
    private $reservationViewRepository;
    /**
     * @var UserSession
     */
    private $userSession;

    public function __construct(IAvailableAccessoriesPage $page, IAccessoryRepository $accessoryRepository, IReservationViewRepository $reservationViewRepository, UserSession $userSession)
    {
        $this->page = $page;
        $this->accessoryRepository = $accessoryRepository;
        $this->reservationViewRepository = $reservationViewRepository;
        $this->userSession = $userSession;
    }

    public function PageLoad()
    {
        $accessories = $this->accessoryRepository->LoadAll();

        $duration = DateRange::Create($this->page->GetStartDate() . ' ' . $this->page->GetStartTime(), $this->page->GetEndDate() . ' ' . $this->page->GetEndTime(), $this->userSession->Timezone);
        $accessoryReservations = $this->reservationViewRepository->GetAccessoriesWithin($duration);

        $aggregation = new AccessoryAggregation($accessories, $duration);

        foreach ($accessoryReservations as $accessoryReservation) {
            if ($this->page->GetReferenceNumber() != $accessoryReservation->GetReferenceNumber()) {
                $aggregation->Add($accessoryReservation);
            }
        }

        $realAvailability = [];

        foreach ($accessories as $accessory) {
            $id = $accessory->GetId();

            $available = $accessory->GetQuantityAvailable();
            if ($available != null) {
                $reserved = $aggregation->GetQuantity($id);
                $realAvailability[] = new AccessoryAvailability($id, max(0, $available - $reserved));
            } else {
                $realAvailability[] = new AccessoryAvailability($id, null);
            }
        }
        $this->page->BindAvailability($realAvailability);
    }
}
