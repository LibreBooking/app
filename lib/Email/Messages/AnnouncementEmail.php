<?php

require_once(ROOT_DIR . 'lib/Email/namespace.php');
require_once(ROOT_DIR . 'Domain/namespace.php');

class AnnouncementEmail
{
    public static function BuilderFor($announcement, $sentBy, $to): EmailBuilder
    {
        $builder = new EmailBuilder;
        $builder
            ->SubjectTranslation('AnnouncementSubject', [new FullName($sentBy->FirstName, $sentBy->LastName)])
            ->AddTo($to->Email, new FullName($to->First, $to->Last))
            ->From($sentBy->Email, new FullName($sentBy->FirstName, $sentBy->LastName))
            ->Template('AnnouncementEmail.tpl')
            ->LanguageCode($to->Language)
            ->Set('AnnouncementText', $announcement);

        return $builder;
    }    
}
