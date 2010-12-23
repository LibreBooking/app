<?php 
require_once(ROOT_DIR . 'tests/AllTests.php');

class DatabaseSuite
{
	public static function suite()
    {
    	return TestHelper::GetSuite('tests/Infrastructure/Database', array('DatabaseSuite', "IsIgnored"));
    }
    
    public static function IsIgnored($fileName)
    {
    	return strstr($fileName, 'Mdb2');
    }
}
?>