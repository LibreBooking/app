<?php
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class ForgotPwdPresenter
{
	private $_page = null;
		
	public function __construct(IForgotPwdPage $page)
	{
		$this->_page = $page;
	}
		
	public function PageLoad()
	{			
		if ($this->_page->ResetClicked())
		{
			$this->SendRandomPassword();
			// TODO Say something nice about the password generation, then redirect to login page for retry
			$this->_page->Redirect(Pages::LOGIN); 
		}
		else 
		{
			// TODO? Just load the page and wait, I guess.
		}
	}
	
	public function SendRandomPassword()
	{
		// TODO, generate random password and send it by email
	}
}
?>
