<?php
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Database/Commands/namespace.php');

class DashboardPresenter
{
	private $_page;
	
	public function __construct(IDashboardPage $page)
	{
		$this->_page = $page;
	}
	
	public function PageLoad()
	{
		$this->PopulateAnnouncements();
	}
	
	private function PopulateAnnouncements()
	{
		// Move this to a domain object
		
		$announcements = array();
		
		$reader = ServiceLocator::GetDatabase()->Query(new GetDashboardAnnouncementsCommand(Date::Now()));

		while ($row = $reader->GetRow())
		{
			$announcements[] = $row[ColumnNames::ANNOUNCEMENT_TEXT];
		}
		
		$reader->Free();
		
		$this->_page->SetAnnouncements($announcements, DashboardWidgets::ANNOUNCEMENTS);
		$this->_page->SetAnnouncementsVisible($this->GetDashboardVisibility(DashboardWidgets::ANNOUNCEMENTS));
	}
	
	private function GetDashboardVisibility($widgetId)
	{
		$cookie = ServiceLocator::GetServer()->GetCookie('dashboard_' . $widgetId);
		if (empty($cookie))
		{
			return true;
		}
		
		$converter = new BooleanConverter();
		return $converter->Convert($cookie);
	}
}

class DashboardWidgets
{
	const ANNOUNCEMENTS = 'announcementsDash';
}
?>