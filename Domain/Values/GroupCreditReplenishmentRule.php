<?php
/**
 * Copyright 2020 Nick Korbel
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

class GroupCreditReplenishmentRuleType
{
    const NONE = 0;
    const INTERVAL = 1;
    const DAY_OF_MONTH = 2;
}

class GroupCreditReplenishmentRule
{
    private $id;
    private $type;
    private $amount;
    private $dayOfMonth;
    private $interval;

    public function __construct($id, $type, $amount, $dayOfMonth, $interval)
    {
        $this->id = $id;
        $this->type = $type;
        $this->amount = $amount;
        $this->dayOfMonth = $dayOfMonth;
        $this->interval = $interval;
    }

    public function Id()
    {
        return $this->id;
    }

    /**
     * @return GroupCreditReplenishmentRuleType|int
     */
    public function Type()
    {
        return $this->type;
    }

    /**
     * @return float
     */
    public function Amount()
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function DayOfMonth()
    {
        return $this->dayOfMonth;
    }

    /**
     * @return int
     */
    public function Interval()
    {
        return $this->interval;
    }
}