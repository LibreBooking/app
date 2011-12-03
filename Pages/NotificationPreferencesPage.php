<?php

require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/NotificationPreferencesPresenter.php');

interface INotificationPreferencesPage extends IPage
{
}

class NotificationPreferencesPage extends SecurePage implements INotificationPreferencesPage
{
	/**
	 * @var NotificationPreferencesPresenter
	 */
	private $presenter;
	
	public function __construct()
	{
	    parent::__construct('EditProfile');
		$this->presenter = new NotificationPreferencesPresenter($this, new UserRepository());
	}

	public function PageLoad()
	{
		$this->presenter->PageLoad();
		$this->Display('notification-preferences.tpl');
	}
}

?>