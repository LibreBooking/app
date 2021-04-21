<?php

require_once(ROOT_DIR . 'tests/AllTests.php');

class AdminPresenters_Suite
{
	public static function suite()
    {
    	return TestHelper::GetSuite('tests/Presenters/Admin');
    }
}
?>
