<?php

require_once(ROOT_DIR . 'lib/Email/namespace.php');

class AccountDeletedEmail
{
    public static function BuilderFor(User $deletedUser, UserDto $to, UserSession $userSession): EmailBuilder
    {
        return (new EmailBuilder)
            ->SubjectTranslation('UserDeleted', [
                $deletedUser->FullName(), 
                new FullName($userSession->FirstName, $userSession->LastName)
                ])
            ->AddTo($to->EmailAddress(), $to->FullName())
            ->Template('AccountDeleted.tpl')
            ->LanguageCode($to->LanguageCode)
            ->Set('UserFullName', $deletedUser->FullName())
            ->Set('AdminFullName', new FullName($userSession->FirstName, $userSession->LastName));
    }
}
