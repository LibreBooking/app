<?php

require_once(ROOT_DIR . 'tests/AllTests.php');

class WebService_Suite
{
	public static function suite()
    {
    	return TestHelper::GetSuite('tests/WebService', array(__CLASS__, "IsIgnored"));
    }

    public static function IsIgnored($fileName)
    {
    	return false;
    }
}
?>
