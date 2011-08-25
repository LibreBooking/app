<?php
/**
* All functions for determining and loading language files and for
*  translating the text
* A few ideas and techniques were taken from the phpMyAdmin project
* @author Nick Korbel <lqqkout13@users.sourceforge.net>
* @version 05-20-06
* @package Languages
*
* Copyright (C) 2003 - 2007 phpScheduleIt
* License: GPL, see LICENSE
*/

/**
* You must add the language information for the language that you are including to the
*   $languages array below.
* Please keep the language keys in alphabetical order.  The basic logic for this array
*  is from the phpMyAdmin project.
*
* 1) The first 2 letters are the official language code.
*
* 2) The array must follow this order:
*	The first element is a regular expression that validates against possible
*	ways to identify the language and is in this format:
*	+ The official language code and the dialect code (country code) if it is needed.
*	  For example for all English translations: en([-_][[:alpha:]]{2})?, for Bulgarian: 'bu'
*	  In any case where there is more than one dialect, it should follow the English format
*	  In any case where there is only one dialect, it should follow the Bulgarian format
*	+ the '|' character
*	+ the full language name (lowercase)
*	The second element is the full file name of this translation.  This file name should
*	  always be in the format: 2 letter language code, the word 'lang', the '.php' extension
*	  For example for all English translatinos: en.lang.php
*	The third element is the official two letter language code
*	The final element is the full language name.  This will appear in the language
*	  pull down selection menu on the login page.  Please capatalize the first letter
*
*	If you are unsure of your language/dialect codes, please use the following resources -
*	+ Standard language codes: http://www.unicode.org/unicode/onlinedat/languages.html
*	+ Standard country codes:  http://www.unicode.org/unicode/onlinedat/countries.html
*/

$languages = array (
	//'ca'	=> array('ca([-_][[:alpha:]]{2})?|catalan','ca.lang.php', 'ca', 'Catal&agrave;'),
	'zh_CN' => array('zh([-_]cn)?|chinese', 'zh_CN.lang.php', 'zh', 'Chinese Simplified (&#x7b80;&#x4f53;&#x4e2d;&#x6587;)'),
	'zh_TW'	=> array('zh([-_]tw)?|chinese', 'zh_TW.lang.php', 'zh', 'Chinese Traditional (&#x6b63;&#x9ad4;&#x4e2d;&#x6587;)'),
	'cs'	=> array('cs([-_][[:alpha:]]{2})?|czech', 'cs.lang.php', 'cs', 'Czech (&#x010c;esky)'),
	'de'	=> array('de([-_][[:alpha:]]{2})?|german', 'de.lang.php', 'de', 'Deutsch'),
	'en_US'	=> array('en([-_]us)?|english', 'en_US.lang.php', 'en', 'English US'),
	'en_GB'	=> array('en([-_]gb)?|english', 'en_GB.lang.php', 'en', 'English GB'),
	'es'	=> array('es([-_][[:alpha:]]{2})?|spanish', 'es.lang.php', 'es', 'Espa&ntilde;ol'),
	'fr'	=> array('fr([-_][[:alpha:]]{2})?|french', 'fr.lang.php', 'fr', 'Fran&ccedil;ais'),
	'el'	=> array('el([-_][[:alpha:]]{2})?|greek', 'el.lang.php', 'el', 'Greek (&#x0395;&#x03bb;&#x03bb;&#x03b7;&#x03bd;&#x03b9;&#x03ba;&#x03ac;)'),
	'it'	=> array('it([-_][[:alpha:]]{2})?|italian', 'it.lang.php', 'it', 'Italiano'),
	//'ko'	=> array('ko([-_][[:alpha:]]{2})?|korean', 'ko.lang.php', 'ko', 'Korean'),
	'hu'	=> array('hu([-_][[:alpha:]]{2})?|hungarian', 'hu.lang.php', 'hu', 'Magyar'),
	'nl'	=> array('nl([-_][[:alpha:]]{2})?|dutch', 'nl.lang.php', 'nl', 'Nederlands'),
	'pt_PT'	=> array('pr([-_]PT)|portuguese', 'pt_PT.lang.php', 'pt', 'Portugu&ecirc;s'),
	'pt_BR'	=> array('pr([-_]BR)|portuguese', 'pt_BR.lang.php', 'pt', 'Portugu&ecirc;s Brasileiro'),
	'ru'	=> array('ru([-_][[:alpha:]]{2})?|russian', 'ru.lang.php', 'ru', 'Russian (&#x0420;&#x0443;&#x0441;&#x0441;&#x043a;&#x0438;&#x0439;)'),
	'sk'	=> array('sk([-_][[:alpha:]]{2})?|slovakian', 'sk.lang.php', 'sk', 'Slovak (Sloven&#x010d;ina)'),
	'sl'	=> array('sl([-_][[:alpha:]]{2})?|slovenian', 'sl.lang.php', 'sl', 'Slovensko'),
	'fi'	=> array('fi([-_][[:alpha:]]{2})?|finnish', 'fi.lang.php', 'fi', 'Suomi'),
	'sv'	=> array('sv([-_][[:alpha:]]{2})?|swedish', 'sv.lang.php', 'sv', 'Swedish'),
	'tr'	=> array('fi([-_][[:alpha:]]{2})?|turkish', 'tr.lang.php', 'tr', 'T&uuml;rk&ccedil;e')
);

