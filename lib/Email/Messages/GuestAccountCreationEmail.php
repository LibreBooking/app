<?php

require_once(ROOT_DIR . 'lib/Email/namespace.php');

class GuestAccountCreationEmail
{
    public static function BuilderFor(User $user, $password): EmailBuilder
    {
        return (new EmailBuilder)
            ->SubjectTranslation('GuestAccountCreatedSubject', [Configuration::Instance()->GetKey(ConfigKeys::APP_TITLE)])
            ->AddTo($user->EmailAddress(), $user->FullName())
            ->Template('GuestAccountCreation.tpl')
            ->LanguageCode($user->Language())
            ->Set('EmailAddress', $user->EmailAddress())
            ->Set('Password', $password);
    }
}
