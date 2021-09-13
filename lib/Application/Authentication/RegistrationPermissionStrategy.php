<?php

class RegistrationPermissionStrategy implements IRegistrationPermissionStrategy
{
    public function AddAccount(User $user)
    {
        $autoAssignCommand = new AutoAssignPermissionsCommand($user->Id());
        ServiceLocator::GetDatabase()->Execute($autoAssignCommand);
    }
}

class GuestReservationPermissionStrategy implements IRegistrationPermissionStrategy
{
    /**
     * @var IRequestedResourcePage
     */
    private $page;

    public function __construct(IRequestedResourcePage $page)
    {
        $this->page = $page;
    }

    public function AddAccount(User $user)
    {
        $autoAssignCommand = new AutoAssignGuestPermissionsCommand($user->Id(), $this->page->GetRequestedScheduleId());
        ServiceLocator::GetDatabase()->Execute($autoAssignCommand);
    }
}
