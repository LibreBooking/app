<?php

require_once(ROOT_DIR . 'tests/AllTests.php');

class Presenters_Integrate_Suite
{
	public static function suite()
    {
    	return TestHelper::GetSuite('tests/Presenters/Integrate', array(__CLASS__, "IsIgnored"));
    }

    public static function IsIgnored($fileName)
    {
    	return false;
    }
}
