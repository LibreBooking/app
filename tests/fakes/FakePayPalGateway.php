<?php
/**
 * Copyright 2017 Nick Korbel
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

require_once(ROOT_DIR . 'Domain/PaymentGateway.php');

class FakePayPalGateway extends PayPalGateway
{
    public $_Payment;
    public $_PaymentCreatedCart;
    public $_ReturnUrl;
    public $_CancelUrl;
    public $_PaymentId;
    public $_PayerId;
    public $_Refund;
    public $_LastTransactionView;
    public $_LastRefundAmount;

    public function __construct()
    {
        $this->_Payment = new \PayPal\Api\Payment();
        $this->_Refund = new \PayPal\Api\DetailedRefund();
        parent::__construct(true, null, null, null);
    }

    public function CreatePayment(CreditCartSession $cart, $returnUrl, $cancelUrl)
    {
        $this->_PaymentCreatedCart = $cart;
        $this->_ReturnUrl = $returnUrl;
        $this->_CancelUrl = $cancelUrl;
        return $this->_Payment;
    }

    public function ExecutePayment(CreditCartSession $cart, $paymentId, $payerId, IPaymentTransactionLogger $logger)
    {
        $this->_PaymentCreatedCart = $cart;
        $this->_PaymentId = $paymentId;
        $this->_PayerId = $payerId;
        return $this->_Payment;
    }

    public function Refund(TransactionLogView $log, $amount, IPaymentTransactionLogger $logger)
    {
        $this->_LastTransactionView = $log;
        $this->_LastRefundAmount = $amount;
        return $this->_Refund;
    }

}