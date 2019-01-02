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

class CreditCartSession
{
    public $Quantity;
    public $CostPerCredit;
    public $Currency;
    public $Id;
    public $UserId;

    /**
     * @param float $creditQuantity
     * @param float $costPerCredit
     * @param string $currency
     * @param int $userId
     */
    public function __construct($creditQuantity, $costPerCredit, $currency, $userId)
    {
        $this->Quantity = $creditQuantity;
        $this->CostPerCredit = $costPerCredit;
        $this->Currency = $currency;
        $this->Id = BookedStringHelper::Random();
        $this->UserId = $userId;
    }

    /**
     * @return float
     */
    public function Total()
    {
        return $this->CostPerCredit * $this->Quantity;
    }

    /**
     * @return string
     */
    public function Id()
    {
        return $this->Id;
    }
}