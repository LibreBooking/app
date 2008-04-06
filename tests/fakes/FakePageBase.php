<?php
require_once(ROOT_DIR . 'Pages/IPage.php');

class FakePageBase implements IPage
{
	public $_RedirectCalled = false;
	public $_RedirectDestination = '';
	public $_IsPostBack = false;
	public $_IsValid = true;
	public $_Validators = array();
	
	public function Redirect($destination)
	{
		$this->_RedirectCalled = true;
		$this->_RedirectDestination = $destination;
	}
	
	public function IsPostBack()
	{
		return $this->_IsPostBack;
	}
	
	public function IsValid()
	{
		return $this->_IsValid;
	}
	
	public function RegisterValidator($validatorId, $validator)
	{
		$this->_Validators[$validatorId] = $validator;
	}
}