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
		if ($this->TakingAction())
		{
			$this->ProcessAction();
		}
		
		$uploadDir = ROOT_DIR . Configuration::Instance()->GetKey(ConfigKeys::IMAGE_UPLOAD_DIRECTORY);

		$this->Set('currentTime', date('Y-m-d, H:i:s (e P)'));
		$this->Set('imageUploadDirPermissions', substr(sprintf('%o', fileperms($uploadDir)), -4));
		$this->Set('imageUploadDirectory', Configuration::Instance()->GetKey(ConfigKeys::IMAGE_UPLOAD_DIRECTORY));
		$this->Display('server_settings.tpl');
	}

	function ProcessAction()
	{
		$uploadDir = ROOT_DIR . Configuration::Instance()->GetKey(ConfigKeys::IMAGE_UPLOAD_DIRECTORY);
		$chmodResult = chmod($uploadDir, 0770);
	}
}

?>