<?php
require_once('namespace.php');
require_once(dirname(__FILE__) . '/../../Smarty/Smarty.class.php');
require_once(dirname(__FILE__) . '/../Server/namespace.php');


class SmartyPage extends Smarty
{
	private $Resources = null;
	
	public function __construct(Resources &$resources = null)
	{
		$base = dirname(__FILE__) . '/../../';
		
		$this->template_dir = $base . 'tpl';
		$this->compile_dir = $base . 'tpl_c';
		$this->config_dir = $base . 'configs';
		$this->cache_dir = $base . 'cache';
		
		$this->compile_check = true;
		$this->force_compile = true;
		$this->caching = false;
		
		if (is_null($resources))
		{
			$resources = Resources::GetInstance();
		}
		
		$this->Resources =& $resources;
		
		$this->register_function('translate', array($this, 'SmartyTranslate'));
		$this->register_function('constant', array($this, 'GetConstant'));
//		$this->register_function('html_link', array($this, 'PrintLink'));
	}

//	public function PrintLink($params, &$smarty)
//	{
//		return "<a href=\"{$params['href']}\" title=\"{$params['title']}\">{$params['string']}</a>";
//	}
	
	public function SmartyTranslate($params, &$smarty) 
	{
		return $this->Resources->GetString($params['string'], explode(',', $params['args']));
	}
	
	public function GetConstant($params, &$smarty)
	{
		if (defined($params['echo'])) 
		{
			return eval('return ' . $params['echo'] . ';');
		}
		else
		{
			throw new Exception(sprintf('Constant %s is not defined', $params['echo']));	
		}
	}
}
?>