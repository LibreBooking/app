<?php
class PasswordValidator extends ValidatorBase implements IValidator 
{
	/**
	 * @var User
	 */
	private $user;

	/**
	 * @param string $currentPasswordPlainText
	 * @param User $user
	 */
	public function __construct($currentPasswordPlainText, User $user)
	{
		$this->currentPasswordPlainText = $currentPasswordPlainText;
		$this->user = $user;
	}

	public function Validate()
	{
		$pw = new Password($this->currentPasswordPlainText, $this->user->password);
		$this->isValid = $pw->Validate($this->user->passwordSalt);
	}
}

?>