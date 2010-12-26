<?php 
require_once(ROOT_DIR . 'tests/AllTests.php');

class PresenterSuite
{
	public static function suite()
    {
    	return TestHelper::GetSuite('tests/PresenterTests', array('PresenterSuite', 'IsIgnored'));
    }
    
    public static function IsIgnored($fileName)
    {
    	return strpos($fileName, 'Dashboard') == 0;
    }
}
?>