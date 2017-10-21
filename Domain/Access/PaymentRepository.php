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

require_once(ROOT_DIR . 'Domain/CreditCost.php');
require_once(ROOT_DIR . 'Domain/PaymentGateway.php');
require_once(ROOT_DIR . 'lib/Database/namespace.php');
require_once(ROOT_DIR . 'lib/Database/Commands/namespace.php');

interface IPaymentRepository
{
    /**
     * @param CreditCost $cost
     */
    public function UpdateCreditCost(CreditCost $cost);

    /**
     * @return CreditCost
     */
    public function GetCreditCost();

    /**
     * @param PayPalGateway $gateway
     */
    public function UpdatePayPalGateway(PayPalGateway $gateway);

    /**
     * @param StripeGateway $gateway
     */
    public function UpdateStripeGateway(StripeGateway $gateway);

    /**
     * @return PayPalGateway
     */
    public function GetPayPalGateway();

    /**
     * @return StripeGateway
     */
    public function GetStripeGateway();
}

class PaymentRepository implements IPaymentRepository
{
    public function UpdateCreditCost(CreditCost $cost)
    {
        ServiceLocator::GetDatabase()->Execute(new UpdatePaymentConfigurationCommand($cost->Cost(), $cost->Currency()));
    }

    public function GetCreditCost()
    {
        $reader = ServiceLocator::GetDatabase()->Query(new GetPaymentConfigurationCommand());
        if ($row = $reader->GetRow()) {
            return new CreditCost($row[ColumnNames::CREDIT_COST], $row[ColumnNames::CREDIT_CURRENCY]);
        }

        return new CreditCost();
    }

    public function UpdatePayPalGateway(PayPalGateway $gateway)
    {
        $this->UpdateGateway($gateway);
    }

    public function UpdateStripeGateway(StripeGateway $gateway)
    {
        $this->UpdateGateway($gateway);
    }

    private function UpdateGateway(IPaymentGateway $gateway)
    {
        ServiceLocator::GetDatabase()->Execute(new DeletePaymentGatewaySettingsCommand($gateway->GetGatewayType()));
        foreach ($gateway->Settings() as $gatewaySetting) {
            ServiceLocator::GetDatabase()->Execute(new AddPaymentGatewaySettingCommand($gateway->GetGatewayType(), $gatewaySetting->Name(), $gatewaySetting->Value()));
        }
    }

    public function GetPayPalGateway()
    {
        $clientId = null;
        $secret = null;
        $environment = null;

        $reader = ServiceLocator::GetDatabase()->Query(new GetPaymentGatewaySettingsCommand(PaymentGateways::PAYPAL));
        while ($row = $reader->GetRow())
        {
            if ($row[ColumnNames::GATEWAY_SETTING_NAME] == PayPalGateway::CLIENT_ID)
            {
                $clientId = $row[ColumnNames::GATEWAY_SETTING_VALUE];
            }
            elseif ($row[ColumnNames::GATEWAY_SETTING_NAME] == PayPalGateway::SECRET)
            {
                $secret = $row[ColumnNames::GATEWAY_SETTING_VALUE];
            }
            elseif ($row[ColumnNames::GATEWAY_SETTING_NAME] == PayPalGateway::ENVIRONMENT)
            {
                $environment = $row[ColumnNames::GATEWAY_SETTING_VALUE];
            }
        }

        return PayPalGateway::Create($clientId, $secret, $environment);
    }

    public function GetStripeGateway()
    {
        $publishableKey = null;
        $secretKey = null;

        $reader = ServiceLocator::GetDatabase()->Query(new GetPaymentGatewaySettingsCommand(PaymentGateways::STRIPE));
        while ($row = $reader->GetRow())
        {
            if ($row[ColumnNames::GATEWAY_SETTING_NAME] == StripeGateway::PUBLISHABLE_KEY)
            {
                $publishableKey = $row[ColumnNames::GATEWAY_SETTING_VALUE];
            }
            elseif ($row[ColumnNames::GATEWAY_SETTING_NAME] == StripeGateway::SECRET_KEY)
            {
                $secretKey = $row[ColumnNames::GATEWAY_SETTING_VALUE];
            }
        }

        return StripeGateway::Create($publishableKey, $secretKey);
    }
}