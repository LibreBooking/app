<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/WebService/RestAction.php');

interface ICaptchaService
{
    /**
     * @abstract
     * @return string
     */
    public function GetImageUrl();

    /**
     * @abstract
     * @param string $captchaValue
     * @return bool
     */
    public function IsCorrect($captchaValue);
}

class NullCaptchaService implements ICaptchaService
{
    /**
     * @return string
     */
    public function GetImageUrl()
    {
        return '';
    }

    /**
     * @param string $captchaValue
     * @return bool
     */
    public function IsCorrect($captchaValue)
    {
        return true;
    }
}

class CaptchaService implements ICaptchaService
{
    /**
     * @var string
     */
    private $ipAddress;

    protected function __construct($ipAddress)
    {
        $this->ipAddress = $ipAddress;
    }

    public function GetImageUrl()
    {
        $url = new Url(RestAction::Captcha(WebServiceAction::Create)->ToUrl());
        $url->AddQueryString('rand', uniqid())
                ->AddQueryString('ip', $this->ipAddress);
        return $url->__toString();
    }

    public function IsCorrect($captchaValue)
    {
        $jsonResponse = '';

        $url = new Url(RestAction::Captcha(WebServiceAction::Validate)->ToUrl());
        $url->AddQueryString('captcha', $captchaValue)
                ->AddQueryString('ip', $this->ipAddress);

        $handle = fopen($url->__toString(), 'r');
        while (!feof($handle))
        {
            $jsonResponse .= fgets($handle);
        }
        fclose($handle);

        /** @var $response RestResponse */
        $response = json_decode($jsonResponse);

        return $response->Body->isValid;
    }

    /**
     * @static
     * @param string $ipAddress
     * @return CaptchaService|NullCaptchaService
     */
    public static function Create($ipAddress)
    {
        if (Configuration::Instance()->GetKey(ConfigKeys::REGISTRATION_ENABLE_CAPTCHA, new BooleanConverter()))
        {
            return new CaptchaService($ipAddress);
        }

        return new NullCaptchaService();
    }
}

?>