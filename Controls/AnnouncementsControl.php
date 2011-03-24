<?php
require_once(ROOT_DIR . 'Controls/Dashboard/DashboardItem.php');
require_once(ROOT_DIR . 'Presenters/AnnouncementPresenter.php');

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
	
	public function SetAnnouncements($announcements, $widgetId)
	{
		$this->Assign('Announcements', $announcements);	
		$this->Assign('AnnouncementsId', $widgetId);
	}
	
	public function SetAnnouncementsVisible($isVisible)
	{
		$this->Assign('AnnouncementsDisplayStyle', $isVisible ? 'inline' : 'none');
	}
}

interface IAnnouncementsControl
{
	public function SetAnnouncements($announcements, $widgetId);
	public function SetAnnouncementsVisible($isVisible);
}


?>