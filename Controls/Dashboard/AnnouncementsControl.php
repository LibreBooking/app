<?php
require_once(ROOT_DIR . 'Controls/Dashboard/DashboardItem.php');
require_once(ROOT_DIR . 'Presenters/Dashboard/AnnouncementPresenter.php');

class AnnouncementsControl extends DashboardItem implements IAnnouncementsControl
{
	public function __construct(SmartyPage $smarty)
	{
		parent::__construct($smarty);
		$this->_presenter = new AnnouncementPresenter($this);
	}
	
	public function PageLoad()
	{
		$this->_presenter->PageLoad();
		$this->Display('announcements.tpl');	
	}
	
	public function SetAnnouncements($announcements)
	{
		$this->Assign('Announcements', $announcements);	
	}
}

interface IAnnouncementsControl
{
	public function SetAnnouncements($announcements);
}


?>