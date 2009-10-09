<?php
require_once(ROOT_DIR . 'Controls/Control.php');
require_once(ROOT_DIR . 'Presenters/AnnouncementPresenter.php');

class AnnouncementsControl extends Control implements IAnnouncementsControl
{
	public function __construct(SmartyPage $smarty)
	{
		parent::__construct($smarty);
		$this->_presenter = new AnnouncementPresenter($this);
	}
	
	public function PageLoad()
	{
		$this->_presenter->PageLoad();
		$this->smarty->display('announcements.tpl');	
	}
	
	public function SetAnnouncements($announcements, $widgetId)
	{
		$this->smarty->assign('Announcements', $announcements);	
		$this->smarty->assign('AnnouncementsId', $widgetId);
	}
	
	public function SetAnnouncementsVisible($isVisible)
	{
		$this->smarty->assign('AnnouncementsDisplayStyle', $isVisible ? 'inline' : 'none');
	}
}

interface IAnnouncementsControl
{
	public function SetAnnouncements($announcements, $widgetId);
	public function SetAnnouncementsVisible($isVisible);
}
?>