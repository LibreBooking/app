<?php
/**
 * Copyright 2011-2019 Nick Korbel
 *
 * This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */


if (!defined('SMARTY_DIR'))
{
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
	/**
	 * @var PageValidators
	 */
	public $Validators;

	/**
	 * @var Resources
	 */
	protected $Resources = null;

	/**
	 * @var null|string
	 */
	protected $RootPath = null;

	/**
	 * @var bool
	 */
	private $IsValid = true;

	/**
	 *
	 * @param Resources $resources
	 * @param string $rootPath
	 */
	public function __construct(Resources &$resources = null, $rootPath = null)
	{
		parent::__construct();

		$base = dirname(__FILE__) . '/../../';

		$this->debugging = isset($_GET['debug']);
		$this->AddTemplateDirectory($base . 'tpl');
		$this->compile_dir = $base . 'tpl_c';
		$this->config_dir = $base . 'configs';
		$this->cache_dir = $base . 'cache';
		$this->plugins_dir = $base . 'lib/external/Smarty/plugins';
		$this->error_reporting = E_ALL & ~E_NOTICE;

		$cacheTemplates = Configuration::Instance()->GetKey(ConfigKeys::CACHE_TEMPLATES, new BooleanConverter());

		$this->caching = false;
		$this->compile_check = !$cacheTemplates;
		$this->force_compile = !$cacheTemplates;

		if (is_null($resources))
		{
			$resources = Resources::GetInstance();
		}

		$this->Resources = &$resources;
		$this->RootPath = $rootPath;

		$this->AddTemplateDirectory($base . 'lang/' . $this->Resources->CurrentLanguage);

		$this->RegisterFunctions();
	}

	public function AddTemplateDirectory($templateDirectory)
	{
		$this->addTemplateDir($templateDirectory);
	}

	/**
	 * @param string $templateName
	 * @param null $languageCode uses current language is nothing is passed in
	 */
	public function DisplayLocalized($templateName, $languageCode = null)
	{
		if (empty($languageCode))
		{
			$languageCode = $this->getTemplateVars('CurrentLanguage');
		}
		$localizedPath = ROOT_DIR . 'lang/' . $languageCode;
		$defaultPath = ROOT_DIR . 'lang/en_us/' . $templateName;

		if (file_exists($localizedPath . '/' . $templateName))
		{
			$this->AddTemplateDirectory($localizedPath);
		}
		else
		{
			$this->AddTemplateDirectory($defaultPath);
		}

		$this->Display($templateName);
	}

	/**
	 * @param string $templateName
	 * @param null $languageCode uses current language is nothing is passed in
	 * @return string
	 */
	public function FetchLocalized($templateName, $languageCode = null)
	{
		if (empty($languageCode))
		{
			$languageCode = $this->getTemplateVars('CurrentLanguage');
		}
		$localizedPath = ROOT_DIR . 'lang/' . $languageCode;
		$defaultPath = ROOT_DIR . 'lang/en_us/';

		if (file_exists($localizedPath . '/' . $templateName))
		{
		    $path = $localizedPath;
			$this->AddTemplateDirectory($localizedPath);
		}
		else
		{
		    $path = $defaultPath;
			$this->AddTemplateDirectory($defaultPath);
		}

        $customTemplateName = str_replace('.tpl', '-custom.tpl', $templateName);
        if (file_exists($path . '/' . $customTemplateName))
        {
            $templateName = $customTemplateName;
        }

		return $this->fetch($templateName);
	}

	protected function RegisterFunctions()
	{
		$this->registerPlugin('function', 'translate', array($this, 'SmartyTranslate'));
		$this->registerPlugin('function', 'formatdate', array($this, 'FormatDate'));
		$this->registerPlugin('function', 'format_date', array($this, 'FormatDate'));
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
		$this->registerPlugin('function', 'js_array', array($this, 'CreateJavascriptArray'));
		$this->registerPlugin('function', 'async_validator', array($this, 'AsyncValidator'));
		$this->registerPlugin('function', 'fullname', array($this, 'DisplayFullName'));
		$this->registerPlugin('function', 'add_querystring', array($this, 'AddQueryString'));
		$this->registerPlugin('function', 'resource_image', array($this, 'GetResourceImage'));
		$this->registerPlugin('modifier', 'escapequotes', array($this, 'EscapeQuotes'));
		$this->registerPlugin('function', 'flush', array($this, 'Flush'));
		$this->registerPlugin('function', 'jsfile', array($this, 'IncludeJavascriptFile'));
		$this->registerPlugin('function', 'cssfile', array($this, 'IncludeCssFile'));
		$this->registerPlugin('function', 'indicator', array($this, 'DisplayIndicator'));
		$this->registerPlugin('function', 'read_only_attribute', array($this, 'ReadOnlyAttribute'));
		$this->registerPlugin('function', 'csrf_token', array($this, 'CSRFToken'));
		$this->registerPlugin('function', 'cancel_button', array($this, 'CancelButton'));
		$this->registerPlugin('function', 'update_button', array($this, 'UpdateButton'));
		$this->registerPlugin('function', 'add_button', array($this, 'AddButton'));
		$this->registerPlugin('function', 'delete_button', array($this, 'DeleteButton'));
		$this->registerPlugin('function', 'reset_button', array($this, 'ResetButton'));
		$this->registerPlugin('function', 'filter_button', array($this, 'FilterButton'));
		$this->registerPlugin('function', 'ok_button', array($this, 'OkButton'));
		$this->registerPlugin('function', 'showhide_icon', array($this, 'ShowHideIcon'));
		$this->registerPlugin('function', 'sort_column', array($this, 'SortColumn'));
		$this->registerPlugin('function', 'formatcurrency', array($this, 'FormatCurrency'));

		/**
		 * PageValidators
		 */
		$this->Validators = new PageValidators($this);
	}

	public function IsValid()
	{
		try
		{
			$this->Validate();
			$this->IsValid = $this->Validators->AreAllValid();
			return $this->IsValid;
		} catch (Exception $ex)
		{
			Log::Error('Error during page validation', $ex);
			return false;
		}
	}

	public function Validate()
	{
		$this->Validators->Validate();
	}

	/**
	 * @var array|IValidator[]
	 */
	public $failedValidators = array();

	/**
	 * @param $id int
	 * @param $validator IValidator
	 */
	public function AddFailedValidation($id, $validator)
	{
		$this->failedValidators[$id] = $validator;
	}

	private function AppendAttributes($params, $knownAttributes)
	{
		$extraKeys = array_diff(array_keys($params), $knownAttributes);

		$attributes = new StringBuilder();
		foreach ($extraKeys as $key)
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

		if (BookedStringHelper::StartsWith($params['href'], '/'))
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
		if (!isset($params['args']))
		{
			return $this->Resources->GetString($params['key'], '');
		}
		return $this->Resources->GetString($params['key'], explode(',', $params['args']));
	}

	public function FormatDate($params, &$smarty)
	{
		if (!isset($params['date']) || empty($params['date']))
		{
			return '';
		}

		$date = is_string($params['date']) ? Date::Parse($params['date']) : $params['date'];

		/** @var $date Date */
		$date = isset($params['timezone']) ? $date->ToTimezone($params['timezone']) : $date;

		if (isset($params['format']))
		{
			return $date->Format($params['format']);
		}

		$key = 'general_date';
		if (isset($params['key']))
		{
			$key = $params['key'];
		}
		$format = $this->Resources->GetDateFormat($key);

		$formatted = $date->Format($format);

		if (strpos($format, 'l') !== false)
		{
			// correct english day name to translated day name
			$english_days = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
			$days = $this->Resources->GetDays('full');
			$formatted = str_replace($english_days[$date->Weekday()], $days[$date->Weekday()], $formatted);
		}
		return $formatted;
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

		return "<img src=\"$imgPath\" title=\"$alt\" alt=\"$alt\"  $attributes />";
	}

	public function DisplayControl($params, &$smarty)
	{
		$type = $params['type'];
		require_once(ROOT_DIR . "Controls/$type.php");

		/** @var $control Control */
		$control = new $type($this);

		foreach ($params as $key => $val)
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
					<div class=\"pull-left\"><i class=\"fa fa-warning fa-2x\"></i></div>
					<div class=\"error-list\"><ul class=\"list-unstyled\">$actualContent</ul></div>
				</div>";
		}
		return '';
	}

	public function Validator($params, &$smarty)
	{
		$validator = $this->Validators->Get($params['id']);
		if (!$validator->IsValid())
		{
			if (isset($params['key']) && !empty($params['key']))
			{
				return '<li>' . $this->SmartyTranslate(array('key' => $params['key']), $smarty) . '</li>';
			}

			$messages = $validator->Messages();
			if (!empty($messages))
			{
				$errors = '';
				foreach ($messages as $message)
				{
					$errors .= sprintf('<li id="%s">%s</li>', $params['id'], $message);
				}

				return $errors;
			}

		}
		return '';
	}

	public function AsyncValidator($params, &$smarty)
	{
		$message = '';
		if (isset($params['key']) && !empty($params['key']))
		{
			$message = $this->SmartyTranslate(array('key' => $params['key']), $smarty);
		}
		return sprintf('<li class="asyncValidation" id="%s">%s</li>', $params['id'], $message);
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
			$params['class'] = $params['class'] . ' form-control';
		}
		else
		{
			$params['class'] = 'form-control';
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
		else
		{
			$type = 'text';
		}
        if (isset($params['required']) && $params['required'] == true)
        {
            $required = true;
        }
        else
        {
            $required = false;
        }

		$id = null;
		if (isset($params['id']))
		{
			$id = $params['id'];
		}

		if (isset($params['placeholderkey']))
		{
			$params['placeholder'] = $this->Resources->GetString($params['placeholderkey']);
		}

		$knownAttributes = array('value', 'type', 'name', 'placeholderkey', 'required');
		$attributes = $this->AppendAttributes($params, $knownAttributes);

		if ($type == 'password')
		{
			$textbox = new SmartyPasswordbox($params['name'], 'password', $id, $value, $attributes, $required, $smarty);
		}
		else
		{
			$textbox = new SmartyTextbox($params['name'], $type, $id, $value, $attributes, $required, $smarty);
		}

		return $textbox->Html();
	}

	public function ObjectHtmlOptions($params, &$smarty)
	{
		$key = $params['key'];
		$label = $params['label'];
		$options = $params['options'];
		$type = isset($params['type']) ? $params['type'] : 'array';
		$usemethod = isset($params['usemethod']) ? $params['usemethod'] : true;
		$selected = isset($params['selected']) ? $params['selected'] : '';

		$builder = new StringBuilder();
		foreach ($options as $option)
		{
			$_key = ($usemethod) ? $option->$key() : $option->$key;
			$_label = ($usemethod) ? $option->$label() : $option->$label;
			$isselected = ($_key == $selected) ? 'selected="selected"' : '';
			$builder->Append(sprintf('<option label="%s" value="%s"%s>%s</option>', $_label, $_key,
									 $isselected, $_label));
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

	public function CreateUrl($url)
	{
		// credit to WordPress wp-includes/formatting.php
		$make_url_clickable = function ($matches) {
			$ret = '';
			$url = $matches[2];

			if (empty($url))
			{
				return $matches[0];
			}
			// removed trailing [.,;:] from URL
			if (in_array(substr($url, -1), array('.', ',', ';', ':')) === true)
			{
				$ret = substr($url, -1);
				$url = substr($url, 0, strlen($url) - 1);
			}

			$text = $url;
			if (strlen($text) > 30)
			{
				$text = substr($text, 0, 30) . '...';
			}

			return $matches[1] . "<a href=\"$url\" target=\"_blank\" rel=\"nofollow\">$text</a>" . $ret;
		};

		$make_web_ftp_clickable_cb = function ($matches) {
			$ret = '';
			$dest = $matches[2];
			$dest = 'http://' . $dest;

			if (empty($dest))
			{
				return $matches[0];
			}
			// removed trailing [,;:] from URL
			if (in_array(substr($dest, -1), array('.', ',', ';', ':')) === true)
			{
				$ret = substr($dest, -1);
				$dest = substr($dest, 0, strlen($dest) - 1);
			}

			$text = $dest;
			if (strlen($text) > 30)
			{
				$text = substr($text, 0, 30) . '...';
			}

			return $matches[1] . "<a href=\"$dest\" rel=\"nofollow\">$text</a>" . $ret;
		};

		$make_email_clickable_cb = function ($matches) {
			$email = $matches[2] . '@' . $matches[3];
			return $matches[1] . "<a href=\"mailto:$email\">$email</a>";
		};

		$url = ' ' . $url;
		$url = preg_replace_callback('#([\s>])([\w]+?://[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is', $make_url_clickable,
									 $url);
		$url = preg_replace_callback('#([\s>])((www|ftp)\.[\w\\x80-\\xff\#$%&~/.\-;:=,?@\[\]+]*)#is',
									 $make_web_ftp_clickable_cb, $url);
		$url = preg_replace_callback('#([\s>])([.0-9a-z_+-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,})#i',
									 $make_email_clickable_cb, $url);
		$url = preg_replace("#(<a( [^>]+?>|>))<a [^>]+?>([^>]+?)</a></a>#i", "$1$3</a>", $url);
		$url = trim($url);
		return $url;
	}

	public function CreatePagination($params, &$smarty)
	{
		/** @var PageInfo $pageInfo */
		$pageInfo = $params['pageInfo'];
		$hideCount = isset($params['showCount']) && $params['showCount'] == false;

		if (empty($pageInfo->Total))
		{
			return '';
		}

		$sb = new StringBuilder();

		$viewAllText = $this->Resources->GetString('ViewAll');
		if (!$hideCount)
		{
			$sb->Append('<div class="pagination-rows">');
			$sb->Append($this->Resources->GetString('Rows'));
			$sb->Append(": {$pageInfo->ResultsStart} - {$pageInfo->ResultsEnd} ({$pageInfo->Total})");
			$sb->Append('<span>&nbsp;</span>');
			if ($pageInfo->TotalPages != 1)
			{
				$sb->Append($this->CreatePageLink(array('page' => 1, 'size' => '-1', 'text' => $viewAllText), $smarty));
			}
			$sb->Append('</div>');
		}
		$size = $pageInfo->PageSize;
		$currentPage = $pageInfo->CurrentPage;

		$sb->Append('<ul class="pagination">');
		$sb->Append('<li>');
		$sb->Append($this->CreatePageLink(array('page' => max(1,
															  $currentPage - 1), 'size' => $size, 'text' => '&laquo;'),
										  $smarty));
		$sb->Append('</li>');

		for ($i = 1; $i <= $pageInfo->TotalPages; $i++)
		{
			$isCurrent = ($i == $currentPage);

			if ($isCurrent)
			{
				$sb->Append('<li class="active">');
			}
			else
			{
				$sb->Append('<li>');
			}
			$sb->Append($this->CreatePageLink(array('page' => $i, 'size' => $size), $smarty));
			$sb->Append('</li>');
		}
		$sb->Append('<li>');
		$sb->Append($this->CreatePageLink(array('page' => min($pageInfo->TotalPages,
															  $currentPage + 1), 'size' => $size, 'text' => '&raquo;'),
										  $smarty));
		$sb->Append('</li>');
		$sb->Append('</ul>');

		return $sb->ToString();
	}

	public function CreatePageLink($params, &$smarty)
	{
		$url = ServiceLocator::GetServer()->GetUrl();
		$page = $params['page'];
		$pageSize = $params['size'];
		$iscurrent = $params['iscurrent'];
		$text = isset($params['text']) ? $params['text'] : $page;

		$newUrl = $this->ReplaceQueryString($url, QueryStringKeys::PAGE, $page);
		$newUrl = $this->ReplaceQueryString($newUrl, QueryStringKeys::PAGE_SIZE, $pageSize);

		$class = $iscurrent ? "page current" : "page";

		return sprintf('<a class="%s" href="%s" data-page="%s" data-page-size="%s">%s</a>', $class, $newUrl, $page, $pageSize, $text);
	}

	function ReplaceQueryString($url, $key, $value)
	{
		$newUrl = $url;

		if (strpos($url, $key) === false)
		{ // does not have variable
			if (strpos($url, '?') === false)
			{ // and does not have any query string
				$newUrl = sprintf('%s?%s=%s', $url, $key, $value);
			}
			else
			{
				$newUrl = sprintf('%s&amp;%s=%s', $url, $key, $value); // and has existing query string
			}
		}
		else
		{
			$pattern = '/(\?|&)(' . $key . '=.*)/';
			$replace = '${1}' . $key . '=' . $value;

			$newUrl = preg_replace($pattern, $replace, $url);
		}

		return $newUrl;
	}

	public function CreateJavascriptArray($params, &$smarty)
	{
		$array = $params['array'];

		$string = implode('","', $array);

		return "[\"$string\"]";
	}

	public function DisplayFullName($params, &$smarty)
	{
		$config = Configuration::Instance();
		$ignorePrivacy = false;
		if (isset($params['ignorePrivacy']) && strtolower($params['ignorePrivacy'] == 'true'))
		{
			$ignorePrivacy = true;
		}

		if (!$ignorePrivacy && $config->GetSectionKey(ConfigSection::PRIVACY, ConfigKeys::PRIVACY_HIDE_USER_DETAILS,
													  new BooleanConverter()) && !ServiceLocator::GetServer()->GetUserSession()->IsAdmin
		)
		{
			return $this->Resources->GetString('Private');
		}

		$fullName = new FullName($params['first'], $params['last']);

		return htmlspecialchars($fullName->__toString());
	}

	public function AddQueryString($params, &$smarty)
	{
		$url = new Url(ServiceLocator::GetServer()->GetUrl());
		$name = constant(sprintf('QueryStringKeys::%s', $params['key']));
		$url->AddQueryString($name, $params['value']);

		return $url->ToString();
	}

	public function GetResourceImage($params, &$smarty)
	{
		$imageUrl = Configuration::Instance()->GetKey(ConfigKeys::IMAGE_UPLOAD_URL);

		if (strpos($imageUrl, 'http://') === false)
		{
			$imageUrl = Configuration::Instance()->GetScriptUrl() . "/$imageUrl";
		}

		return "$imageUrl/{$params['image']}";
	}

	public function EscapeQuotes($var)
	{
		$str = str_replace('\'', '&#39;', $var);
		return str_replace('"', '&quot;', $str);
	}

	public function Flush($params, &$smarty)
	{
		echo '<!-- flushing -->';
		flush();
	}

	public function IncludeJavascriptFile($params, &$smarty)
	{
		$versionNumber = Configuration::VERSION;
		$async = isset($params['async']) ? ' async' : '';
		echo "<script type=\"text/javascript\" src=\"{$this->RootPath}scripts/{$params['src']}?v=$versionNumber\"{$async}></script>";
	}

	public function IncludeCssFile($params, &$smarty)
	{
		$versionNumber = Configuration::VERSION;
		$src = $params['src'];
		if (!BookedStringHelper::Contains($src, '/'))
		{
			$src = "css/{$src}";
		}
		echo "<link rel='stylesheet' type='text/css' href='{$this->RootPath}{$src}?v=$versionNumber'/>";
	}

	public function DisplayIndicator($params, &$smarty)
	{
		$id = isset($params['id']) ? $params['id'] : '';
		$spinClass = isset($params['spinClass']) ? $params['spinClass'] : 'fa-spinner';
		$size = isset($params['size']) ? "fa-{$params['size']}x" : 'fa-2x';
		$show = isset($params['show']) ? '' : 'no-show';
		$class = isset($params['class']) ? $params['class'] : 'indicator';

		echo "<span id=\"$id\" class=\"fa fa-spin $spinClass $size $class $show\"></span>";
	}

	public function ReadOnlyAttribute($params, &$smarty)
	{
		$attrVal = $params['value'];
		$attribute = $params['attribute'];
		if ($attribute->Type() == CustomAttributeTypes::CHECKBOX)
		{
			if ($attrVal == 1)
			{
				echo Resources::GetInstance()->GetString('Yes');
			}
			else
			{
				echo Resources::GetInstance()->GetString('No');
			}
		}
		else
		{
			echo $attrVal;
		}
	}

	public function CSRFToken($params, &$smarty)
	{
		echo '<input type="hidden" id="csrf_token" name="' . FormKeys::CSRF_TOKEN . '" value="' .
				ServiceLocator::GetServer()->GetUserSession()->CSRFToken . '"/>';
	}

	private function GetButtonAttributes($params)
	{
		$knownAttributes = array('key', 'class');
		return $this->AppendAttributes($params, $knownAttributes);
	}

	public function CancelButton($params, &$smarty)
	{
		$key = isset($params['key']) ? $params['key'] : 'Cancel';
		$class = isset($params['class']) ? $params['class'] : '';
		echo '<button type="button" class="btn btn-default cancel ' . $class . '" data-dismiss="modal" ' . $this->GetButtonAttributes($params) . '>' .
				Resources::GetInstance()->GetString($key) . '</button>';
	}

	public function UpdateButton($params, &$smarty)
	{
		$key = isset($params['key']) ? $params['key'] : 'Update';
		$class = isset($params['class']) ? ' ' . $params['class'] . ' ' : '';
		$type = isset($params['submit']) ? 'submit' : 'button';
		$save = $type == 'submit' ? '' : ' save ';

		echo '<button type="' . $type . '" class="btn btn-success' . $save . $class . '" ' . $this->GetButtonAttributes($params) . '><span class="glyphicon glyphicon-ok-circle"></span> ' . Resources::GetInstance()
																																																	  ->GetString($key) . '</button>';
	}

	public function AddButton($params, &$smarty)
	{
		$key = isset($params['key']) ? $params['key'] : 'Add';
		$class = isset($params['class']) ? $params['class'] : '';
		$submit = isset($params['submit']) ? $params['submit'] : false;
		$type = 'button';
		if ($submit)
		{
			$type = 'submit';
		}

		echo '<button type="' . $type . '" class="btn btn-success save ' . $class . '" ' . $this->GetButtonAttributes($params) . '><span class="glyphicon glyphicon-ok-circle"></span> ' . Resources::GetInstance()
																																																	->GetString($key) . '</button>';
	}

	public function DeleteButton($params, &$smarty)
	{
		$key = isset($params['key']) ? $params['key'] : 'Delete';
		$class = isset($params['class']) ? $params['class'] : '';
        $submit = isset($params['submit']) ? $params['submit'] : false;
        $type = 'button';
        if ($submit)
        {
            $type = 'submit';
        }
        echo '<button type="' . $type . '" class="btn btn-danger save ' . $class . '" ' . $this->GetButtonAttributes($params) . '><span class="glyphicon glyphicon-trash"></span> ' . Resources::GetInstance()
																																														->GetString($key) . '</button>';
	}

	public function ResetButton($params, &$smarty)
	{
		$key = isset($params['key']) ? $params['key'] : 'Reset';
		$class = isset($params['class']) ? $params['class'] : '';
		echo '<button type="reset" class="btn btn-default ' . $class . '" ' . $this->GetButtonAttributes($params) . '>' . Resources::GetInstance()
																																	->GetString($key) . '</button>';
	}

	public function FilterButton($params, &$smarty)
	{
		$key = isset($params['key']) ? $params['key'] : 'Filter';
		$class = isset($params['class']) ? $params['class'] : '';
		echo '<button type="search" class="btn btn-primary ' . $class . '" ' . $this->GetButtonAttributes($params) . '> <span class="glyphicon glyphicon-search"></span> ' . Resources::GetInstance()
																																													  ->GetString($key) . '</button>';
	}

	public function OkButton($params, &$smarty)
	{
		$key = isset($params['key']) ? $params['key'] : 'OK';
		$class = isset($params['class']) ? $params['class'] : '';
		echo '<button type="button" class="btn btn-success ' . $class . '" ' . $this->GetButtonAttributes($params) . '><span class="glyphicon glyphicon-ok-circle"></span> ' . Resources::GetInstance()
																																														->GetString($key) . '</button>';
	}

	public function ShowHideIcon($params, &$smarty)
	{
		$class = isset($params['class']) ? $params['class'] : '';
		echo '<a href="#"><span class="icon black show-hide glyphicon ' . $class . '"></span><span class="no-show">Show/Hide</span></a>';
	}

	public function SortColumn($params, &$smarty)
	{
		$server = ServiceLocator::GetServer();
		$url = $server->GetRequestUri();

		$sortField = $params['field'];
		$sortDirection = 'asc';
		$currentDirection = $server->GetQuerystring(QueryStringKeys::SORT_DIRECTION);
		$currentField = $server->GetQuerystring(QueryStringKeys::SORT_FIELD);

		$hasQueryString = BookedStringHelper::Contains($url, '?');
		$sd = QueryStringKeys::SORT_DIRECTION;
		$sf = QueryStringKeys::SORT_FIELD;

		$indicator = '';
		if ($sortField == $currentField)
		{

			$sortDirection = $currentDirection == 'asc' ? 'desc' : 'asc';
			$indicator = "<i class=\"fa fa-sort-desc\"></i>";
			if ($currentDirection == 'asc')
			{
				$indicator = "<i class=\"fa fa-sort-asc\"></i>";
			}
		}

		if (BookedStringHelper::Contains($url, $sd))
		{
			$url = preg_replace("/$sd=(asc|desc)&?/", "$sd=$sortDirection&", $url);
		}
		else
		{
			$url = $url . ($hasQueryString ? "&" : "?") . "$sd=$sortDirection";
		}

		if (BookedStringHelper::Contains($url, $sf))
		{
			$url = preg_replace("/$sf=[a-zA-Z0-9_\\-]+&?/", "$sf=$sortField&", $url);
		}
		else
		{
			$url = "$url&$sf=$sortField";
		}

		echo '<a href="' . $url . '">' . $this->Resources->GetString($params['key']) . ' ' . $indicator . '</a>';
	}

	public function FormatCurrency($params, &$smarty)
	{
		$amount = $params['amount'];
		$currency = $params['currency'];

		if (!class_exists('NumberFormatter'))
		{
			if ($currency == 'USD')
			{
				echo '$' . floatval($amount) . 'USD';
			}
			else
			{
				echo 'We cannot format this currency. <a href="http://php.net/manual/en/book.intl.php">You must enable internationalization</a>.';
			}
		}
		else
		{
			$fmt = new NumberFormatter($this->Resources->CurrentLanguage, NumberFormatter::CURRENCY);
			echo $fmt->formatCurrency($amount, $currency);
		}
	}
}