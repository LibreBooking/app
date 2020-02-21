<?php
/**
Copyright 2013-2020 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Controls/Control.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class CaptchaControl extends Control
{
	public function PageLoad()
	{
		if (Configuration::Instance()->GetSectionKey(ConfigSection::RECAPTCHA, ConfigKeys::RECAPTCHA_ENABLED,
													 new BooleanConverter())
		)
		{
			$this->showRecaptcha();
		}
		else
		{
			$this->showSecurimage();
		}
	}

	private function showRecaptcha()
	{
		Log::Debug('CaptchaControl using Recaptcha');
		require_once(ROOT_DIR . 'lib/external/recaptcha/recaptchalib.php');

        $publicKey = Configuration::Instance()->GetSectionKey(ConfigSection::RECAPTCHA,ConfigKeys::RECAPTCHA_PUBLIC_KEY);

        $response = '<script src=\'https://www.google.com/recaptcha/api.js\'></script>';
        $response .='<div class="g-recaptcha" data-sitekey="' . $publicKey . '"></div>';

		echo $response;
	}

	private function showSecurimage()
	{
		Log::Debug('CaptchaControl using Securimage');
		$url = CaptchaService::Create()->GetImageUrl();

		$label = Resources::GetInstance()->GetString('SecurityCode');
		$message = Resources::GetInstance()->GetString('Required');
		$formName = FormKeys::CAPTCHA;

		echo "<div id=\"captchaDiv\">
                <div><img src=\"$url\" alt=\"captcha\" id=\"captchaImg\"/></div>
		        <label for=\"captchaValue\">$label</label>
                <input type=\"text\" class=\"form-control\" name=\"$formName\" size=\"20\" id=\"$formName\" 
                required=\"required\"
                data-bv-notempty=\"true\"
                data-bv-notempty-message=\"$message\"/>
            </div>";
	}
}