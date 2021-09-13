<?php

require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageThemePresenter.php');

class ManageThemePage extends ActionPage
{
    private $presenter;

    public function __construct()
    {
        parent::__construct('LookAndFeel', 1);

        $this->presenter = new ManageThemePresenter($this);
    }

    /**
     * @return void
     */
    public function ProcessAction()
    {
        $this->presenter->ProcessAction();
    }

    /**
     * @param $dataRequest string
     * @return void
     */
    public function ProcessDataRequest($dataRequest)
    {
        // no-op
    }

    /**
     * @return void
     */
    public function ProcessPageLoad()
    {
        $this->Display('Admin/Configuration/change_theme.tpl');
    }

    /**
     * @return null|UploadedFile
     */
    public function GetLogoFile()
    {
        return $this->server->GetFile(FormKeys::LOGO_FILE);
    }

    /**
     * @return null|UploadedFile
     */
    public function GetCssFile()
    {
        return $this->server->GetFile(FormKeys::CSS_FILE);
    }

    /**
     * @return null|UploadedFile
     */
    public function GetFaviconFile()
    {
        return $this->server->GetFile(FormKeys::FAVICON_FILE);
    }
}
