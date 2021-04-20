<?php

require_once(ROOT_DIR . 'tests/AllTests.php');
require_once(ROOT_DIR . 'tests/TestHelper.php');

class Application_Admin_Suite
{
	public static function suite()
    {
    	return TestHelper::GetSuite('tests/Application/Admin', array(__CLASS__, "IsIgnored"));
    }

    public static function IsIgnored($fileName)
    {
    	return false;
    }
}
