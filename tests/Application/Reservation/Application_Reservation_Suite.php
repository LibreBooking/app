<?php 
require_once(ROOT_DIR . 'tests/AllTests.php');

class Application_Reservation_Suite
{
	public static function suite()
    {
    	return TestHelper::GetSuite('tests/Application/Reservation', array(__CLASS__, "IsIgnored"));
    }
    
    public static function IsIgnored($fileName)
    {
    	return false;
    }
}
?>