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

require_once(ROOT_DIR . 'lib/external/securimage/securimage.php');

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
    public function GetImageUrl()
    {
        $url = new Url(Configuration::Instance()->GetScriptUrl() . '/Services/Authentication/show-captcha.php');
        $url->AddQueryString('show', 'true');
        return $url->__toString();
    }

    public function IsCorrect($captchaValue)
    {
		$img = new securimage();
		$isValid = $img->check($captchaValue);

		Log::Debug('Checking captcha value. Value entered: %s. IsValid: %s', $captchaValue, (int)$isValid);

		return $isValid;
    }

    /**
     * @static
     * @return CaptchaService|NullCaptchaService
     */
    public static function Create()
    {
        if (Configuration::Instance()->GetKey(ConfigKeys::REGISTRATION_ENABLE_CAPTCHA, new BooleanConverter()))
        {
            return new CaptchaService();
        }

        return new NullCaptchaService();
    }
}

?>