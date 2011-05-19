<?php
interface IResourceLocalization
{
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
	
	protected $LanguageDirectory;
	
	private static $_instance;
	
	/**
	 * @var Language
	 */
	private $_lang;
	
	public function __construct()
	{	
		$this->LanguageDirectory = dirname(__FILE__) . '/../../lang/';
		
		$this->LoadAvailableLanguages();
	}
	
	private static function Create()
	{
		$resources = new Resources();
		$resources->SetCurrentLanguage($resources->GetLanguageCode());
		return $resources;
	}
	
	/**
	 * @return IResourceLocalization
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
			//'ca' => new AvailableLanguage('ca', 'ca([-_][[:alpha:]]{2})?|catalan','ca.lang.php', 'Catal&agrave;'),
			'zh_TW' => new AvailableLanguage('zh_tw', 'zh([-_]tw)?|chinese', 'zh_TW.lang.php', 'Chinese Traditional (&#x6b63;&#x9ad4;&#x4e2d;&#x6587)'),
			'cs' => new AvailableLanguage('cs', 'cs([-_][[:alpha:]]{2})?|czech', 'cs.lang.php', 'Czech (&#x010c;esky)'),
			'de' => new AvailableLanguage('de', 'de([-_][[:alpha:]]{2})?|german', 'de.lang.php', 'Deutsch'),
			'en_us' => new AvailableLanguage('en_us', 'en([-_]us)?|english', 'en_us.php', 'English US'),
			'en_gb' => new AvailableLanguage('en_gb', 'en([-_]gb)?|english', 'en_gb.php', 'English GB'),
			'es' => new AvailableLanguage('es', 'es([-_][[:alpha:]]{2})?|spanish', 'es.lang.php', 'Espa&ntilde;ol'),
			'fr' => new AvailableLanguage('fr', 'fr([-_][[:alpha:]]{2})?|french', 'fr.lang.php', 'Fran&ccedil;ais'),
			'el' => new AvailableLanguage('el', 'el([-_][[:alpha:]]{2})?|greek', 'el.lang.php', 'Greek (&#x0395;&#x03bb;&#x03bb;&#x03b7;&#x03bd;&#x03b9;&#x03ba;&#x03ac;)'),
			'it' => new AvailableLanguage('it', 'it([-_][[:alpha:]]{2})?|italian', 'it.lang.php', 'Italiano'),
			//'ko' => new AvailableLanguage('ko', 'ko([-_][[:alpha:]]{2})?|korean', 'ko.lang.php', 'Korean'),
			'hu' => new AvailableLanguage('hu', 'hu([-_][[:alpha:]]{2})?|hungarian', 'hu.lang.php', 'Magyar'),
			'nl' => new AvailableLanguage('nl', 'nl([-_][[:alpha:]]{2})?|dutch', 'nl.lang.php', 'Nederlands'),
			'pt_PT' => new AvailableLanguage('pt_pt', 'pr([-_]PT)|portuguese', 'pt_PT.lang.php', 'Portugu&ecirc;s'),
			'pt_BR' => new AvailableLanguage('pt_br', 'pr([-_]BR)|portuguese', 'pt_BR.lang.php', 'Portugu&ecirc;s Brasileiro'),
			'ru' => new AvailableLanguage('ru', 'ru([-_][[:alpha:]]{2})?|russian', 'ru.lang.php', 'Russian (&#x0420;&#x0443;&#x0441;&#x0441;&#x043a;&#x0438;&#x0439;)'),
			'sk' => new AvailableLanguage('sk', 'sk([-_][[:alpha:]]{2})?|slovakian', 'sk.lang.php', 'Slovak (Sloven&#x010d;ina)'),
			'sl' => new AvailableLanguage('sl', 'sl([-_][[:alpha:]]{2})?|slovenian', 'sl.lang.php', 'Slovensko'),
			'fi' => new AvailableLanguage('fi', 'fi([-_][[:alpha:]]{2})?|finnish', 'fi.lang.php', 'Suomi'),
			'sv' => new AvailableLanguage('sv', 'sv([-_][[:alpha:]]{2})?|swedish', 'sv.lang.php', 'Swedish'),
			'tr' => new AvailableLanguage('tr', 'fi([-_][[:alpha:]]{2})?|turkish', 'tr.lang.php', 'T&uuml;rk&ccedil;e')
		);
	}
	
	private function GetCalendarLanguageFile()
	{
		$incomplete_translations = array ('tr');
		
		$file = "calendar-{$this->CurrentLanguage}.js";
		$base = dirname(__FILE__) . '/../..';
		if ( (array_search($this->CurrentLanguage, $incomplete_translations) !== false) || !file_exists("$base/jscalendar/lang/$file") )
		{
			$file = "calendar-en.js";
		}
		return $file;
	}
}
?>