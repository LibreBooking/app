<?php
/**
Copyright 2011-2014 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

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
        ServiceLocator::GetDatabase()->ExecuteInsert(new AddAnnouncementCommand($announcement->Text(), $announcement->Start(), $announcement->End(), $announcement->Priority()));
    }

    /**
     * @param int $announcementId
     */
    public function Delete($announcementId)
    {
        ServiceLocator::GetDatabase()->Execute(new DeleteAnnouncementCommand($announcementId));
    }

    /**
     * @param int $announcementId
     * @return Announcement
     */
    public function LoadById($announcementId)
    {
        $announcement = null;
        $reader = ServiceLocator::GetDatabase()->Query(new GetAnnouncementByIdCommand($announcementId));

        if ($row = $reader->GetRow())
        {
            $announcement = Announcement::FromRow($row);
        }

        return $announcement;
    }

    public function Update(Announcement $announcement)
    {
        ServiceLocator::GetDatabase()->Execute(new UpdateAnnouncementCommand($announcement->Id(), $announcement->Text(), $announcement->Start(), $announcement->End(), $announcement->Priority()));
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

    /**
     * @abstract
     * @param Announcement $announcement
     */
    public function Update(Announcement $announcement);

    /**
     * @abstract
     * @param int $announcementId
     */
    public function Delete($announcementId);

    /**
     * @abstract
     * @param int $announcementId
     * @return Announcement
     */
    public function LoadById($announcementId);
}

?>