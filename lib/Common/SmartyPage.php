<?php
require_once(ROOT_DIR . 'Smarty/Smarty.class.php');
require_once(ROOT_DIR . 'lib/Server/namespace.php');
require_once(ROOT_DIR . 'lib/Common/Validators/namespace.php');
require_once(ROOT_DIR . 'lib/Common/Converters/namespace.php');
require_once(ROOT_DIR . 'lib/Common/SmartyControls/namespace.php');

class SmartyPage extends Smarty
{
	public $Validators;
		
	private $Resources = null;
	private $RootPath = null;
	private $IsValid = true;
	
	public function __construct(Resources &$resources = null, $rootPath = null)
	{
		$base = dirname(__FILE__) . '/../../';
		
		$this->debugging = isset($_GET['d']);
		$this->template_dir = $base . 'tpl';
		$this->compile_dir = $base . 'tpl_c';
		$this->config_dir = $base . 'configs';
		$this->cache_dir = $base . 'cache';
		
		$this->compile_check = true;	// should be set to false in production
		
		if (is_null($resources))
		{
			$resources = Resources::GetInstance();
		}
		
		$this->Resources =& $resources;
		$this->RootPath = $rootPath;
		
		$this->RegisterFunctions();
	}
	
	protected function RegisterFunctions()
	{
		$this->register_function('translate', array($this, 'SmartyTranslate'));
		$this->register_function('formatdate', array($this, 'FormatDate'));
		$this->register_function('constant', array($this, 'GetConstant'));
		$this->register_function('html_link', array($this, 'PrintLink'));
		$this->register_function('html_image', array($this, 'PrintImage'));
		$this->register_function('control', array($this, 'DisplayControl'));
		$this->register_function('validator', array($this, 'Validator'));
		$this->register_function('textbox', array($this, 'Textbox'));
		$this->register_function('object_html_options', array($this, 'HtmlOptions'));
		$this->register_block('validation_group', array($this, 'ValidationGroup'));
		$this->register_function('setfocus', array($this, 'SetFocus'));
		$this->register_function('formname', array($this, 'GetFormName'));
		
		$this->Validators = new PageValdiators();
	}
		
	public function IsValid()
	{
		$this->Validators->Validate();
		$this->IsValid = $this->Validators->AreAllValid();

		return $this->IsValid;
	}

	private function AppendAttributes($params, $knownAttributes)
	{
		$extraKeys = array_diff(array_keys($params), $knownAttributes);
		
		$attributes = new StringBuilder();
		foreach($extraKeys as $key)
		{
			$attributes->Append("$key=\"{$params[$key]}\" ");
		}
		
		return $attributes->ToString();
	}
	
	public function PrintLink($params, &$smarty)
	{
		$string = $this->Resources->GetString($params['key']);
		if (!isset($params['title']))
		{
			$title = $string;
		}
		else
		{
			$title = $this->Resources->GetString($params['title']);
		}
		
		$href = $this->RootPath . $params['href'];
		
		$knownAttributes = array('key', 'title', 'href');
		$attributes = $this->AppendAttributes($params, $knownAttributes);

		return "<a href=\"$href\" title=\"$title\" $attributes>$string</a>";
	}
	
	public function SmartyTranslate($params, &$smarty) 
	{
		/// SHOULD THIS BE CHANGED TO REGISTER THE RESOURCE OBJECT WITH SMARTY AND ACCESS IT FROM THE TEMPLATES? ///
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
	
	public function PrintImage($params, &$smarty)
	{
		$alt = isset($params['alt']) ? $params['alt'] : '';
		$width = isset($params['width']) ? $params['width'] : '';
		$height = isset($params['height']) ? $params['height'] : '';
		$imgPath = sprintf('%simg/%s', $this->RootPath, $params['src']);	
		
		$knownAttributes = array('alt', 'width', 'height', 'src');
		$attributes = $this->AppendAttributes($params, $knownAttributes);
		
		return "<img src=\"$imgPath\" alt=\"$alt\" width=\"\" height=\"\" $attributes />";
	}
	
	public function DisplayControl($params, &$smarty)
	{
		$type = $params['type'];
		require_once(ROOT_DIR . "Controls/$type.php");
		$control = new $type($this);
		
		foreach($params as $key => $val)
		{
			if ($key != 'type')
			{
				$control->Set($key, $val);
			}
		}
		
		$control->PageLoad();
	}
	
	public function ValidationGroup($params, $content, &$smarty, &$repeat)
	{
		$class = 'error';
		
		if (isset($params['class']))
		{
			$class = $params['class'];
		}

		if (!$repeat)
		{
			$actualContent = trim($content);
			return empty($actualContent) ? '' :
				"<div class=\"$class\">
					<table>
						<tr>
							<td><img src=\"img/alert.png\" alt=\"Alert\" width=\"60\" height=\"60\" /></td>
							<td><ul>$actualContent</ul></td>
						</tr>
					</table>
				</div>";
		}
		return;
	}
	
	public function Validator($params, &$smarty)
	{
		$validator = $this->Validators->Get($params['id']);
		if (!$validator->IsValid())
		{
			return '<li>' . $this->SmartyTranslate(array('key' => $params['key']), $smarty) . '</li>';
		}
		return;
	}
	
	public function Textbox($params, &$smarty)
	{
		$class = null;
		$value = null;
		$size = null;
		$tabindex = null;
		$type = null;
		
		if (isset($params['class']))
		{
			$class = $params['class'];
		}
		
		if (isset($params['value']))
		{
			$value = $params['value'];
		}
		
		if (isset($params['size']))
		{
			$size = $params['size'];
		}

		if (isset($params['tabindex']))
		{
			$tabindex = $params['tabindex'];
		}

		if (isset($params['type']))
		{
			$type = strtolower($params['type']);
		}
		
		$knownAttributes = array('value', 'type', 'name');
		$attributes = $this->AppendAttributes($params, $knownAttributes);
		
		if ($type == 'password')
		{
			$textbox = new SmartyPasswordbox($params['name'], $value, $attributes, $smarty);
		}
		else
		{
			$textbox = new SmartyTextbox($params['name'], $value, $attributes, $smarty);
		}
		
		return $textbox->Html();
	}
	
	public function HtmlOptions($params, &$smarty)
	{
		$key = $params['key'];
		$label = $params['label'];
		$options = $params['options'];
		$type = isset($params['type']) ? $params['type'] : 'array';
		$selected = isset($params['selected']) ? $params['selected'] : '';
		
		$builder = new StringBuilder();
		foreach ($options as $option)
		{
			$isselected = ($option->$key() == $selected) ? 'selected="selected"' : '';
			$builder->Append(sprintf('<option label="%s" value="%s"%s>%s</option>', $option->$label(), $option->$key(), $isselected, $option->$label()));
		}
		
		return $builder->ToString();
	}
	
	public function SetFocus($params, &$smarty)
	{
		$id = isset($params['key']) ? FormKeys::Evaluate($params['key']) : $params['id'];
		return "<script type=\"text/javascript\">document.getElementById('$id').focus();</script>";
	}
	
	public function GetFormName($params, &$smarty)
	{
		$append = '';
		
		if (isset($params['multi']))
		{
			$append = '[]';
		}
		return 'name="' . FormKeys::Evaluate($params['key']) . $append . '"';
	}
}
?>