<?php

require_once(ROOT_DIR . 'lib/Email/namespace.php');

class ReservationRequiresApprovalEmailAdmin extends ReservationCreatedEmailAdmin
{
    /**
     * @param UserDto $adminDto
     * @param User $reservationOwner
     * @param ReservationSeries $reservationSeries
     * @param IResource $primaryResource
     * @param IAttributeRepository $attributeRepository
     * @param IUserRepository $userRepository
     */
    public function __construct(UserDto $adminDto, User $reservationOwner, ReservationSeries $reservationSeries, IResource $primaryResource, IAttributeRepository $attributeRepository, IUserRepository $userRepository)
    {
        parent::__construct($adminDto, $reservationOwner, $reservationSeries, $primaryResource, $attributeRepository, $userRepository);
    }

    public function Subject()
    {
        return $this->Translate('ReservationApprovalAdminSubjectWithResource', [$this->resource->GetName()]);
    }
}
