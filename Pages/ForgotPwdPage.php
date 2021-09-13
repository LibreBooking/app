<?php

require_once(ROOT_DIR . 'Pages/Page.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');

interface IForgotPwdPage extends IPage
{
    public function ResetClicked();
    public function ShowResetEmailSent($showResetEmailSent);

    public function GetEmailAddress();
    public function SetEnabled($enabled);
}

class ForgotPwdPage extends Page implements IForgotPwdPage
{
    private $_presenter = null;

    public function __construct()
    {
        parent::__construct('ForgotPassword');

        $this->_presenter = new ForgotPwdPresenter($this);
    }

    public function PageLoad()
    {
        $this->SetEnabled(true);
        $this->_presenter->PageLoad();

        $this->Display('forgot_pwd.tpl');
    }

    public function ResetClicked()
    {
        $reset = $this->GetForm(Actions::RESET);
        return !empty($reset);
    }

    public function GetEmailAddress()
    {
        return $this->GetForm(FormKeys::EMAIL);
    }

    public function ShowResetEmailSent($showResetEmailSent)
    {
        $this->Set('ShowResetEmailSent', $showResetEmailSent);
    }

    public function SetEnabled($enabled)
    {
        $this->Set('Enabled', $enabled);
    }
}
