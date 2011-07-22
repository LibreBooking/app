<?php
require_once(ROOT_DIR . 'Pages/SecurePage.php');

class OpeningsPage extends SecurePage
{
	public function __construct()
	{
	    parent::__construct('FindAnOpening');
	}

	public function PageLoad()
	{
		$this->Display('openings.tpl');
	}
}

?>