// Language files directory
@define('LANG_DIR', dirname(__FILE__) . '/../lang/');

/**
* Tries to determine the langauge for this user by
*  going though all options.
* @param none
* @return mixed language if it can be determined, or false if it cannot
*/
function determine_language() {
	global $conf;
	$lang = false;

	// Set the language
	if (isset($_GET['lang']) && !empty($_GET['lang'])) {
		$lang = $_GET['lang'];
	}
	else if (isset($_COOKIE['lang']) && !empty($_COOKIE['lang'])) {
		$lang = $_COOKIE['lang'];
	}
	else if (isset($_SESSION['lang']) && !empty($_SESSION['lang'])) {
		$lang = $_SESSION['lang'];
	}
	else if ($lang = get_browser_lang()) {
		// Do nothing, it's done in the if
	}
	else {
		$lang = $conf['app']['defaultLanguage'];
	}

	return $lang;
}

/**
* Loads the language file
* @param none
*/
function load_language_file($lang) {
	global $languages;

	// Load the language file
	if ( is_lang_valid($lang) ) {
		include_once(get_language_path($lang));
		global $charset;
		header("Content-Type: text/html; charset=$charset");
		header("Content-Language: {$languages[$lang][2]}");
	}
	else {
		die('Could not load language file: ' . $languages[$lang][1]);
		setcookie('lang', '', time() - 2592000, '/');
	}
}

/**
* Validates the language
* @param string $lang the language key to validate
* @return bool whether the lang is valid or not
*/
function is_lang_valid($lang) {
	global $languages;
	return isset($languages[$lang]) && file_exists(LANG_DIR . $languages[$lang][1]);
}

/**
* Returns the path to this language file
* @param string $lang the language key to get the file path for
* @return path to the language file
*/
function get_language_path($lang) {
	global $languages;
	return LANG_DIR . $languages[$lang][1];
}

/**
* Tries to detect the language based on the current browser settings
* @param none
* @return mixed language value if it can be found, false if it cannot be found
*/
function get_browser_lang() {
	global $languages;

	if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && !empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
		$http_accepted = split(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
		for ($i = 0; $i < count($http_accepted); $i++) {
			foreach ($languages as $lang => $vals) {
				if (eregi($vals[0], $http_accepted[$i]))
					return $lang;
			}
		}
	}

	return false;	// If we get here, it wasnt found
}

/**
* Sets the session variable for $lang so we do not need to go
*  through the determining process each time
* @param string $lang language of current user
*/
function set_language($lang) {
	global $languages;
	global $conf;

	if (!isset($languages[$lang])) {
		$lang = $conf['app']['defaultLanguage'];
	}

	@session_start();
	setlocale(LC_ALL, $lang);
	setcookie('lang', $lang, time() + 2592000, '/');
}

