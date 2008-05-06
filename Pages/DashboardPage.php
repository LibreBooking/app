<?php
require_once(ROOT_DIR . 'Pages/SecurePage.php');

class ControlPanelPage extends SecurePage implements IControlPanelPage
{
	public function __construct(Server &$server)
	{
		parent::__construct('MyControlPanel');
	}
}

interface IControlPanelPage
{
	public function SetAnnouncements(&$announcements)
	{
		
	}
}
?>