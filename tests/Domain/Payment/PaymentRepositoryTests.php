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

require_once(ROOT_DIR . 'Domain/Access/PaymentRepository.php');

class PaymentRepositoryTests extends TestBase
{
    /**
     * @var PaymentRepository
     */
    private $repository;

    public function setup()
    {
        parent::setup();
        $this->repository = new PaymentRepository();
    }

    public function testGetsCreditCost()
    {
        $expectedRows = array(array(ColumnNames::CREDIT_COST => 32.99, ColumnNames::CREDIT_CURRENCY => 'USD'));
        $this->db->SetRows($expectedRows);

        $cost = $this->repository->GetCreditCost();

        $this->assertEquals(new CreditCost(32.99, 'USD'), $cost);
        $this->assertEquals(new GetPaymentConfigurationCommand(), $this->db->_LastCommand);
    }

    public function testUpdatesCreditCost()
    {
        $this->repository->UpdateCreditCost(new CreditCost(32.99, 'USD'));

        $this->assertEquals(new UpdatePaymentConfigurationCommand(32.99, 'USD'), $this->db->_LastCommand);
    }

    public function testUpdatesPayPal()
    {
        $gateway = new PayPalGateway(true, 'client', 'secret', 'environment');
        $this->repository->UpdatePayPalGateway($gateway);

        $this->assertEquals(new DeletePaymentGatewaySettingsCommand(PaymentGateways::PAYPAL), $this->db->_Commands[0]);
        $this->assertTrue($this->db->ContainsCommand(new AddPaymentGatewaySettingCommand(PaymentGateways::PAYPAL, PayPalGateway::CLIENT_ID, 'client')));
        $this->assertTrue($this->db->ContainsCommand(new AddPaymentGatewaySettingCommand(PaymentGateways::PAYPAL, PayPalGateway::SECRET, 'secret')));
        $this->assertTrue($this->db->ContainsCommand(new AddPaymentGatewaySettingCommand(PaymentGateways::PAYPAL, PayPalGateway::ENVIRONMENT, 'environment')));
    }

    public function testUpdatesStripe()
    {
        $gateway = new StripeGateway(true, 'publishable', 'secret');
        $this->repository->UpdateStripeGateway($gateway);

        $this->assertEquals(new DeletePaymentGatewaySettingsCommand(PaymentGateways::STRIPE), $this->db->_Commands[0]);
        $this->assertTrue($this->db->ContainsCommand(new AddPaymentGatewaySettingCommand(PaymentGateways::STRIPE, StripeGateway::PUBLISHABLE_KEY, 'publishable')));
        $this->assertTrue($this->db->ContainsCommand(new AddPaymentGatewaySettingCommand(PaymentGateways::STRIPE, StripeGateway::SECRET_KEY, 'secret')));
    }

    public function testLoadsPayPal()
    {
        $this->db->SetRows(array(
            $this->GetRow(PaymentGateways::PAYPAL, PayPalGateway::CLIENT_ID, 'cid'),
            $this->GetRow(PaymentGateways::PAYPAL, PayPalGateway::SECRET, 'secret'),
            $this->GetRow(PaymentGateways::PAYPAL, PayPalGateway::ENVIRONMENT, 'env'),
        ));

        $paypal = $this->repository->GetPayPalGateway();

        $this->assertEquals(new GetPaymentGatewaySettingsCommand(PaymentGateways::PAYPAL), $this->db->_LastCommand);
        $this->assertTrue($paypal->IsEnabled());
        $this->assertEquals('cid', $paypal->ClientId());
        $this->assertEquals('secret', $paypal->Secret());
        $this->assertEquals('env', $paypal->Environment());
    }

    public function testLoadsStripe()
    {
        $this->db->SetRows(array(
            $this->GetRow(PaymentGateways::STRIPE, StripeGateway::PUBLISHABLE_KEY, 'pk'),
            $this->GetRow(PaymentGateways::STRIPE, StripeGateway::SECRET_KEY, 'secret'),
        ));

        $stripe = $this->repository->GetStripeGateway();

        $this->assertEquals(new GetPaymentGatewaySettingsCommand(PaymentGateways::STRIPE), $this->db->_LastCommand);
        $this->assertTrue($stripe->IsEnabled());
        $this->assertEquals('pk', $stripe->PublishableKey());
        $this->assertEquals('secret', $stripe->SecretKey());
    }

    private function GetRow($gatewayType, $name, $value)
    {
        return array(ColumnNames::GATEWAY_TYPE => $gatewayType,
            ColumnNames::GATEWAY_SETTING_NAME => $name,
            ColumnNames::GATEWAY_SETTING_VALUE => $value);

    }
}