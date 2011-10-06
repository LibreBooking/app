<?php 
require_once(ROOT_DIR . 'tests/AllTests.php');

class Plugins_Auth_Ldap_Suite
{
	public static function suite()
    {
    	return TestHelper::GetSuite('tests/Plugins/Authentication/Ldap', array(__CLASS__, "IsIgnored"));
    }
    
    public static function IsIgnored($fileName)
    {
    	return false;
    }
}
?>