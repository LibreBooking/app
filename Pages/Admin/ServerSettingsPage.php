<?php
require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');

class ServerSettingsPage extends AdminPage
{
	public function __construct()
	{
	    parent::__construct('ServerSettings');
	}
	
	public function PageLoad()
	{
		$this->Set('currentTime', date('Y-m-d, H:i:s (e P)'));

		$this->Display('server_settings.tpl');
	}

	function ProcessAction()
	{
		// no actions
	}
}

?>
