<?php
if (!defined('SMARTY_DIR')) {
	define('SMARTY_DIR', ROOT_DIR . 'lib/external/Smarty/');
}
require_once(ROOT_DIR . 'lib/external/Smarty/Smarty.class.php');
require_once(ROOT_DIR . 'lib/Server/namespace.php');
require_once(ROOT_DIR . 'lib/Common/Validators/namespace.php');
require_once(ROOT_DIR . 'lib/Common/Converters/namespace.php');
require_once(ROOT_DIR . 'lib/Common/Helpers/namespace.php');
require_once(ROOT_DIR . 'lib/Common/SmartyControls/namespace.php');

class SmartyPage extends Smarty
{
	public $Validators;
		
	/**
	 * @var Resources
	 */
	protected $Resources = null;
	
	protected $RootPath = null;
	private $IsValid = true;
	
	public function __construct(Resources &$resources = null, $rootPath = null)
	{
		$base = dirname(__FILE__) . '/../../';
		
		$this->debugging = isset($_GET['debug']);
		$this->template_dir = $base . 'tpl';
		$this->compile_dir = $base . 'tpl_c';
		$this->config_dir = $base . 'configs';
		$this->cache_dir = $base . 'cache';
		$this->plugins_dir = SMARTY_DIR . '/plugins/';
		$this->error_reporting = E_ALL  & ~E_NOTICE;

		$cacheTemplates = Configuration::Instance()->GetKey(ConfigKeys::CACHE_TEMPLATES, new BooleanConverter());

		$this->compile_check = !$cacheTemplates;	// should be set to false in production
		$this->force_compile = !$cacheTemplates;	// should be set to false in production
		
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
		$this->registerPlugin('function', 'translate', array($this, 'SmartyTranslate'));
		$this->registerPlugin('function', 'formatdate', array($this, 'FormatDate'));
		$this->registerPlugin('function', 'html_link', array($this, 'PrintLink'));
		$this->registerPlugin('function', 'html_image', array($this, 'PrintImage'));
		$this->registerPlugin('function', 'control', array($this, 'DisplayControl'));
		$this->registerPlugin('function', 'validator', array($this, 'Validator'));
		$this->registerPlugin('function', 'textbox', array($this, 'Textbox'));
		$this->registerPlugin('function', 'object_html_options', array($this, 'ObjectHtmlOptions'));
		$this->registerPlugin('block', 'validation_group', array($this, 'ValidationGroup'));
		$this->registerPlugin('function', 'setfocus', array($this, 'SetFocus'));
		$this->registerPlugin('function', 'formname', array($this, 'GetFormName'));
		$this->registerPlugin('modifier', 'url2link', array($this, 'CreateUrl'));
        $this->registerPlugin('function', 'pagelink', array($this, 'CreatePageLink'));
        $this->registerPlugin('function', 'pagination', array($this, 'CreatePagination'));

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
		
		if (StringHelper::StartsWith($params['href'], '/'))
		{
			$href = $params['href'];
		}
		else
		{
			$href = $this->RootPath . $params['href'];
		}

		
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
	
	public function PrintImage($params, &$smarty)
	{
		$alt = isset($params['alt']) ? $params['alt'] : '';
		$altKey = isset($params['altKey']) ? $params['altKey'] : '';
		$width = isset($params['width']) ? $params['width'] : '';
		$height = isset($params['height']) ? $params['height'] : '';
		$imgPath = sprintf('%simg/%s', $this->RootPath, $params['src']);	
		
		$knownAttributes = array('alt', 'width', 'height', 'src', 'title', 'altKey');
		$attributes = $this->AppendAttributes($params, $knownAttributes);
		
		if (!empty($altKey))
		{
			$alt = $this->Resources->GetString($altKey);
		}
		
		return "<img src=\"$imgPath\" title=\"$alt\" alt=\"$alt\" width=\"\" height=\"\" $attributes />";
	}
	
	public function DisplayControl($params, &$smarty)
	{
		$type = $params['type'];
		require_once(ROOT_DIR . "Controls/$type.php");
		$control = new $type(new SmartyPage());
		
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
	
	public function ObjectHtmlOptions($params, &$smarty)
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
		return 'name=\'' . FormKeys::Evaluate($params['key']) . $append . '\'';
	}

	public function CreateUrl($var)
	{
		$string = preg_replace("/([^\w\/])(www\.[a-z0-9\-]+\.[a-z0-9\-]+)/i", "$1http://$2",$var);
		$string = preg_replace("/([\w]+:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/i","<a target=\"_blank\" href=\"$1\">$1</A>",$string);
		$string = preg_replace("/([\w-?&;#~=\.\/]+\@(\[?)[a-zA-Z0-9\-\.]+\.([a-zA-Z]{2,3}|[0-9]{1,3})(\]?))/i","<A HREF=\"mailto:$1\">$1</A>",$string);

		return $string;
	}

	/**
	 * @param  $params
	 * @param Smarty $smarty
	 * @return void
	 */
	public function CreatePagination($params, &$smarty)
	{
		/** @var PageInfo $pageInfo */
		$pageInfo = $params['pageInfo'];
		$sb = new StringBuilder();

		$sb->Append("<p>{$pageInfo->ResultsStart} - {$pageInfo->ResultsEnd} of {$pageInfo->Total}</p><p>");
		$sb->Append($this->Resources->GetString('Page'));
		for ($i = 1; $i <= $pageInfo->TotalPages; $i++)
		{
			$sb->Append($this->CreatePageLink(array('page' => $i), $smarty));
		}
		$sb->Append('</p>');

		return $sb->ToString();
	}

    /**
     * @param array $params
     * @param Smarty $smarty
     * @return string
     */
    public function CreatePageLink($params, &$smarty)
    {
        $url = $_SERVER['REQUEST_URI'];
        $key = QueryStringKeys::PAGE;
        $page = $params['page'];
        $newUrl = $url;

        if (strpos($url, $key) === false) // does not have page variable
        {
            if (strpos($url, '?') === false) // and does not have any query string
            {
                $newUrl = sprintf('%s?%s=%s', $url, $key, $page);
            }
            else
            {
                $newUrl = sprintf('%s&%s=%s', $url, $key, $page);  // and has existing query string
            }
        }
        else
        {
            $pattern = '/(\?|&)' . $key .'=\d+/';
            $replace = '${1}' . $key . '=' . $page;

            $newUrl = preg_replace($pattern, $replace, $url);
        }
        
        return sprintf('<a class="page" href="%s">%s</a>', $newUrl, $page);
    }
}
?>