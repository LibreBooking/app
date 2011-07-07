<?php
if (!defined('SMARTY_DIR')) {
	define('SMARTY_DIR', ROOT_DIR . 'lib/external/Smarty/');
}

require_once(ROOT_DIR . 'lib/external/Smarty/Smarty.class.php');
require_once(ROOT_DIR . 'lib/Server/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class SmartyEmail extends Smarty
{
	/**
	 * @var Resources
	 */
	protected $Resources = null;
	
	public function __construct($languageCode = null)
	{
		$this->Resources = new Resources();
		if (!empty($languageCode))
		{
			$this->Resources->SetLanguage($languageCode);
		}
		
		$this->assign('Charset', $this->Resources->Charset);
		$this->assign('ScriptUrl', Configuration::Instance()->GetKey(ConfigKeys::SCRIPT_URL));
				
		$this->template_dir = ROOT_DIR . 'lang';
		$this->compile_dir = ROOT_DIR . 'tpl_c';
		$this->config_dir = ROOT_DIR . 'configs';
		$this->cache_dir = ROOT_DIR . 'cache';

		$cacheTemplates = Configuration::Instance()->GetKey(ConfigKeys::CACHE_TEMPLATES, new BooleanConverter());
		$this->compile_check = !$cacheTemplates;	// should be set to false in production
		$this->force_compile = !$cacheTemplates;	// should be set to false in production
		
		$this->RegisterFunctions();
	}
	
	protected function RegisterFunctions()
	{
		$this->registerPlugin('function', 'translate', array($this, 'SmartyTranslate'));
		$this->registerPlugin('function', 'formatdate', array($this, 'FormatDate'));
		$this->registerPlugin('function', 'html_link', array($this, 'PrintLink'));
		$this->registerPlugin('function', 'html_image', array($this, 'PrintImage'));
	}
	
	public function FetchTemplate($templateName)
	{
		return $this->fetch($this->Resources->CurrentLanguage . "/" . $templateName);
	}
	
	public function SmartyTranslate($params, &$smarty) 
	{
		//TODO: make these more pluggable so theyre not copied
		if (!isset($params['args']))
		{
			return $this->Resources->GetString($params['key'], '');
		}
		return $this->Resources->GetString($params['key'], explode(',', $params['args']));
	}
	
	public function FormatDate($params, &$smarty) 
	{
		if (isset($params['format']))
		{
			return $params['date']->Format($params['format']);
		}
		
		$key = 'general_date';
		if (isset($params['key']))
		{
			$key = $params['key'];
		}
		return $params['date']->Format($this->Resources->GetDateFormat($key));
	}
}
?>