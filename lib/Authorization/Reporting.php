<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');

interface IReporting
{
	/**
	 * @param string $firstName
	 * @param string $lastName 
	 * @param string $username 
	 * @param string $organization
	 * @param string $group 
	 */
  public function Reporting($firstName, $lastName, $username, $organization, $group);
	
}

class Reporting implements IReporting 
{
	private $_passwordEncryption;
	
	public function __construct($passwordEncryption = null)
	{
		$this->_passwordEncryption = $passwordEncryption;
		
		if ($passwordEncryption == null)
		{
			$this->_passwordEncryption = new PasswordEncryption();
		}
	}
	
	public function Reporting($firstName, $lastName, $username, $organization, $group)
	{
				
		$formSettingsCommand = new ReportingCommand(
					$firstName, $lastName, $username, $organization, $group
					);
					
		$userId = ServiceLocator::GetDatabase()->ExecuteInsert($formSettingsCommand);
	}
}
?>