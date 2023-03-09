<?php

if (file_exists(ROOT_DIR . 'vendor/autoload.php')) { 
    require_once ROOT_DIR . 'vendor/autoload.php';
}

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
            $this->showCaptcha();
        }
    }

    private function showRecaptcha()
    {
        Log::Debug('CaptchaControl using Recaptcha');

        $publicKey = Configuration::Instance()->GetSectionKey(ConfigSection::RECAPTCHA, ConfigKeys::RECAPTCHA_PUBLIC_KEY);

        $response = '<script src="https://www.google.com/recaptcha/api.js?render=' . $publicKey . '"></script>';
        $response .= '<input type="hidden" name="g-recaptcha-response" value="" id="g-recaptcha-response">';
        $response .= '<script> grecaptcha.ready(function () { grecaptcha.execute(\''. $publicKey .'\', { action: \'submit\' }).then(function (token) { var captcha = document.getElementById(\'g-recaptcha-response\'); captcha.value = token;})}); </script>';

        echo $response;
    }

    private function showCaptcha()
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
