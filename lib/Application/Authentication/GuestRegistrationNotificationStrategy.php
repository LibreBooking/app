<?php

require_once(ROOT_DIR . 'lib/Email/Messages/GuestAccountCreationEmail.php');

class GuestRegistrationNotificationStrategy implements IRegistrationNotificationStrategy
{
    public function NotifyAccountCreated(User $user, $password)
    {
        ServiceLocator::GetEmailService()->Send(new GuestAccountCreationEmail($user, $password));
    }
}
