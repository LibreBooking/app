<?php

require_once(ROOT_DIR . 'lib/Email/namespace.php');

class AccountActivationEmail
{
    public static function BuilderFor(User $user, $activationCode): EmailBuilder
    {
        $activationUrl = new Url(Configuration::Instance()->GetScriptUrl());
        $activationUrl
                ->Add(Pages::ACTIVATION)
                ->AddQueryString(QueryStringKeys::ACCOUNT_ACTIVATION_CODE, $activationCode);

        return (new EmailBuilder)
            ->SubjectTranslation('ActivateYourAccount')
            ->AddTo($user->EmailAddress(), $user->FullName())
            ->Template('AccountActivation.tpl')
            ->LanguageCode($user->Language())
            ->Set('FirstName', $user->FirstName())
            ->Set('EmailAddress', $user->EmailAddress())
            ->Set('ActivationUrl', $activationUrl);    
    }
}
