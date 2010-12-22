<?php
require_once(ROOT_DIR . 'Presenters/DashboardPresenterBase.php');
require_once(ROOT_DIR . 'Domain/Announcements.php');

class AnnouncementPresenter extends DashboardPresenterBase
{
	private $_control;
	private $_announcements;
	
	/**
	 * @param IAnnouncementsControl $control the control to populate
	 * @param IAnnouncements $announcements Announcements domain object
	 */
	public function __construct(IAnnouncementsControl $control, $announcements = null)
	{
		$this->_control = $control;
		
		$this->_announcements = $announcements;
		if (is_null($announcements))
		{
			$this->_announcements = new Announcements();
		}
	}
	
	public function PageLoad()
	{
		$this->PopulateAnnouncements();
	}
	
	private function PopulateAnnouncements()
	{
		$this->_control->SetAnnouncements($this->_announcements->GetFuture(), DashboardWidgets::ANNOUNCEMENTS);
		$this->_control->SetAnnouncementsVisible($this->GetDashboardVisibility(DashboardWidgets::ANNOUNCEMENTS));
	}
}