<?php 
require_once(ROOT_DIR . 'tests/AllTests.php');

class Infrastructure_Common_Suite
{
	public static function suite()
    {
    	return TestHelper::GetSuite('tests/Infrastructure/Common', array('CommonSuite', "IsIgnored"));
    }
    
    public static function IsIgnored($fileName)
    {
    	return false;
    }
}
?>