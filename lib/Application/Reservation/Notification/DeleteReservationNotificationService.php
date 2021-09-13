<?php

require_once(ROOT_DIR . 'lib/Application/Reservation/Notification/IReservationNotificationService.php');

class DeleteReservationNotificationService extends ReservationNotificationService
{
    public function __construct(IUserRepository $userRepo, IAttributeRepository $attributeRepo)
    {
        $notifications = [];

        $notifications[] = new OwnerEmailDeletedNotification($userRepo, $attributeRepo);
        $notifications[] = new ParticipantDeletedEmailNotification($userRepo, $attributeRepo);
        $notifications[] = new AdminEmailDeletedNotification($userRepo, $userRepo, $attributeRepo);
        $notifications[] = new GuestDeletedEmailNotification($userRepo, $attributeRepo);

        parent::__construct($notifications);
    }
}
