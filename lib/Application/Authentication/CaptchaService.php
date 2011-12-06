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

class CaptchaService implements ICaptchaService
{
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
}

?>