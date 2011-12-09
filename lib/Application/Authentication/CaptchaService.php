<?php
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
    protected function __construct()
    {}

    public function GetImageUrl()
    {
        return RestAction::Captcha(WebServiceAction::Create)->ToUrl() . '&rand=' . uniqid();
    }

    public function IsCorrect($captchaValue)
    {
        $jsonResponse = '';
        $handle = fopen(RestAction::Captcha(WebServiceAction::Validate)->ToUrl() . '&captcha=' . $captchaValue, 'r');
        while (!feof($handle))
        {
            $jsonResponse .= fgets($handle);
        }
        fclose($handle);

        /** @var $response RestResponse */
        $response = json_decode($jsonResponse);

        return $response->response->isValid;
    }

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