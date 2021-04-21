<?php

class RegistrationNotificationStrategy implements IRegistrationNotificationStrategy
{
	public function NotifyAccountCreated(User $user, $password)
	{
		if (Configuration::Instance()->GetKey(ConfigKeys::REGISTRATION_NOTIFY, new BooleanConverter()))
		{
			ServiceLocator::GetEmailService()->Send(new AccountCreationEmail($user,
																			 ServiceLocator::GetServer()->GetUserSession()));
		}
	}
}
