<?php

require_once(ROOT_DIR . 'lib/Email/namespace.php');

class AccountCreationForUserEmail
{
    public static function BuilderFor(User $user, $password, $userSession = null): EmailBuilder
    {
        $builder = new EmailBuilder();
        $builder
            ->SubjectTranslation('GuestAccountCreatedSubject', [Configuration::Instance()->GetKey(ConfigKeys::APP_TITLE)])
            ->AddTo($user->EmailAddress(), $user->FullName())
            ->Template('AccountCreationForUser.tpl')
            ->LanguageCode(Configuration::Instance()->GetKey(ConfigKeys::LANGUAGE))
            ->Set('FullName', $user->FullName())
            ->Set('EmailAddress', $user->EmailAddress())
            ->Set('Phone', $user->GetAttribute(UserAttribute::Phone))
            ->Set('Organization', $user->GetAttribute(UserAttribute::Organization))
            ->Set('Position', $user->GetAttribute(UserAttribute::Position))
            ->Set('Password', $password)
            ->Set('AppTitle', Configuration::Instance()->GetKey(ConfigKeys::APP_TITLE))
            ->Set('ScriptUrl', Configuration::Instance()->GetScriptUrl())
            ->Set('CreatedBy', '');

        if ($userSession != null && $userSession->UserId != $user->Id()) {
            $builder->Set('CreatedBy', new FullName($userSession->FirstName, $userSession->LastName));
        }    
        return $builder;
    }
}
