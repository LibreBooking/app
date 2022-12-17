<?php

class ResourceAdminManageReservationsService extends ManageReservationsService implements IManageReservationsService
{
    /**
     * @var IReservationViewRepository
     */
    private $reservationViewRepository;

    /**
     * @var IUserRepository
     */
    private $userRepository;

    /**
     * @param IReservationViewRepository $reservationViewRepository
     * @param IUserRepository $userRepository
     * @param IReservationAuthorization $authorization
     * @param IReservationHandler|null $reservationHandler
     * @param IUpdateReservationPersistenceService|null $persistenceService
     */
    public function __construct(
        IReservationViewRepository $reservationViewRepository,
        IUserRepository $userRepository,
        IReservationAuthorization $authorization,
        $reservationHandler = null,
        $persistenceService = null
    ) {
        parent::__construct($reservationViewRepository, $authorization, $reservationHandler, $persistenceService);

        $this->reservationViewRepository = $reservationViewRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param $pageNumber int
     * @param $pageSize int
     * @param null|string $sortField
     * @param null|string $sortDirection
     * @param $filter ReservationFilter
     * @param $user UserSession
     * @return PageableData|ReservationItemView[]
     */
    public function LoadFiltered($pageNumber, $pageSize, $sortField, $sortDirection, $filter, $user)
    {
        $groupIds = [];
        $groups = $this->userRepository->LoadGroups($user->UserId, RoleLevel::RESOURCE_ADMIN);
        foreach ($groups as $group) {
            $groupIds[] = $group->GroupId;
        }

        $filter->_And(new SqlFilterIn(new SqlFilterColumn(TableNames::RESOURCES, ColumnNames::RESOURCE_ADMIN_GROUP_ID), $groupIds));
        return $this->reservationViewRepository->GetList($pageNumber, $pageSize, $sortField, $sortDirection, $filter->GetFilter());
    }
}
