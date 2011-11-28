<?php

/**
 *
 */
require_once(ROOT_DIR . 'Presenters/Installer.php');
require_once(ROOT_DIR . 'Presenters/MySqlScript.php');
require_once(ROOT_DIR . 'Presenters/InstallationResult.php');

/**
 * Installation Presenter class
 */
class InstallPresenter {

    /**
     * @var \IInstallPage
     */
    private $page;

    const VALIDATED_INSTALL = 'validated_install';

    public function __construct(IInstallPage $page) {
        //ServiceLocator::GetServer()->SetSession(SessionKeys::INSTALLATION, null);
        $this->page = $page;
    }

    /**
     * Get and Set data to be process by template engine
     * @return type
     */
    public function PageLoad() {
        if ($this->page->RunningInstall()) {
            $this->RunInstall();
            return;
        }

        $dbname = Configuration::Instance()->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_NAME);
        $dbuser = Configuration::Instance()->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_USER);
        $dbhost = Configuration::Instance()->GetSectionKey(ConfigSection::DATABASE, ConfigKeys::DATABASE_HOSTSPEC);

        $this->page->SetDatabaseConfig($dbname, $dbuser, $dbhost);

        $this->CheckForInstallPasswordInConfig();
        $this->CheckForInstallPasswordProvided();
        $this->CheckForAuthentication();
    }

    public function CheckForInstallPasswordInConfig() {
        $installPassword = Configuration::Instance()->GetKey(ConfigKeys::INSTALLATION_PASSWORD);

        if (empty($installPassword)) {
            $this->page->SetInstallPasswordMissing(true);
            return;
        }

        $this->page->SetInstallPasswordMissing(false);
    }

    private function CheckForInstallPasswordProvided() {
        if ($this->IsAuthenticated()) {
            return;
        }

        $installPassword = $this->page->GetInstallPassword();

        if (empty($installPassword)) {
            $this->page->SetShowPasswordPrompt(true);
            return;
        }

        $validated = $this->Validate($installPassword);
        if (!$validated) {
            $this->page->SetShowPasswordPrompt(true);
            $this->page->SetShowInvalidPassword(true);
            return;
        }

        $this->page->SetShowPasswordPrompt(false);
        $this->page->SetShowInvalidPassword(false);
    }

    private function CheckForAuthentication() {
        if ($this->IsAuthenticated()) {
            $this->page->SetShowDatabasePrompt(true);
            return;
        }

        $this->page->SetShowDatabasePrompt(false);
    }

    private function IsAuthenticated() {
        return ServiceLocator::GetServer()->GetSession(SessionKeys::INSTALLATION) == self::VALIDATED_INSTALL;
    }

    private function Validate($installPassword) {
        $validated = $installPassword == Configuration::Instance()->GetKey(ConfigKeys::INSTALLATION_PASSWORD);

        if ($validated) {
            ServiceLocator::GetServer()->SetSession(SessionKeys::INSTALLATION, self::VALIDATED_INSTALL);
        } else {
            ServiceLocator::GetServer()->SetSession(SessionKeys::INSTALLATION, null);
        }

        return $validated;
    }

    private function RunInstall() {
        $install = new Installer($this->page->GetInstallUser(), $this->page->GetInstallUserPassword());

        $results = $install->InstallFresh($this->page->GetShouldCreateDatabase(), $this->page->GetShouldCreateUser(), $this->page->GetShouldCreateSampleData());

        $this->page->SetInstallResults($results);
    }

}
?>
