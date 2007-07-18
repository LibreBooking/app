<?php
require_once('IPage.php');
require_once(dirname(__FILE__) . '/../lib/Common/SmartyPage.php');
require_once(dirname(__FILE__) . '/../lib/Server/namespace.php');
require_once(dirname(__FILE__) . '/../lib/Config/namespace.php');
require_once(dirname(__FILE__) . '/../lib/Database/MDB2/namespace.php');

class Page implements IPage
{
	protected $smarty = null;
	protected $server = null;
	
	public function __construct($title, Server &$server = null, SmartyPage &$smarty = null, $pageDepth = 0)
	{
		$path = str_repeat('../', $pageDepth);
		
		if (is_null($server))
		{
			$server = new Server();
		}
		
		$this->server =& $server;	
		$resources = Resources::GetInstance($server);
	
		if (is_null($smarty))
		{
			$smarty = new SmartyPage($resources, $path);
		}
	
		$this->smarty =& $smarty;
		
		$userSession = $server->GetSession(SessionKeys::USER_SESSION);
		
		$this->smarty->assign('Charset', $resources->Charset);
		$this->smarty->assign('CurrentLanguage', $resources->CurrentLanguage);
		$this->smarty->assign('Title', $title);
		$this->smarty->assign('CalendarJSFile', $resources->CalendarLanguageFile);
		$this->smarty->assign('AllowRss', Configuration::GetKey(ConfigKeys::ALLOW_RSS));
		$this->smarty->assign('LoggedIn', !is_null($userSession));
		$this->smarty->assign('Version', Configuration::GetKey(ConfigKeys::VERSION));
		$this->smarty->assign('Path', $path);
		$this->smarty->assign('ScriptUrl', Configuration::GetKey(ConfigKeys::SCRIPT_URL));
		$this->smarty->assign('UserName', !is_null($userSession) ? $userSession->FirstName : '');
		$this->smarty->assign('DisplayWelcome', $this->DisplayWelcome());
	}
	
	public function Redirect($url)
	{
		header("Location: $url");
	}
	
	public function DisplayWelcome()
	{
		return true;
	}
	
	public function IsAuthenticated()
	{
		return !is_null($this->server->GetSession(SessionKeys::USER_SESSION));
	}
}

class Pages
{
	const DEFAULT_LOGIN = 'controlpanel.php';
	const LOGIN = 'login.php';
	const CONTROL_PANEL = 'controlpanel.php';
}
?>