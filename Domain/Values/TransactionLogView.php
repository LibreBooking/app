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

class TransactionLogView
{
    /**
     * @var int
     */
    public $Id;
    /**
     * @var Date
     */
    public $TransactionDate;
    /**
     * @var string
     */
    public $Status;
    /**
     * @var string
     */
    public $InvoiceNumber;
    /**
     * @var string
     */
    public $TransactionId;
    /**
     * @var float
     */
    public $Total;
    /**
     * @var float
     */
    public $Fee;
    /**
     * @var string
     */
    public $Currency;
    /**
     * @var string
     */
    public $TransactionHref;
    /**
     * @var string
     */
    public $RefundHref;
    /**
     * @var string
     */
    public $GatewayTransactionDate;
    /**
     * @var string
     */
    public $GatewayName;
    /**
     * @var string
     */
    public $UserFullName;
    /**
     * @var int
     */
    public $UserId;
    /**
     * @var float
     */
    public $AmountRefunded = 0;

    public function __construct($transactionDate, $status, $invoiceNumber, $transactionId, $total, $fee, $currency, $transactionHref, $refundHref, $gatewayTransactionDate, $gatewayName, $userId, $userFullName = '')
    {
        $this->TransactionDate = $transactionDate;
        $this->Status = $status;
        $this->InvoiceNumber = $invoiceNumber;
        $this->TransactionId = $transactionId;
        $this->Total = $total;
        $this->Fee = $fee;
        $this->Currency = $currency;
        $this->TransactionHref = $transactionHref;
        $this->RefundHref = $refundHref;
        $this->GatewayName = $gatewayName;
        $this->GatewayTransactionDate = $gatewayTransactionDate;
        $this->UserId = $userId;
        $this->UserFullName = $userFullName;
    }

    /**
     * @param array $row
     * @return TransactionLogView
     */
    public static function Populate($row)
    {
        $userName = '';
        if (isset($row[ColumnNames::FIRST_NAME]))
        {
            $userName = new FullName($row[ColumnNames::FIRST_NAME], $row[ColumnNames::LAST_NAME]);
            $userName = $userName->__toString();
        }

        $v = new TransactionLogView(
            Date::FromDatabase($row[ColumnNames::DATE_CREATED]),
            $row[ColumnNames::TRANSACTION_LOG_STATUS],
            $row[ColumnNames::TRANSACTION_LOG_INVOICE],
            $row[ColumnNames::TRANSACTION_LOG_TRANSACTION_ID],
            $row[ColumnNames::TRANSACTION_LOG_TOTAL],
            $row[ColumnNames::TRANSACTION_LOG_FEE],
            $row[ColumnNames::TRANSACTION_LOG_CURRENCY],
            $row[ColumnNames::TRANSACTION_LOG_TRANSACTION_HREF],
            $row[ColumnNames::TRANSACTION_LOG_REFUND_HREF],
            $row[ColumnNames::TRANSACTION_LOG_GATEWAY_DATE],
            $row[ColumnNames::TRANSACTION_LOG_GATEWAY_NAME],
            $row[ColumnNames::USER_ID],
            $userName);
        $v->Id = $row[ColumnNames::TRANSACTION_LOG_ID];
        $v->AmountRefunded = floatval($row[ColumnNames::TRANSACTION_LOG_REFUND_AMOUNT]);

        return $v;
    }
}