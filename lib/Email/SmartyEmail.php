<?php
require_once(ROOT_DIR . 'lib/external/Smarty/Smarty.class.php');
require_once(ROOT_DIR . 'lib/Server/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class SmartyEmail extends SmartyPage
{
	public function __construct($languageCode = null)
	{
		$resources = null;
		if (!empty($languageCode))
		{
			$resources = new Resources();
			$resources->SetLanguage($languageCode);
		}
		
		parent::__construct($resources, null);
		
		$this->assign('Charset', $this->Resources->Charset);
		$this->assign('ScriptUrl', Configuration::Instance()->GetKey(ConfigKeys::SCRIPT_URL));
				
		$this->template_dir = ROOT_DIR . 'lang';
		$this->compile_dir = ROOT_DIR . 'tpl_c';
		$this->config_dir = ROOT_DIR . 'configs';
		$this->cache_dir = ROOT_DIR . 'cache';
		
		$this->compile_check = true;	// should be set to false in production	
	}
	
	protected function RegisterFunctions()
	{
		$this->registerPlugin('function', 'translate', array($this, 'SmartyTranslate'));
		$this->registerPlugin('function', 'formatdate', array($this, 'FormatDate'));
		$this->registerPlugin('function', 'constant', array($this, 'GetConstant'));
		$this->registerPlugin('function', 'html_link', array($this, 'PrintLink'));
		$this->registerPlugin('function', 'html_image', array($this, 'PrintImage'));
	}
	
	public function FetchTemplate($templateName)
	{
		return $this->fetch($this->Resources->CurrentLanguage . "/" . $templateName);
	}
	
	public function Translate($key, $args = array())
	{
		return $this->Resources->GetString($key, $args);
	}
}
?>