<?php

class AnnouncementRepository implements IAnnouncementRepository
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

	public function GetAll()
	{
		throw new Exception('not implemented');
	}
}

interface IAnnouncementRepository
{
	/**
	 * Gets all announcements to be displayed for the user
	 * @return string[]|array list of announcement text values
	 */
	public function GetFuture();

	/**
	 * @abstract
	 * @return Announcement[]|array
	 */
	public function GetAll();
}
?>