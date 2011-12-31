<?php
interface IResourceLocalization
{
	/**
	 * @abstract
	 * @param $key
	 * @param array|string $args
	 * @return void
	 */
	public function GetString($key, $args = array());
	public function GetDateFormat($key);
	public function GetDays($key);
	public function GetMonths($key);
	function GeneralDateFormat();
	function GeneralDateTimeFormat();
}

class ResourceKeys
{
	const DATE_GENERAL = 'general_date';
	const DATETIME_GENERAL = 'general_datetime';
}

class Resources implements IResourceLocalization
{
	public $CurrentLanguage;
	public $LanguageFile;
	public $CalendarLanguageFile;
	public $AvailableLanguages = array();
	public $Charset;
	public $HtmlLang;
	
	protected $LanguageDirectory;
	
	private static $_instance;

	private $systemDateKeys = array();
	
	/**
	 * @var Language
	 */
	private $_lang;
	
	public function __construct()
	{	
		$this->LanguageDirectory = dirname(__FILE__) . '/../../lang/';

		$this->systemDateKeys['js_general_date'] = 'mm/dd/yy';
		$this->systemDateKeys['url'] = 'Y-m-d';
		$this->systemDateKeys['ical'] = 'Ymd\THis\Z';
		$this->systemDateKeys['period_time'] = "g:i A";
		
		$this->LoadAvailableLanguages();
	}
	
	private static function Create()
	{
		$resources = new Resources();
		$resources->SetCurrentLanguage($resources->GetLanguageCode());
		return $resources;
	}
	
	/**
	 * @return Resources
	 */
	public static function &GetInstance()
	{					
		if (is_null(self::$_instance))
		{
			self::$_instance = Resources::Create();
		}
		
		return self::$_instance;
	}
	
	public static function SetInstance($instance)
	{
		self::$_instance = $instance;
	}
	
	public function SetLanguage($languageCode)
	{
		$this->SetCurrentLanguage($languageCode);
	}
	
	public function GetString($key, $args = array())
	{
		if (!is_array($args))
		{
			$args = array($args);
		}

		$strings = $this->_lang->Strings;
		
		$return = '';
		
		if (!isset($strings[$key]) || empty($strings[$key]))
		{
			return '?';
		}
			
		if (empty($args))
		{
			return $strings[$key];
		}
		else
		{
			$sprintf_args = '';
			
			for ($i = 0; $i < count($args); $i++)
			{
				$sprintf_args .= "'" . addslashes($args[$i]) . "',";
			}
	
			$sprintf_args = substr($sprintf_args, 0, strlen($sprintf_args) - 1);
			$string = addslashes($strings[$key]);
			$return = eval("return sprintf('$string', $sprintf_args);");
			return $return;
		}
	}
	
	public function GetDateFormat($key)
	{
		if (array_key_exists($key, $this->systemDateKeys))
		{
			return $this->systemDateKeys[$key];
		}
		
		$dates = $this->_lang->Dates;
			
		if (!isset($dates[$key]) || empty($dates[$key]))
		{
			return '?';
		}
		
		return $dates[$key];
	}
	
	public function GeneralDateFormat()
	{
		return $this->GetDateFormat(ResourceKeys::DATE_GENERAL);
	}
	
	public function GeneralDateTimeFormat()
	{
		return $this->GetDateFormat(ResourceKeys::DATETIME_GENERAL);
	}
	
	public function GetDays($key)
	{
		$days = $this->_lang->Days;
		
		if (!isset($days[$key]) || empty($days[$key]))
		{
			return '?';
		}
		
		return $days[$key];
	}
	
	public function GetMonths($key)
	{
		$months = $this->_lang->Months;
		
		if (!isset($months[$key]) || empty($months[$key]))
		{
			return '?';
		}
		
		return $months[$key];
	}
	
	private function SetCurrentLanguage($languageCode)
	{
		$languageCode = strtolower($languageCode);
		if (isset($this->AvailableLanguages[$languageCode]) && file_exists($this->LanguageDirectory . $this->AvailableLanguages[$languageCode]->LanguageFile))
		{
			$languageSettings = $this->AvailableLanguages[$languageCode];
			$this->LanguageFile = $languageSettings->LanguageFile;			
			
			require_once($this->LanguageDirectory . $this->LanguageFile);
			
			$class = $languageSettings->LanguageClass;
			$this->_lang = new $class;
			$this->CurrentLanguage = $languageCode;
			$this->Charset = $this->_lang->Charset;
			$this->HtmlLang = $this->_lang->HtmlLang;
		}
	}
	
	private function GetLanguageCode()
	{
		$cookie = ServiceLocator::GetServer()->GetCookie(CookieKeys::LANGUAGE);
		if ($cookie != null)
		{
			return $cookie;
		}
		else
		{
			return Configuration::Instance()->GetKey(ConfigKeys::LANGUAGE);
		}
	}
	
	private function LoadAvailableLanguages()
	{
		$this->AvailableLanguages = array(
			'en_us' => new AvailableLanguage('en_us', 'en([-_]us)?|english', 'en_us.php', 'English US'),
			'en_gb' => new AvailableLanguage('en_gb', 'en([-_]gb)?|english', 'en_gb.php', 'English GB')
		);
	}
}
?>