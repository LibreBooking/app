<?php
require_once('IPage.php');
require_once(dirname(__FILE__) . '/../lib/Config/namespace.php');

class Page implements IPage
{
	protected $_smarty = null;
	protected $_server = null;
	
	public function __construct($title, Server $server = null, SmartyPage $smarty = null)
	{
		if (is_null($smarty))
		{
			$smarty = new SmartyPage();
		}
		
		if (is_null($server))
		{
			$server = new Server();
		}
	
		$this->_smarty = $smarty;
		$this->_server = $server;
		
		$resources = Resources::GetInstance($server);
		
		$this->_smarty->assign('Charset', $resources->Charset);
		$this->_smarty->assign('CurrentLanguage', $resources->CurrentLanguage);
		$this->_smarty->assign('Title', $title);
		$this->_smarty->assign('CalendarJSFile', $resources->CalendarLanguageFile);
		$this->_smarty->assign('AllowRss', Configuration::GetKey(ConfigKeys::ALLOW_RSS));
	}
	
	public function Redirect($url)
	{

	}
}
?>