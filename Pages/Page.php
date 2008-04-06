<?php
require_once(ROOT_DIR . 'Pages/IPage.php');
require_once(ROOT_DIR . 'lib/Common/SmartyPage.php');
require_once(ROOT_DIR . 'lib/Server/namespace.php');
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Database/MDB2/namespace.php');

class Page implements IPage
{
	protected $smarty = null;
	protected $server = null;
	
	public function __construct($title, $pageDepth = 0)
	{
		$path = str_repeat('../', $pageDepth);
		
		$this->server = ServiceLocator::GetServer();
		$resources = Resources::GetInstance();
	
		$this->smarty =& new SmartyPage($resources, $path);
		
		$userSession = ServiceLocator::GetServer()->GetSession(SessionKeys::USER_SESSION);
		
		$this->smarty->assign('Charset', $resources->Charset);
		$this->smarty->assign('CurrentLanguage', $resources->CurrentLanguage);
		$this->smarty->assign('Title', "phpScheduleIt $title");
		$this->smarty->assign('CalendarJSFile', $resources->CalendarLanguageFile);
		$this->smarty->assign('AllowRss', Configuration::Instance()->GetKey(ConfigKeys::ALLOW_RSS));
		$this->smarty->assign('LoggedIn', !is_null($userSession));
		$this->smarty->assign('Version', Configuration::Instance()->GetKey(ConfigKeys::VERSION));
		$this->smarty->assign('Path', $path);
		$this->smarty->assign('ScriptUrl', Configuration::Instance()->GetKey(ConfigKeys::SCRIPT_URL));
		$this->smarty->assign('UserName', !is_null($userSession) ? $userSession->FirstName : '');
		$this->smarty->assign('DisplayWelcome', $this->DisplayWelcome());
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
	
	public function IsAuthenticated()
	{
		return !is_null($this->server->GetSession(SessionKeys::USER_SESSION));
	}
	
	public function IsPostBack()
	{
		return !empty($_POST);
	}
	
	public function RegisterValidator($validatorId, $validator)
	{
		$this->smarty->Validators->Register($validatorId, $validator);
	}
	
	public function IsValid()
	{
		return $this->smarty->IsValid();
	}
}
?>