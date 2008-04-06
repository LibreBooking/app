<?php
require_once(ROOT_DIR . 'Pages/SecurePage.php');

class ControlPanelPage extends SecurePage implements IControlPanelPage
{
	public function __construct(Server &$server)
	{
		$title = sprintf('phpScheduleIt - %s', Resources::GetInstance($server)->GetString('My Control Panel'));
		parent::__construct($title, $server, $smarty);
	}
}

interface IControlPanelPage
{
	public function SetAnnouncements(&$announcements)
	{
		
	}
}
?>