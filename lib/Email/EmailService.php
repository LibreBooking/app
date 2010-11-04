<?php
require_once(ROOT_DIR . 'lib/Email/namespace.php');
require_once(ROOT_DIR . 'lib/external/phpmailer/class.phpmailer.php');

class EmailService implements IEmailService
{
	/**
	 * @var PHPMailer
	 */
	private $phpMailer;
	
	public function __construct($phpMailer = null)
	{
		$this->phpMailer = $phpMailer;
		
		if (is_null($phpMailer))
		{
			$this->phpMailer = new PHPMailer();
			$this->phpMailer->IsHTML(true);
			$this->phpMailer->Mailer = $this->Config('mailer');
			$this->phpMailer->Host = $this->Config('smtp.host');
			$this->phpMailer->Port = $this->Config('smtp.port');
			$this->phpMailer->SMTPSecure = $this->Config('smtp.secure');
			$this->phpMailer->SMTPAuth = $this->Config('smtp.auth');
			$this->phpMailer->Username = $this->Config('smtp.username');
			$this->phpMailer->Password = $this->Config('smtp.password');
		}
	}
	
	public function Send(IEmailMessage $emailMessage)
	{
		// charset
		// subject
		// body
		// to list
		// from
		// cc list
		throw Exception('not implemented');
	}
	
	private function Config($key)
	{
		return Configuration::Instance()->GetSectionKey('phpmailer', $key);
	}
}
?>