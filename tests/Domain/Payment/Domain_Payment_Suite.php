<?php

require_once(ROOT_DIR . 'tests/AllTests.php');

class Domain_Payment_Suite
{
	public static function suite()
    {
    	return TestHelper::GetSuite('tests/Domain/Payment', array(__CLASS__, "IsIgnored"));
    }

    public static function IsIgnored($fileName)
    {
    	return false;
    }
}
