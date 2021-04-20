<?php

require_once(ROOT_DIR . 'tests/AllTests.php');

class Domain_Announcement_Suite
{
	public static function suite()
    {
    	return TestHelper::GetSuite('tests/Domain/Announcement', array(__CLASS__, "IsIgnored"));
    }

    public static function IsIgnored($fileName)
    {
    	return false;
    }
}
