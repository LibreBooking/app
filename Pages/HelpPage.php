<?php
require_once(ROOT_DIR . 'Pages/Page.php');

class HelpPage extends Page
{
	public function __construct()
	{
		parent::__construct('Help');
	}

	public function PageLoad()
	{
		$this->DisplayLocalized('help.tpl');
	}
}
?>