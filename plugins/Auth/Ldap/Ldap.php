<?php
require_once(ROOT_DIR . 'lib/Authorization/namespace.php');
require_once(ROOT_DIR . 'plugins/Auth/Ldap/ldap.config.php');

class Ldap extends Authorization implements IAuthorization
{
	public function __construct($authorization)
	{
		$this->authToDecorate = $authorization; 
	}
	
	public function Validate($username, $password)
	{
		//require_once 'Zend/Auth/Adapter/Ldap.php';
		
		$options = ConstructOptions();
		$adapter = new Zend_Auth_Adapter_Ldap($options, $username, $password);
		
		$result = $auth->authenticate($adapter);
	}
	
	public function Login($username, $persist)
	{
		// check for user in db, register if needed
	}
}
?>