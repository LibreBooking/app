<?php

/**
 * This file contains 1 classe and 1 interface:
 *  InstallPage, and IIinstallPage respectively.
 */
require_once(ROOT_DIR . 'Pages/Page.php');
require_once(ROOT_DIR . 'Presenters/InstallPresenter.php');

/**
 * Abstract interface for flexibility
 */
interface IInstallPage {

    /**
     * @abstract
     */
    public function SetInstallPasswordMissing($isMissing);

    /**
     * @abstract
     * @return string
     */
    public function GetInstallPassword();

    /**
     * @abstract
     */
    public function SetShowPasswordPrompt($showPasswordPrompt);

    /**
     * @abstract
     */
    public function SetShowInvalidPassword($showInvalidPassword);

    /**
     * @abstract
     */
    public function SetShowDatabasePrompt($showDatabasePrompt);

    /**
     * @abstract
     */
    public function SetDatabaseConfig($dbname, $dbuser, $dbhost);

    /**
     * @abstract
     * @return bool
     */
    public function RunningInstall();

    /**
     * @abstract
     * @return string
     */
    public function GetInstallUser();

    /**
     * @abstract
     * @return string
     */
    public function GetInstallUserPassword();

    /**
     * @abstract
     * @return bool
     */
    public function GetShouldCreateDatabase();

    /**
     * @abstract
     * @return bool
     */
    public function GetShouldCreateUser();

    /**
     * @abstract
     * @param $results array|InstallationResult[]
     * @return void
     */
    public function SetInstallResults($results);
}

/**
 * This class supports auto installation pages
 */
class InstallPage extends Page implements IInstallPage {

    /**
     * @var \InstallPresenter
     */
    private $presenter;

    public function __construct() {
        parent::__construct('Install', 1);

        $this->presenter = new InstallPresenter($this);
    }

    /**
     * Load data for page then display
     */
    public function PageLoad() {
        $this->presenter->PageLoad();   // Calling to class InstallPresenter's method - PageLoad()
        $this->Display('install.tpl');  // Calling to extended class Page's method - Display('')
    }

    public function SetInstallPasswordMissing($isMissing) {
        $this->Set('InstallPasswordMissing', $isMissing);
    }

    public function GetInstallPassword() {
        return $this->GetForm(FormKeys::INSTALL_PASSWORD);
    }

    public function SetShowPasswordPrompt($showPrompt) {
        $this->Set('ShowPasswordPrompt', $showPrompt);
    }

    public function SetShowInvalidPassword($showInvalidPassword) {
        $this->Set('ShowInvalidPassword', $showInvalidPassword);
    }

    public function SetShowDatabasePrompt($showDatabasePrompt) {
        $this->Set('ShowDatabasePrompt', $showDatabasePrompt);
    }

    /**
     * Set values for displayed template - install.tpl
     * @param string $dbname database name
     * @param string $dbuser mysql user for your database e.g phpScheduleIt
     * @param string $dbhost server address/name where mySql lives
     */
    public function SetDatabaseConfig($dbname, $dbuser, $dbhost) {
        $this->Set('dbname', $dbname);
        $this->Set('dbuser', $dbuser);
        $this->Set('dbhost', $dbhost);
    }

    public function RunningInstall() {
        $run_install = $this->GetForm('run_install');
        return !empty($run_install);
    }

    public function GetInstallUser() {
        return $this->GetForm(FormKeys::INSTALL_DB_USER);
    }

    public function GetInstallUserPassword() {
        return $this->GetForm(FormKeys::INSTALL_DB_PASSWORD);
    }

    public function GetShouldCreateDatabase() {
        $x = $this->GetForm('create_database');
        return isset($x) && $x == true;
    }

    public function GetShouldCreateUser() {
        $x = $this->GetForm('create_user');
        return isset($x) && $x == true;
    }

    public function GetShouldCreateSampleData() {
        $x = $this->GetForm('create_sample_data');
        return isset($x) && $x == true;
    }


    /**
     * Iterate results in array set status for display template
     * @param $results array|InstallationResult[]
     * @return void
     */
    public function SetInstallResults($results) {
        $failure = false;
        foreach ($results as $result) {
            if (!$result->WasSuccessful()) {
                $failure = true;
            }
        }
        // Set installation status
        $this->Set('InstallCompletedSuccessfully', !$failure);
        $this->Set('InstallFailed', $failure);
        $this->Set('installresults', $results);
    }

}

?>