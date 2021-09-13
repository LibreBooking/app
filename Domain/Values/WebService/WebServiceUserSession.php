<?php

require_once(ROOT_DIR . 'lib/Server/UserSession.php');
require_once(ROOT_DIR . 'Domain/Values/WebService/WebServiceExpiration.php');
require_once(ROOT_DIR . 'Domain/Values/WebService/WebServiceSessionToken.php');

class WebServiceUserSession extends UserSession
{
    public $SessionToken = '';
    public $SessionExpiration = '';

    public function __construct($id)
    {
        parent::__construct($id);
        $this->SessionToken = WebServiceSessionToken::Generate();
        $this->SessionExpiration = WebServiceExpiration::Create();
    }

    /**
     * @param UserSession $session
     * @return WebServiceUserSession
     */
    public static function FromSession(UserSession $session)
    {
        $webSession = new WebServiceUserSession($session->UserId);

        $webSession->FirstName = $session->FirstName;
        $webSession->LastName = $session->LastName;
        $webSession->Email = $session->Email;
        $webSession->Timezone = $session->Timezone;
        $webSession->HomepageId = $session->HomepageId;
        $webSession->IsAdmin = $session->IsAdmin;
        $webSession->IsGroupAdmin = $session->IsGroupAdmin;
        $webSession->IsResourceAdmin = $session->IsResourceAdmin;
        $webSession->IsScheduleAdmin = $session->IsScheduleAdmin;
        $webSession->LanguageCode = $session->LanguageCode;
        $webSession->PublicId = $session->PublicId;
        $webSession->ScheduleId = $session->ScheduleId;
        $webSession->Groups = $session->Groups;
        $webSession->AdminGroups = $session->AdminGroups;

        return $webSession;
    }

    public function ExtendSession()
    {
        $this->SessionExpiration = WebServiceExpiration::Create();
    }

    /**
     * @return bool
     */
    public function IsExpired()
    {
        return WebServiceExpiration::IsExpired($this->SessionExpiration);
    }
}
