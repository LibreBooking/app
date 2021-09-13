<?php

require_once(ROOT_DIR . 'Controls/Control.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class CaptchaControl extends Control
{
    public function PageLoad()
    {
        if (Configuration::Instance()->GetSectionKey(
            ConfigSection::RECAPTCHA,
            ConfigKeys::RECAPTCHA_ENABLED,
            new BooleanConverter()
        )
        ) {
            $this->showRecaptcha();
        } else {
            $this->showSecurimage();
        }
    }

    private function showRecaptcha()
    {
        Log::Debug('CaptchaControl using Recaptcha');
        require_once(ROOT_DIR . 'lib/external/recaptcha/recaptchalib.php');

        $publicKey = Configuration::Instance()->GetSectionKey(ConfigSection::RECAPTCHA, ConfigKeys::RECAPTCHA_PUBLIC_KEY);

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
