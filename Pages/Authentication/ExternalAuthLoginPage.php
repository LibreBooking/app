<?php

require_once(ROOT_DIR . 'Pages/Page.php');
require_once(ROOT_DIR . 'Pages/Authentication/ILoginBasePage.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');

class ExternalAuthLoginPage extends Page implements ILoginBasePage
{
    public $presenter;

    public function __construct()
    {
        $this->presenter = new ExternalAuthLoginPresenter($this, new WebAuthentication(PluginManager::Instance()->LoadAuthentication()), new Registration());
        parent::__construct('Login');
    }

    public function PageLoad()
    {
        $this->presenter->PageLoad();
    }

    /**
     * @return string
     */
    public function GetResumeUrl()
    {
        return $this->GetQuerystring(QueryStringKeys::REDIRECT);
    }

    /**
     * @return null|string
     */
    public function GetType()
    {
        return $this->GetQuerystring(QueryStringKeys::TYPE);
    }

    public function ShowError($messages)
    {
        $this->Set('Errors', $messages);
        $this->Display('ExternalAuth/external-login-error.tpl');
    }
}
