<?php

require_once(ROOT_DIR . 'tests/AllTests.php');

class Presenters_Reports_Suite
{
	public static function suite()
    {
    	return TestHelper::GetSuite('tests/Presenters/Reports', array(__CLASS__, "IsIgnored"));
    }

    public static function IsIgnored($fileName)
    {
    	return false;
    }
}
?>
