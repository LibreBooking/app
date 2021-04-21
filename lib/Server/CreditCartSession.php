<?php

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
