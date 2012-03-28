<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

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
			$this->phpMailer->Port = $this->Config('smtp.port', new IntConverter());
			$this->phpMailer->SMTPSecure = $this->Config('smtp.secure');
			$this->phpMailer->SMTPAuth = $this->Config('smtp.auth', new BooleanConverter());
			$this->phpMailer->Username = $this->Config('smtp.username');
			$this->phpMailer->Password = $this->Config('smtp.password');
			$this->phpMailer->Sendmail = $this->Config('sendmail.path');
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
		
		$to = $this->ensureArray($emailMessage->To());
		$toAddresses = new StringBuilder();
		foreach ($to as $address)
		{
			$toAddresses->Append($address->Address());
			$this->phpMailer->AddAddress($address->Address(), $address->Name());
		}

		$cc = $this->ensureArray($emailMessage->CC());
		foreach ($cc as $address)
		{
			$this->phpMailer->AddCC($address->Address(), $address->Name());
		}
		
		$bcc = $this->ensureArray($emailMessage->BCC());
		foreach ($bcc as $address)
		{
			$this->phpMailer->AddBCC($address->Address(), $address->Name());
		}
		
		Log::Debug('Sending %s email to: %s from: %s', get_class($emailMessage), $toAddresses->ToString(), $from->Address());

		$success = false;
		try
		{
			$success = $this->phpMailer->Send();
		}
		catch(Exception $ex)
		{
			Log::Error('Failed sending email. Exception: %s', $ex);
		}
		
		Log::Debug('Email send success: %d. %s', $success, $this->phpMailer->ErrorInfo);
	}

	/**
	 * @param $key
	 * @param IConvert|null $converter
	 * @return mixed|string
	 */
	private function Config($key, $converter = null)
	{
		return Configuration::Instance()->GetSectionKey('phpmailer', $key, $converter);
	}

	/**
	 * @param $possibleArray array|EmailAddress[]
	 * @return array|EmailAddress[]
	 */
	private function ensureArray($possibleArray)
	{
		if (is_array($possibleArray))
		{
			return $possibleArray;
		}

		return array($possibleArray);
	}
}

class NullEmailService implements IEmailService
{
	/**
	 * @param IEmailMessage $emailMessage
	 */
	function Send(IEmailMessage $emailMessage)
	{
		// no-op
	}
}
?>