<?php

require_once(ROOT_DIR . 'tests/AllTests.php');

class WebServices_Validators_Suite
{
	public static function suite()
    {
    	return TestHelper::GetSuite('tests/WebServices/Validators', array(__CLASS__, "IsIgnored"));
    }

    public static function IsIgnored($fileName)
    {
    	return false;
    }
}
