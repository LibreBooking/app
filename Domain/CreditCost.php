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

require_once (ROOT_DIR . 'Domain/Values/Currency.php');
use Booked\Currency;

class CreditCost
{
    /**
     * @var float
     */
    private $cost;
    /**
     * @var string
     */
    private $currency;

    /**
     * @param float $cost
     * @param string $currency
     */
    public function __construct($cost = 0.0, $currency = 'USD')
    {
        $this->cost = $cost;
        $this->currency = $currency;
    }

    /**
     * @return float
     */
    public function Cost()
    {
        return $this->cost;
    }

    /**
     * @return string
     */
    public function Currency()
    {
        return $this->currency;
    }

    /**
     * @param float|null $amount
     * @return string
     */
    public function FormatCurrency($amount = null)
    {
        $toFormat = is_null($amount) ? $this->Cost() : $amount;
        $currency = new Currency($this->Currency());
        return $currency->Format($toFormat);
    }

    /**
     * @param float $quantity
     * @return float
     */
    public function GetTotal($quantity)
    {
        return $this->Cost() * $quantity;
    }

    /**
     * @param float $quantity
     * @return string
     */
    public function GetFormattedTotal($quantity)
    {
        $total = $this->GetTotal($quantity);
        return $this->FormatCurrency($total);
    }
}