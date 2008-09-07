<?php
require_once(ROOT_DIR . 'Pages/IPage.php');
require_once(ROOT_DIR . 'Pages/Pages.php');
require_once(ROOT_DIR . 'lib/Common/SmartyPage.php');
require_once(ROOT_DIR . 'lib/Server/namespace.php');
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Database/MDB2/namespace.php');

class Page implements IPage
{
	/**
	 * @var SmartyPage
	 */
	protected $smarty = null;
	
	/**
	 * @var Server
	 */
	protected $server = null;
	
	public function __construct($titleKey, $pageDepth = 0)
	{
		$path = str_repeat('../', $pageDepth);
		
		$this->server = ServiceLocator::GetServer();
		$resources = Resources::GetInstance();
	
		$this->smarty =& new SmartyPage($resources, $path);
		
		$userSession = ServiceLocator::GetServer()->GetUserSession();
		
		$this->smarty->assign('Charset', $resources->Charset);
		$this->smarty->assign('CurrentLanguage', $resources->CurrentLanguage);
		$this->smarty->assign('Title', 'phpScheduleIt - ' . $resources->GetString($titleKey));
		$this->smarty->assign('CalendarJSFile', $resources->CalendarLanguageFile);
		$this->smarty->assign('AllowRss', Configuration::Instance()->GetKey(ConfigKeys::ALLOW_RSS));
		$this->smarty->assign('LoggedIn', !is_null($userSession));
		$this->smarty->assign('Version', Configuration::Instance()->GetKey(ConfigKeys::VERSION));
		$this->smarty->assign('Path', $path);
		$this->smarty->assign('ScriptUrl', Configuration::Instance()->GetKey(ConfigKeys::SCRIPT_URL));
		$this->smarty->assign('UserName', !is_null($userSession) ? $userSession->FirstName : '');
		$this->smarty->assign('DisplayWelcome', $this->DisplayWelcome());
		$this->smarty->assign('UserId', $userSession->UserId);
	}
	
	public function Redirect($url)
	{
		header("Location: $url");
		die();
	}
	
	public function DisplayWelcome()
	{
		return true;
	}
	
	/**
	 * Returns whether or not the user has been authenticated
	 *
	 * @return bool
	 */
	public function IsAuthenticated()
	{
		return !is_null($this->server->GetSession(SessionKeys::USER_SESSION));
	}
	
	/**
	 * Returns whether or not the page is currently posting back to itself
	 *
	 * @return bool
	 */
	public function IsPostBack()
	{
		return !empty($_POST);
	}
	
	/**
	 * Registers a Validator with the page
	 *
	 * @param unknown_type $validatorId
	 * @param IValidator $validator
	 */
	public function RegisterValidator($validatorId, $validator)
	{
		$this->smarty->Validators->Register($validatorId, $validator);
	}
	
	/**
	 * Whether or not the current page passess all registered validators
	 *
	 * @return bool
	 */
	public function IsValid()
	{
		return $this->smarty->IsValid();
	}
}
?>