<?php 
require_once(ROOT_DIR . 'tests/AllTests.php');

class PresenterSuite
{
	public static function suite()
    {
    	return TestHelper::GetSuite('tests/PresenterTests');
    }
}
?>