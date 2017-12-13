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


class FakeStripeGateway extends StripeGateway
{
    public $_Token;
    public $_Cart;
    public $_Email;
    public $_ChargeResponse = false;

    public function __construct()
    {
        parent::__construct(true, '', '');
    }

    public function Charge(CreditCartSession $cart, $email, $token, IPaymentTransactionLogger $logger)
    {
        $this->_Cart = $cart;
        $this->_Email = $email;
        $this->_Token = $token;

        return $this->_ChargeResponse;
    }
}