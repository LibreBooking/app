<?php

require_once(ROOT_DIR . 'tests/AllTests.php');

class PresentersSearch_Suite
{
	public static function suite()
    {
    	return TestHelper::GetSuite('tests/Presenters/Search');
    }
}
