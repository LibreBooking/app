<?php                              
require_once($root . 'lib/Common/namespace.php');

class Cookie
{
	public $Name;
	public $Value;
	public $Expiration;
	public $Path;
	
	public function __construct($name, $value, $expiration = null, $path = null)
	{
		if (is_null($expiration))
		{
//			$date = new Date();//Date::::Now();
//			$date->addSpan(new Date_Span(30, '%D'));
//			$expiration =$date->getDate(DATE_FORMAT_UNIXTIME);
			$expiration = Date::Now()->AddDays(30)->TimeStamp();
		}
		
		if (is_null($path))
		{
			$path = '';
		}
		
		$this->Name = $name;
		$this->Value = $value;
		$this->Expiration = date(DATE_COOKIE, $expiration);
		$this->Path = $path;
	}
	
	public function __toString()
	{
		return sprintf('%s %s %s %s', $this->Name, $this->Value, $this->Expiration, $this->Path);
	}
}
?>