<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

require_once(ROOT_DIR . 'Domain/Access/AnnouncementRepository.php');

class FakeAnnouncementRepository implements IAnnouncementRepository
{
	public $_GetFutureCalled = false;
	public $_ExpectedAnnouncements;
	
	public function __construct()
	{
		$this->_ExpectedAnnouncements = $this->GetExpectedRows();
	}
	
	public function GetRows()
	{
		return array(
			array (ColumnNames::ANNOUNCEMENT_TEXT => 'announcement 1'),
			array (ColumnNames::ANNOUNCEMENT_TEXT => 'announcement 2'),
			array (ColumnNames::ANNOUNCEMENT_TEXT => 'announcement 3')
		);
	}
	
	public function GetFuture()
	{
		$this->_GetFutureCalled = true;
		return $this->_ExpectedAnnouncements;
	}
	
	public function GetExpectedRows()
	{
		$expectedAnnouncements = array();
		$rows = $this->GetRows();
		foreach($rows as $item)
		{
			$expectedAnnouncements[] = $item[ColumnNames::ANNOUNCEMENT_TEXT];
		}
		
		return $expectedAnnouncements;
	}

    /**
     * @return Announcement[]|array
     */
    public function GetAll()
    {
    }

	/**
	 * @param Announcement $announcement
	 */
	public function Add(Announcement $announcement)
	{
	}

    /**
     * @param int $announcementId
     */
    public function Delete($announcementId)
    {
    }

    /**
     * @param Announcement $announcement
     */
    public function Update(Announcement $announcement)
    {
    }

    /**
     * @param int $announcementId
     * @return Announcement
     */
    public function LoadById($announcementId)
    {
    }
}
?>