<?php
require_once(ROOT_DIR . 'Pages/LoginPage.php');
require_once(ROOT_DIR . 'Presenters/LoginPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');

class LogoutPage extends LoginPage
{
	/**
	 * @var LoginPresenter
	 */
	private $_presenter = null;

	public function __construct()
	{
		$this->_presenter = new LoginPresenter($this);
	}

	public function PageLoad()
	{
		$this->_presenter->Logout();
	}
}
?>