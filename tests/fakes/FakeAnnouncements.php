<?php
/**
 * Copyright 2011-2020 Nick Korbel
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
            array(
                ColumnNames::ANNOUNCEMENT_ID => 1,
                ColumnNames::ANNOUNCEMENT_TEXT => 'announcement 1',
                ColumnNames::ANNOUNCEMENT_START => null,
                ColumnNames::ANNOUNCEMENT_END => null,
                ColumnNames::ANNOUNCEMENT_PRIORITY => null,
                ColumnNames::GROUP_IDS => null,
                ColumnNames::RESOURCE_IDS => null,
                ColumnNames::ANNOUNCEMENT_DISPLAY_PAGE => 1,
            ),
            array(
                ColumnNames::ANNOUNCEMENT_ID => 1,
                ColumnNames::ANNOUNCEMENT_TEXT => 'announcement 2',
                ColumnNames::ANNOUNCEMENT_START => null,
                ColumnNames::ANNOUNCEMENT_END => null,
                ColumnNames::ANNOUNCEMENT_PRIORITY => null,
                ColumnNames::GROUP_IDS => null,
                ColumnNames::RESOURCE_IDS => null,
                ColumnNames::ANNOUNCEMENT_DISPLAY_PAGE => 1,
            ),
            array(
                ColumnNames::ANNOUNCEMENT_ID => 1,
                ColumnNames::ANNOUNCEMENT_TEXT => 'announcement 3',
                ColumnNames::ANNOUNCEMENT_START => null,
                ColumnNames::ANNOUNCEMENT_END => null,
                ColumnNames::ANNOUNCEMENT_PRIORITY => null,
                ColumnNames::GROUP_IDS => null,
                ColumnNames::RESOURCE_IDS => null,
                ColumnNames::ANNOUNCEMENT_DISPLAY_PAGE => 1,
            ),
        );
    }

    public function GetFuture($displayPage = -1)
    {
        $this->_GetFutureCalled = true;
        return $this->_ExpectedAnnouncements;
    }

    public function GetExpectedRows()
    {
        $expectedAnnouncements = array();
        $rows = $this->GetRows();
        foreach ($rows as $item) {
            $expectedAnnouncements[] = $item[ColumnNames::ANNOUNCEMENT_TEXT];
        }

        return $expectedAnnouncements;
    }

    public function GetAll($sortField = null, $sortDirection = null)
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