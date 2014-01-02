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


class Announcement
{
    private $Id;
    private $Text;
    private $Start;
    private $End;
    private $Priority;

    /**
     * @return int
     */
    public function Id()
    {
        return $this->Id;
    }

    /**
     * @return string
     */
    public function Text()
    {
        return $this->Text;
    }

    /**
     * @return Date
     */
    public function Start()
    {
        return $this->Start;
    }

    /**
     * @return Date
     */
    public function End()
    {
        return $this->End;
    }

    /**
     * @return int
     */
    public function Priority()
    {
        return $this->Priority;
    }


    public function __construct($id, $text, Date $start, Date $end, $priority)
    {
        $this->Id = $id;
        $this->Text = $text;
        $this->Start = $start;
        $this->End = $end;
        $this->Priority = $priority;
    }

    public static function FromRow($row)
    {
        return new Announcement(
            $row[ColumnNames::ANNOUNCEMENT_ID],
            $row[ColumnNames::ANNOUNCEMENT_TEXT],
            Date::FromDatabase($row[ColumnNames::ANNOUNCEMENT_START]),
            Date::FromDatabase($row[ColumnNames::ANNOUNCEMENT_END]),
            $row[ColumnNames::ANNOUNCEMENT_PRIORITY]
        );
    }

    /**
     * @static
     * @param string $text
     * @param Date $start
     * @param Date $end
     * @param int $priority
     * @return Announcement
     */
    public static function Create($text, Date $start, Date $end, $priority)
    {
        if (empty($priority))
        {
            $priority = null;
        }
        return new Announcement(null, $text, $start, $end, $priority);
    }

    /**
     * @param string $text
     */
    public function SetText($text)
    {
        $this->Text = $text;
    }

    /**
     * @param Date $start
     * @param Date $end
     */
    public function SetDates(Date $start, Date $end)
    {
        $this->Start = $start;
        $this->End = $end;
    }

    /**
     * @param int $priority
     */
    public function SetPriority($priority)
    {
        $this->Priority = $priority;
    }
}

?>