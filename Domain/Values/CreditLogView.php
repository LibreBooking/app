<?php
/**
 * Copyright 2017-2019 Nick Korbel
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

require_once(ROOT_DIR . 'Domain/Values/FullName.php');

class CreditLogView
{
    /**
     * @var Date
     */
    public $Date;

    /**
     * @var string
     */
    public $Note;

    /**
     * @var int
     */
    public $OriginalCreditCount;

    /**
     * @var int
     */
    public $CreditCount;

    /**
     * @var string
     */
    public $UserFullName;

    public function __construct($date, $note, $originalCount, $count, $userFullName = '')
    {
        $this->Date = $date;
        $this->Note = $note;
        $this->OriginalCreditCount = $originalCount;
        $this->CreditCount = $count;
        $this->UserFullName = $userFullName;
    }

    /**
     * @param array $row
     * @return CreditLogView
     */
    public function Populate($row)
    {
        $userName = '';
        if (isset($row[ColumnNames::FIRST_NAME]))
        {
            $userName = new FullName($row[ColumnNames::FIRST_NAME], $row[ColumnNames::LAST_NAME]);
        }

        return new CreditLogView(
            Date::FromDatabase($row[ColumnNames::DATE_CREATED]),
            $row[ColumnNames::CREDIT_NOTE],
            $row[ColumnNames::ORIGINAL_CREDIT_COUNT],
            $row[ColumnNames::CREDIT_COUNT],
            $userName->__toString());
    }
}