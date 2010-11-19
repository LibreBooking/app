<?php
abstract class EmailMessage implements IEmailMessage
{
	/**
	 * @var SmartyEmail
	 */
	protected $email;
	
	protected function __construct($languageCode = null)
	{
		$this->email = new SmartyEmail($languageCode);
	}
	
	protected function Set($var, $value)
	{
		$this->email->assign($var, $value);
	}
	
	protected function FetchTemplate($templateName)
	{
		return $this->email->FetchTemplate("ReservationCreated.tpl"); 
	}
	
	protected function Translate($key, $args = array())
	{
		return $this->email->Translate($key, $args);
	}
	
	public function ReplyTo()
	{
		return $this->From();
	}

	public function From()
	{
		return new EmailAddress(Configuration::Instance()->GetKey(ConfigKeys::ADMIN_EMAIL));
	}
	
	public function CC()
	{
		return array();
	}
	
	public function BCC()
	{
		return array();
	}
	
	public function Charset()
	{
		return $this->email->get_template_vars('Charset');
	}
}
?>