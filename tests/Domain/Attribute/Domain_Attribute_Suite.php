<?php

require_once(ROOT_DIR . 'tests/AllTests.php');

class Domain_Attribute_Suite
{
	public static function suite()
    {
    	return TestHelper::GetSuite('tests/Domain/Attribute', array(__CLASS__, "IsIgnored"));
    }

    public static function IsIgnored($fileName)
    {
    	return false;
    }
}
