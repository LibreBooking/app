<?php
require_once('SecurePage.php');

class ControlPanelPage extends SecurePage
{
	public function __construct(Server &$server)
	{
		$title = sprintf('phpScheduleIt - %s', Resources::GetInstance($server)->GetString('My Control Panel'));
		parent::__construct($title, $server, $smarty);
	}
}
?>