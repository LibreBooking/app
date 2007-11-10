<?php
require_once('PHPUnit/Framework.php');
require_once('../lib/Common/namespace.php');

class DateTests extends PHPUnit_Framework_TestCase
{
	public function testCanGetNow()
	{
		$format = 'd m y H:i:s';
		
		$now = Date::Now();
		$datenow = date($format);
		
		$this->assertEquals($datenow, $now->Format($format));
	}
	
	public function testCanAddDays()
	{
		$format = 'd m y H:i:s';
		
		$now = Date::Now();
		
		$twentyDays = mktime($now->Hour(), $now->Minute(), $now->Second(), $now->Month(), $now->Day() + 20, $now->Year());
		$datenow = date($format, $twentyDays);
		
		$twentyDaysDate = $now->AddDays(20);
		
		$this->assertEquals($datenow, $twentyDaysDate->Format($format));		
	}
	
	public function testCanGetAsDateTime()
	{
		$now = new Date(date());
		$datenow = date();
		
		$this->assertEquals($datenow, $now->DateTime());
	}
}
?>