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
		$this->phpMailer->CharSet = $emailMessage->Charset();
		$this->phpMailer->Subject = $emailMessage->Subject();
		$this->phpMailer->Body = $emailMessage->Body();
		
		$from = $emailMessage->From();
		$this->phpMailer->SetFrom($from->Address(), $from->Name());
		
		$replyTo = $emailMessage->ReplyTo();
		$this->phpMailer->AddReplyTo($replyTo->Address(), $replyTo->Name());
		
		$to = $emailMessage->To();
		$toAddresses = new StringBuilder();
		foreach ($to as $address)
		{
			$toAddresses->Append($address->Address());
			$this->phpMailer->AddAddress($address->Address(), $address->Name());
		}

		$cc = $emailMessage->CC();
		foreach ($cc as $address)
		{
			$this->phpMailer->AddCC($address->Address(), $address->Name());
		}
		
		$bcc = $emailMessage->BCC();
		foreach ($bcc as $address)
		{
			$this->phpMailer->AddBCC($address->Address(), $address->Name());
		}
		
		Log::Debug('Sending %s email to: %s from: %s', get_class($emailMessage), $toAddresses->ToString(), $from->Address());
		
		$success = $this->phpMailer->Send();
		
		Log::Debug('Send success: %d. %s', $success, $this->phpMailer->ErrorInfo);
	}
	
	private function Config($key)
	{
		return Configuration::Instance()->GetSectionKey('phpmailer', $key);
	}
}
?>