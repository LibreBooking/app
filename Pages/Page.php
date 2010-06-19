<?php
require_once(ROOT_DIR . 'Pages/IPage.php');
require_once(ROOT_DIR . 'Pages/Pages.php');
require_once(ROOT_DIR . 'lib/Common/SmartyPage.php');
require_once(ROOT_DIR . 'lib/Server/namespace.php');
require_once(ROOT_DIR . 'lib/Config/namespace.php');

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
	
	public function __construct($titleKey = '', $pageDepth = 0)
	{
		$path = str_repeat('../', $pageDepth);
		
		$this->server = ServiceLocator::GetServer();
		$resources = Resources::GetInstance();
	
		$this->smarty = new SmartyPage($resources, $path);
		
		$userSession = ServiceLocator::GetServer()->GetUserSession();
		
		$this->smarty->assign('Charset', $resources->Charset);
		$this->smarty->assign('CurrentLanguage', $resources->CurrentLanguage);
		$this->smarty->assign('Title', 'phpScheduleIt - ' . $resources->GetString($titleKey));
		$this->smarty->assign('CalendarJSFile', $resources->CalendarLanguageFile);
		$this->smarty->assign('AllowRss', Configuration::Instance()->GetKey(ConfigKeys::ALLOW_RSS));
		$this->smarty->assign('LoggedIn', $userSession->IsLoggedIn());
		$this->smarty->assign('Version', Configuration::Instance()->GetKey(ConfigKeys::VERSION));
		$this->smarty->assign('Path', $path);
		$this->smarty->assign('ScriptUrl', Configuration::Instance()->GetKey(ConfigKeys::SCRIPT_URL));
		$this->smarty->assign('UserName', !is_null($userSession) ? $userSession->FirstName : '');
		$this->smarty->assign('DisplayWelcome', $this->DisplayWelcome());
		$this->smarty->assign('UserId', $userSession->UserId);


		// TODO: should this be filled in dynamically from the database, for sure we want to 
		// have a different one for administrators. Perhaps the value should be minimal until the 
		// User is Authenticated.
		// 
		// This complex array is used to build the tabs and sub tabs... 
		$this->smarty->assign('Tabs', array(
				array ( 'id' => "TabOne",
					'default' => 1,
					'text' => "Tab One",
					'peers' => array('TabTwo', 'TabThree'),
					'subtabs' => array( 
						array( 'text' => "Sub Tab One-One",   'link' => "#" ),
						array( 'text' => "Sub Tab One-Two",   'link' => "#" ),
						array( 'text' => "Sub Tab One-Three", 'link' => "#" )
					)
				),
				array ( 'id' => "TabTwo",
					'default' => 0,
					'text' => "Tab Two",
					'peers' => array('TabOne', 'TabThree'),
					'subtabs' => array( 
						array( 'text' => "Sub Tab Two-One",   'link' => "#" ),
						array( 'text' => "Sub Tab Two-Two",   'link' => "#" ),
						array( 'text' => "Sub Tab Two-Three", 'link' => "#" )
					)
				),
				array ( 'id' => "TabThree",
					'default' => 0,
					'text' => "Tab Three",
					'peers' => array('TabOne', 'TabTwo'),
					'subtabs' => array( 
						array( 'text' => "Sub Tab Three-One",   'link' => "#" ),
						array( 'text' => "Sub Tab Three-Two",   'link' => "#" ),
						array( 'text' => "Sub Tab Three-Three", 'link' => "#" )
					)
				)
			));

	}
	
	public function Redirect($url)
	{
		header("Location: $url");
		die();
	}
	
	public function RedirectToError($errorMessageId, $lastPage = '')
	{
		$errorPageUrl = sprintf("error.php?%s=%s&%s=%s", QueryStringKeys::MESSAGE_ID, $errorMessageId, QueryStringKeys::REDIRECT, urlencode($lastPage));
		$this->Redirect($errorPageUrl);
	}
	
	public function GetLastPage()
	{
		$referer = getenv("HTTP_REFERER");
		if (empty($referer))
		{
			return "index.php";
		}
		
		$scriptUrl = strtolower(Configuration::Instance()->GetScriptUrl());
		$page = str_replace($scriptUrl, '', strtolower($referer));
		return ltrim($page, '/');
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
	
	public function Set($var, $value)
	{
		$this->smarty->assign($var, $value);
	}
	
	protected function GetVar($var)
	{
		return $this->smarty->get_template_vars($var);
	}
	
	protected function GetForm($var)
	{
		return $this->server->GetForm($var);
	}
	
	protected function GetQuerystring($key)
	{
		return $this->server->GetQuerystring($key);
	}
}
?>
