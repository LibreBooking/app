<?php

require_once(ROOT_DIR . 'lib/Email/namespace.php');
require_once(ROOT_DIR . 'Domain/namespace.php');

class ForgotPasswordEmail
{
    public static function BuilderFor(User $user, $temporaryPassword): EmailBuilder
    {
        return (new EmailBuilder)
            ->SubjectTranslation('ResetPasswordRequest')
            ->AddTo($user->EmailAddress(), $user->FullName())
            ->Template('ResetPassword.tpl')
            ->LanguageCode($user->Language())
            ->Set('TemporaryPassword', $temporaryPassword);
    }
}
