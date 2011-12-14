<?php
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class AnnouncementPresenter
{
	private $_control;
	private $_announcements;
	
	/**
	 * @param IAnnouncementsControl $control the control to populate
	 * @param IAnnouncementRepository $announcements Announcements domain object
	 */
	public function __construct(IAnnouncementsControl $control, $announcements = null)
	{
		$this->_control = $control;
		
		$this->_announcements = $announcements;
		if (is_null($announcements))
		{
			$this->_announcements = new AnnouncementRepository();
		}
	}
	
	public function PageLoad()
	{
		$this->PopulateAnnouncements();
	}
	
	private function PopulateAnnouncements()
	{
		$this->_control->SetAnnouncements($this->_announcements->GetFuture());
	}
}