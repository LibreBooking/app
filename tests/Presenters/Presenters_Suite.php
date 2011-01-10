<?php 
require_once(ROOT_DIR . 'tests/AllTests.php');

class Presenters_Suite
{
	public static function suite()
    {
    	return TestHelper::GetSuite('tests/Presenters', array(__CLASS__, "IsIgnored"));
    }
    
    public static function IsIgnored($fileName)
    {
    	return strpos($fileName, 'Dashboard') === 0;
    }
}
?>