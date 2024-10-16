<?php

require_once(ROOT_DIR . 'lib/Email/namespace.php');
require_once(ROOT_DIR . 'Domain/namespace.php');

class AccountCreationEmail
{
    public static function AccountCreationEmail(User $user, $userSession = null): EmailBuilder
    {
        $builder = new EmailBuilder;
        $userRepo = new UserRepository();
        $admins = $userRepo->GetApplicationAdmins();
        foreach ($admins as $admin) {
            $builder->AddTo($admin->EmailAddress, $admin->FullName);
        }
        
        $builder
            ->SubjectTranslation('UserAdded')
            ->Template('AccountCreation.tpl')
            ->LanguageCode(Configuration::Instance()->GetKey(ConfigKeys::LANGUAGE))
            ->Set('To', Configuration::Instance()->GetKey(ConfigKeys::ADMIN_EMAIL_NAME) 
                ? Configuration::Instance()->GetKey(ConfigKeys::ADMIN_EMAIL_NAME) 
                : 'Administrator')
            ->Set('FullName', $user->FullName())
            ->Set('EmailAddress', $user->EmailAddress())
            ->Set('Phone', $user->GetAttribute(UserAttribute::Phone))
            ->Set('Organization', $user->GetAttribute(UserAttribute::Organization))
            ->Set('Position', $user->GetAttribute(UserAttribute::Position))
            ->Set('CreatedBy', '');

        if ($userSession != null && $userSession->UserId != $user->Id()) {
            $builder->Set('CreatedBy', new FullName($userSession->FirstName, $userSession->LastName));
        }

        return $builder;
    }
}