/**
* Translate the given string into the current lanaguage
* If the trasnlation does not exist, returns the default
*  lanaguage translation
* @param string $str string to translate
* @param array $vars optional array of variables to pass to a sprintf translation string
*/
function translate($str, $args = array()) {
	global $strings;

	$return = '';

	if (!isset($strings[$str]) || empty($strings[$str])) {
		return '?';
	}

	if (empty($args)) {
		return $strings[$str];
	}
	else {
		$sprintf_args = '';

		for ($i = 0; $i < count($args); $i++) {
			$sprintf_args .= "'" . addslashes($args[$i]) . "',";
		}

		$sprintf_args = substr($sprintf_args, 0, strlen($sprintf_args) - 1);
		$string = addslashes($strings[$str]);
		$return = eval("return sprintf('$string',$sprintf_args);");
		return $return;
	}
}

/**
* Translates an email message to the proper language
* @param string $email_index index of the email to translate from the lang.php file
* @param mixed unlimited number of arguments to be placed inline into the email
* @return translated email message
*/
function translate_email($email_index) {
	global $email;

	$return = '';
	$args = func_get_args();

	if (!isset($email[$email_index]) || empty($email[$email_index])) {
		return '?';
	}

	if (func_num_args() <= 1) {
		return $email[$email_index];
	}
	else {
		$sprintf_args = '';

		for ($i = 1; $i < count($args); $i++) {
			$sprintf_args .= "'" . addslashes($args[$i]) . "',";
		}

		$sprintf_args = substr($sprintf_args, 0, strlen($sprintf_args) - 1);
		$return = eval('return sprintf("' . str_replace('"','\"',$email[$email_index]) . "\",$sprintf_args);");
		return $return;
	}
}

/**
* Returns a formatted date for current section
* @param string $date_index index of date to get
* @return formatted date for that index
*/
function translate_date($date_index, $date) {
	global $dates;
	global $days_full;
	global $days_abbr;
	global $months_abbr;
	global $months_full;

	if (!isset($dates[$date_index]) || empty($dates[$date_index])) {
		return '?';
	}

	$date_format = $dates[$date_index];

	// This takes care of when day/month names are not translated by PHP
	if (strpos($date_format, '%a') !== false) {
		$date_format = str_replace('%a', '+d', $date_format);
		$day_name = $days_abbr[date('w', $date)];
	}
	if (strpos($date_format, '%A') !== false) {
		$date_format = str_replace('%A', '+d', $date_format);
		$day_name = $days_full[date('w', $date)];
	}
	if (strpos($date_format, '%b') !== false) {
		$date_format = str_replace('%b', '+m', $date_format);
		$month_name = $months_abbr[date('n', $date)-1];
	}
	if (strpos($date_format, '%B') !== false) {
		$date_format = str_replace('%B', '+m', $date_format);
		$month_name = $months_full[date('n', $date)-1];
	}

	$return = strftime($date_format, $date);

	if (isset($day_name)) {
		$return = str_replace('+d', $day_name, $return);
	}

	if (isset($month_name)) {
		$return = str_replace('+m', $month_name, $return);
	}

	return $return;
}

/**
* Returns the array of lanugages
* @param none
* @return array of languages
*/
function get_language_list() {
	global $languages;
	return $languages;
}

/**
* Determines if the proper jscalendar translation file is available
* If it is, then that is the file that is used for the jscalendar
*  if it is not, then we use the english lang file
* @return name of proper jscalendar/lang/calendar-*.js file
*/
function get_jscalendar_file() {
	global $languages;
	global $lang;

	$incomplete_translations = array ('tr');

	$_file = 'calendar-' . $languages[$lang][2] . '.js';
	$base = dirname(__FILE__) . '/..';
	if ( (array_search($languages[$lang][2], $incomplete_translations) !== false) || !file_exists("$base/jscalendar/lang/$_file")) {
		$_file = "calendar-en.js";
	}
	return $_file;
}
?>