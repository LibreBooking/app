<?php
/**
 * Copyright 2011-2019 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Domain/Announcement.php');

class AnnouncementRepository implements IAnnouncementRepository
{
    public function GetFuture($displayPage = -1)
    {
        $announcements = array();

        $reader = ServiceLocator::GetDatabase()->Query(new GetDashboardAnnouncementsCommand(Date::Now(), $displayPage));

        while ($row = $reader->GetRow()) {
            $announcements[] = Announcement::FromRow($row);
        }

        $reader->Free();

        return $announcements;
    }

    public function GetAll($sortField = null, $sortDirection = null)
    {
        $announcements = array();

        $command = new GetAllAnnouncementsCommand();

        if (!empty($sortField)) {
            $command = new SortCommand($command, $sortField, $sortDirection);
        }

        $reader = ServiceLocator::GetDatabase()->Query($command);

        while ($row = $reader->GetRow()) {
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
        $db = ServiceLocator::GetDatabase();
        $announcementId = $db->ExecuteInsert(
            new AddAnnouncementCommand(
                $announcement->Text(),
                $announcement->Start(),
                $announcement->End(),
                $announcement->Priority(),
                $announcement->DisplayPage()));

        foreach ($announcement->GroupIds() as $groupId) {
            $db->ExecuteInsert(new AddAnnouncementGroupCommand($announcementId, $groupId));
        }

        foreach ($announcement->ResourceIds() as $resourceId) {
            $db->ExecuteInsert(new AddAnnouncementResourceCommand($announcementId, $resourceId));
        }
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

        if ($row = $reader->GetRow()) {
            $announcement = Announcement::FromRow($row);
        }

		$reader->Free();
        return $announcement;
    }

    public function Update(Announcement $announcement)
    {
        $this->Delete($announcement->Id());
        $this->Add($announcement);
    }
}

interface IAnnouncementRepository
{
    /**
     * Gets all announcements to be displayed for the user
     * @param int $page
     * @return Announcement[]
     */
    public function GetFuture($page);

    /**
     * @param null|string $sortField
     * @param null|string $sortDirection
     * @return Announcement[]|array
     */
    public function GetAll($sortField = null, $sortDirection = null);

    /**
     * @param Announcement $announcement
     */
    public function Add(Announcement $announcement);

    /**
     * @param Announcement $announcement
     */
    public function Update(Announcement $announcement);

    /**
     * @param int $announcementId
     */
    public function Delete($announcementId);

    /**
     * @param int $announcementId
     * @return Announcement
     */
    public function LoadById($announcementId);
}