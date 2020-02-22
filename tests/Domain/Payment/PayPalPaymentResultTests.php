<?php
/**
 * Copyright 2017-2020 Nick Korbel
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

require_once (ROOT_DIR . 'Domain/Values/PayPalPaymentResult.php');

class PayPalPaymentResultTests extends TestBase
{
    public function testParsesJsonString()
    {
        $json = "{\"id\":\"PAY-1WW82131WF352133WLH4QOUQ\",\"intent\":\"sale\",\"state\":\"approved\",\"cart\":\"5FD72329MG139642M\",\"create_time\":\"2017-10-31T23:29:38Z\",\"payer\":{\"payment_method\":\"paypal\",\"status\":\"VERIFIED\",\"payer_info\":{\"email\":\"lqqkout13-buyer@aol.com\",\"first_name\":\"test\",\"middle_name\":\"test\",\"last_name\":\"buyer\",\"payer_id\":\"3GTAL5H4LTHV6\",\"country_code\":\"US\",\"shipping_address\":{\"recipient_name\":\"test buyer\",\"line1\":\"1 Main St\",\"city\":\"San Jose\",\"state\":\"CA\",\"postal_code\":\"95131\",\"country_code\":\"US\"}}},\"transactions\":[{\"amount\":{\"total\":\"1.00\",\"currency\":\"USD\",\"details\":{}},\"item_list\":{},\"related_resources\":[{\"sale\":{\"id\":\"57031264LU207192J\",\"state\":\"completed\",\"payment_mode\":\"INSTANT_TRANSFER\",\"protection_eligibility\":\"ELIGIBLE\",\"parent_payment\":\"PAY-1WW82131WF352133WLH4QOUQ\",\"create_time\":\"2017-10-31T23:29:38Z\",\"update_time\":\"2017-10-31T23:29:38Z\",\"amount\":{\"total\":\"1.00\",\"currency\":\"USD\",\"details\":{\"subtotal\":\"1.00\"}}}}]}]}";

        $payment = PayPalPaymentResult::FromJsonString($json);

        $timestamp = new Date("2017-10-31 23:29:38", "UTC");
        $this->assertEquals($json, $payment->Raw);
        $this->assertEquals(1.00, $payment->Amount);
        $this->assertEquals('USD', $payment->Currency);
        $this->assertEquals("57031264LU207192J", $payment->Id);
        $this->assertEquals($timestamp, $payment->Timestamp);
    }
}