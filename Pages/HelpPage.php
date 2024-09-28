<?php

require_once(ROOT_DIR . 'Pages/Page.php');

class HelpPage extends Page
{
    public function __construct()
    {
        parent::__construct('Help');
    }

    public function PageLoad()
    {
        $this->Set('RemindersPath', realpath(ROOT_DIR . 'Jobs/sendreminders.php'));
        $this->Set('AutoReleasePath', realpath(ROOT_DIR . 'Jobs/autorelease.php'));
        $this->Set('WaitListPath', realpath(ROOT_DIR . 'Jobs/sendwaitlist.php'));
        $this->Set('MissedCheckinPath', realpath(ROOT_DIR . 'Jobs/sendmissedcheckin.php'));
        $this->Set('ServerTimezone', date_default_timezone_get());

        $this->DisplayLocalized('support-and-credits.tpl');
    }
}
