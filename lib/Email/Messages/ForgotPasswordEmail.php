<?php
require_once(ROOT_DIR . 'lib/Email/namespace.php');
require_once(ROOT_DIR . 'Domain/namespace.php');


class ForgotPasswordEmail extends EmailMessage
{
	/**
	 * @var \User
	 */
	private $user;

	/**
	 * @var string
	 */
	private $temporaryPassword;

	public function __construct(User $user, $temporaryPassword)
	{
		parent::__construct($user->Language());

		$this->user = $user;
		$this->temporaryPassword = $temporaryPassword;
	}
	
	/**
	 * @return EmailAddress[]
	 */
	function To()
	{
		return new EmailAddress($this->user->EmailAddress(), $this->user->FullName());
	}

	/**
	 * @return string
	 */
	function Subject()
	{
		return $this->Translate('ResetPassword');
	}

	/**
	 * @return string
	 */
	function Body()
	{
		$this->Set('TemporaryPassword', $this->temporaryPassword);
		return $this->FetchTemplate('ResetPassword.tpl');
	}
}

?>
