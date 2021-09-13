<?php

require_once(ROOT_DIR . 'lib/Email/namespace.php');
require_once(ROOT_DIR . 'Domain/namespace.php');

class AnnouncementEmail extends EmailMessage
{
    /**
     * @var string
     */
    private $announcement;

    /**
     * @var UserSession
     */
    private $sentBy;

    /**
     * @var UserItemView
     */
    private $to;

    /**
     * @param string $announcement
     * @param UserSession $sentBy
     * @param UserItemView $to
     */
    public function __construct($announcement, $sentBy, $to)
    {
        parent::__construct($to->Language);
        $this->announcement = $announcement;
        $this->sentBy = $sentBy;
        $this->to = $to;
    }

    /**
     * @return array|EmailAddress[]|EmailAddress
     */
    public function To()
    {
        return new EmailAddress($this->to->Email, new FullName($this->to->First, $this->to->Last));
    }

    /**
     * @return string
     */
    public function Subject()
    {
        return $this->Translate('AnnouncementSubject', new FullName($this->sentBy->FirstName, $this->sentBy->LastName));
    }

    /**
     * @return string
     */
    public function Body()
    {
        $this->Set('AnnouncementText', $this->announcement);
        return $this->FetchTemplate('AnnouncementEmail.tpl');
    }

    public function From()
    {
        return new EmailAddress($this->sentBy->Email, new FullName($this->sentBy->FirstName, $this->sentBy->LastName));
    }
}
