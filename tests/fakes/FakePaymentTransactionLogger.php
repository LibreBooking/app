<?php

require_once(ROOT_DIR . 'Domain/PaymentGateway.php');

class FakePaymentTransactionLogger implements IPaymentTransactionLogger
{
    public $_PaymentLogged = false;

    public function Log($userId, $status, $invoiceNumber, $transactionId, $totalAmount, $transactionFee, $currency, $transactionHref, $refundHref, $dateCreated, $gatewayDateCreated, $gatewayResponse)
    {
        $this->_PaymentLogged = true;
    }
}