<?php 
require_once(ROOT_DIR . 'tests/AllTests.php');

class Application_Resource_Suite
{
	public static function suite()
    {
    	return TestHelper::GetSuite('tests/Application/Resource');
    }
}
?>