<?php

class PayPalPaymentResult
{
    /**
     * @var string
     */
    public $Raw;

    /**
     * @var float
     */
    public $Amount;

    /**
     * @var string
     */
    public $Currency;

    /**
     * @var string
     */
    public $Id;

    /**
     * @var Date
     */
    public $Timestamp;

    /**
     * @param string $jsonString
     * @return PayPalPaymentResult
     */
    public static function FromJsonString($jsonString)
    {
        $result = new PayPalPaymentResult();
        $result->Raw = $jsonString;

        $json = json_decode($jsonString);

        $result->Amount = $json->transactions[0]->amount->total;
        $result->Currency = $json->transactions[0]->amount->currency;
        $result->Id = $json->transactions[0]->related_resources[0]->sale->id;
        $result->Timestamp = Date::ParseExact($json->create_time);

        return $result;
    }
}
