<?php

/**
 * Abstract/parent class only
 */
require_once(ROOT_DIR . 'Pages/IPage.php');
require_once(ROOT_DIR . 'Pages/Pages.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Server/namespace.php');
require_once(ROOT_DIR . 'lib/Config/namespace.php');

/**
 * An abstract class is a class that is declared abstract—it may or may not include abstract methods.
 * Abstract classes cannot be instantiated, but they can be subclassed.
 * If a class includes abstract methods, the class itself must be declared abstract
 * An abstract method is a method that is declared without an implementation (without braces, and followed by a semicolon), like this:
 * abstract void moveTo(double deltaX, double deltaY);
 */
abstract class Page implements IPage {

    /**
     * @var SmartyPage
     */
    protected $smarty = null;

    /**
     * @var Server
     */
    protected $server = null;
    protected $path;

    protected function __construct($titleKey = '', $pageDepth = 0) {
        $this->path = str_repeat('../', $pageDepth);
        /**
         * Get Server object
         */
        $this->server = ServiceLocator::GetServer();
        $resources = Resources::GetInstance();

        /**
         * SmartyPage is an extension of external Smarty class
         */
        $this->smarty = new SmartyPage($resources, $this->path);

        $userSession = ServiceLocator::GetServer()->GetUserSession();

        $this->smarty->assign('Charset', $resources->Charset);
        $this->smarty->assign('CurrentLanguage', $resources->CurrentLanguage);
        $this->smarty->assign('HtmlLang', $resources->HtmlLang);
        $this->smarty->assign('Title', 'phpScheduleIt - ' . $resources->GetString($titleKey));
        $this->smarty->assign('CalendarJSFile', $resources->CalendarLanguageFile);
        $this->smarty->assign('AllowRss', Configuration::Instance()->GetKey(ConfigKeys::ALLOW_RSS));
        $this->smarty->assign('LoggedIn', $userSession->IsLoggedIn());
        $this->smarty->assign('Version', Configuration::VERSION);
        $this->smarty->assign('Path', $this->path);
        $this->smarty->assign('ScriptUrl', Configuration::Instance()->GetKey(ConfigKeys::SCRIPT_URL));
        $this->smarty->assign('UserName', !is_null($userSession) ? $userSession->FirstName : '');
        $this->smarty->assign('DisplayWelcome', $this->DisplayWelcome());
        $this->smarty->assign('UserId', $userSession->UserId);
        $this->smarty->assign('CanViewAdmin', $userSession->IsAdmin);
    }

    protected function SetTitle($title) {
        $this->smarty->assign('Title', $title);
    }

    public function Redirect($url) {
        if (!StringHelper::StartsWith($url, $this->path)) {
            $url = $this->path . $url;
        }
        header("Location: $url");
        die();
    }

    public function RedirectToError($errorMessageId, $lastPage = '') {
        if (empty($lastPage)) {
            $lastPage = $this->GetLastPage();
        }

        $errorPageUrl = sprintf("%serror.php?%s=%s&%s=%s", $this->path, QueryStringKeys::MESSAGE_ID, $errorMessageId, QueryStringKeys::REDIRECT, urlencode($lastPage));
        $this->Redirect($errorPageUrl);
    }

    public function GetLastPage($defaultPage = '') {
        $referer = getenv("HTTP_REFERER");
        if (empty($referer)) {
            return empty($defaultPage) ? Pages::LOGIN : $defaultPage;
        }

        $scriptUrl = Configuration::Instance()->GetScriptUrl();
        $page = str_ireplace($scriptUrl, '', $referer);
        return ltrim($page, '/');
    }

    public function DisplayWelcome() {
        return true;
    }

    /**
     * Returns whether or not the user has been authenticated
     *
     * @return bool
     */
    public function IsAuthenticated() {
        return!is_null($this->server->GetUserSession()) && $this->server->GetUserSession()->IsLoggedIn();
    }

    /**
     * Returns whether or not the page is currently posting back to itself
     *
     * @return bool
     */
    public function IsPostBack() {
        return!empty($_POST);
    }

    /**
     * Registers a Validator with the page
     *
     * @param unknown_type $validatorId
     * @param IValidator $validator
     */
    public function RegisterValidator($validatorId, $validator) {
        $this->smarty->Validators->Register($validatorId, $validator);
    }

    /**
     * Whether or not the current page is valid when checked against all registered validators
     *
     * @return bool
     */
    public function IsValid() {
        return $this->smarty->IsValid();
    }

    /**
     * @param string $var
     * @param string $value
     * @return void
     */
    public function Set($var, $value) {
        $this->smarty->assign($var, $value);
    }

    protected function GetVar($var) {
        return $this->smarty->getTemplateVars($var);
    }

    /**
     * Get the current form(s) on this server
     * @param string $var
     * @return null|string
     */
    protected function GetForm($var) {

        return $this->server->GetForm($var);
    }

    /**
     * @param string $key
     * @return null|string
     */
    protected function GetQuerystring($key) {
        return $this->server->GetQuerystring($key);
    }

    /**
     * @param string $objectToSerialize
     * @param string|null $error
     * @return void
     */
    protected function SetJson($objectToSerialize, $error = null) {
        header('Content-type: application/json');

        if (empty($error)) {
            $this->Set('data', json_encode($objectToSerialize));
        } else {
            $this->Set('error', json_encode($error));
        }
        $this->smarty->display('json_data.tpl');
    }

    /**
     * A template file to be displayed
     * @param string $templateName
     */
    protected function Display($templateName) {
        $this->smarty->display($templateName);
    }

}

?>