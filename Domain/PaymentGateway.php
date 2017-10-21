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

class PaymentGateways
{
    const PAYPAL = 'paypal';
    const STRIPE = 'stripe';
}

class PaymentGatewaySetting
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $name
     * @param string $value
     */
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function Name()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function Value()
    {
        return $this->value;
    }
}

interface IPaymentGateway
{
    /**
     * @return string
     */
    public function GetGatewayType();

    /**
     * @return bool
     */
    public function IsEnabled();

    /**
     * @return PaymentGatewaySetting[]
     */
    public function Settings();
}

class PayPalGateway implements IPaymentGateway
{
    const CLIENT_ID = 'client_id';
    const SECRET = 'secret';
    const ENVIRONMENT = 'environment';

    /**
     * @var bool
     */
    private $enabled;
    /**
     * @var string
     */
    private $clientId;
    /**
     * @var string
     */
    private $secret;
    /**
     * @var string
     */
    private $environment;

    /**
     * @param bool $enabled
     * @param string $clientId
     * @param string $secret
     * @param string $environment
     */
    public function __construct($enabled, $clientId, $secret, $environment)
    {
        $this->enabled = $enabled;
        if ($enabled) {
            $this->clientId = $clientId;
            $this->secret = $secret;
            $this->environment = $environment;
        }
    }

    /**
     * @param string $clientId
     * @param string $secret
     * @param string $environment
     * @return PayPalGateway
     */
    public static function Create($clientId, $secret, $environment)
    {
        $enabled = (!empty($clientId) && !empty($secret) && !empty($environment));
        return new PayPalGateway($enabled, $clientId, $secret, $environment);
    }

    public function GetGatewayType()
    {
        return PaymentGateways::PAYPAL;
    }

    public function IsEnabled()
    {
        return $this->enabled;
    }

    public function Settings()
    {
        return array(
            new PaymentGatewaySetting(self::CLIENT_ID, $this->ClientId()),
            new PaymentGatewaySetting(self::SECRET, $this->Secret()),
            new PaymentGatewaySetting(self::ENVIRONMENT, $this->Environment()),
        );
    }

    /**
     * @return string
     */
    public function ClientId()
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function Secret()
    {
        return $this->secret;
    }

    /**
     * @return string
     */
    public function Environment()
    {
        return $this->environment;
    }

}

class StripeGateway implements IPaymentGateway
{
    const PUBLISHABLE_KEY = 'publishable_key';
    const SECRET_KEY = 'secret_key';

    /**
     * @var bool
     */
    private $enabled;
    /**
     * @var string
     */
    private $publishableKey;
    /**
     * @var string
     */
    private $secretKey;

    /**
     * @param bool $enabled
     * @param string $publishableKey
     * @param string $secretKey
     */
    public function __construct($enabled, $publishableKey, $secretKey)
    {
        $this->enabled = $enabled;
        if ($enabled) {
            $this->publishableKey = $publishableKey;
            $this->secretKey = $secretKey;
        }
    }

    /**
     * @param string $publishableKey
     * @param string $secretKey
     * @return StripeGateway
     */
    public static function Create($publishableKey, $secretKey)
    {
        $enabled = (!empty($publishableKey) && !empty($secretKey));
        return new StripeGateway($enabled, $publishableKey, $secretKey);
    }

    public function GetGatewayType()
    {
        return PaymentGateways::STRIPE;
    }

    public function IsEnabled()
    {
        return $this->enabled;
    }

    public function Settings()
    {
        return array(
            new PaymentGatewaySetting(self::PUBLISHABLE_KEY, $this->PublishableKey()),
            new PaymentGatewaySetting(self::SECRET_KEY, $this->SecretKey()),
        );
    }

    /**
     * @return string
     */
    public function PublishableKey()
    {
        return $this->publishableKey;
    }

    /**
     * @return string
     */
    public function SecretKey()
    {
        return $this->secretKey;
    }
}