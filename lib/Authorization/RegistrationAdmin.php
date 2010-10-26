<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');

interface IRegistrationAdmin
{
	/**
	 * @param string $firstName setting
	 * @param string $lastName setting
	 * @param string $username setting
	 * @param string $email setting
	 * @param string $password setting
	 * @param string $organization selection setting
	 * @param string $group setting
	 * @param string $position setting
	 * @param string $address setting
	 * @param string $phone setting
	 * @param string $homepage selection setting
     * @param string $timezone selection setting
     * @param string $language preferred language code
	 */
  public function RegisterAdmin($firstName, $lastName, $username, $email, $password, $organization, $group, $position, $address, $phone, $homepage, $timezone, $language);
	
}

class RegistrationAdmin implements IRegistrationAdmin 
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
	
	public function RegisterAdmin($firstName, $lastName, $username, $email, $password, $organization, $group, $position, $address, $phone, $homepage, $timezone, $langauge)
	{
		$formSettingsCommand = new RegisterFormSettingsCommand(
					$firstName, $lastName, $username, $email, $password, 
					$organization, $group, $position, $address, $phone, 
					$homepage, $timezone, $language
					);
					
		$userId = ServiceLocator::GetDatabase()->ExecuteInsert($formSettingsCommand);
	}
}
?>