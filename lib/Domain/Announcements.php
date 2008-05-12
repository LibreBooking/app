<?php
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Database/namespace.php');

class Announcements
{
	public function GetFuture() 
	{
		$announcements = array();
		
		$reader = ServiceLocator::GetDatabase()->Query(new GetDashboardAnnouncementsCommand(Date::Now()));

		while ($row = $reader->GetRow())
		{
			$announcements[] = $row[ColumnNames::ANNOUNCEMENT_TEXT];
		}
		
		$reader->Free();
		
		return $announcements;
	}
}

interface IAnnouncements
{
	/**
	 * Gets all announcements to be displayed for the user
	 * @return array list of announcement text values
	 */
	public function GetFuture();
}
?>