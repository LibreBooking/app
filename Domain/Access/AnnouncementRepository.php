<?php
require_once (ROOT_DIR . 'Domain/Announcement.php');

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
        $announcements = array();

        $reader = ServiceLocator::GetDatabase()->Query(new GetAllAnnouncementsCommand());

        while ($row = $reader->GetRow())
        {
            $announcements[] = Announcement::FromRow($row);
        }

        $reader->Free();

        return $announcements;
	}

    /**
     * @param Announcement $announcement
     */
    public function Add(Announcement $announcement)
    {
        // TODO: Implement Add() method.
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

    /**
     * @abstract
     * @param Announcement $announcement
     */
    public function Add(Announcement $announcement);
}
?>