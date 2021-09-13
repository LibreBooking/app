<?php

interface IRegistrationNotificationStrategy
{
    public function NotifyAccountCreated(User $user, $password);
}
