<?php
require_once(ROOT_DIR . 'lib/WebService/RestServerBase.php');
require_once(ROOT_DIR . 'lib/WebService/IRestService.php');
require_once(ROOT_DIR . 'lib/external/securimage/securimage.php');

class CaptchaWebService extends RestServiceBase
{
    public function __construct()
    {
        $this->Register(RestAction::Captcha(WebServiceAction::Create), array($this, 'CreateImage'));
        $this->Register(RestAction::Captcha(WebServiceAction::Validate), array($this, 'ValidateCaptcha'));
    }

    public function CreateImage(IRestServer $server)
    {
        $img = $this->GetImage();

        return new SecurimageRestResponse($img);
    }

    public function ValidateCaptcha(IRestServer $server)
    {
        $captcha = $server->GetQueryString('captcha');
        $securimage = $this->GetImage();

        return new CaptchaRestResponse($securimage->check($captcha), $captcha);
    }

    /**
     * @return Securimage
     */
    private function GetImage()
    {
        $img = new Securimage();

        // configure the captcha display
        $img->image_width = 280;
        $img->image_height = 100;
        $img->perturbation = 0.9; // high level of distortion
        $img->code_length = rand(5, 6); // random code length
        $img->image_bg_color = new Securimage_Color("#ffffff");
        $img->num_lines = 12;
        $img->noise_level = 5;
        $img->text_color = new Securimage_Color("#000000");
        $img->noise_color = $img->text_color;
        $img->line_color = new Securimage_Color("#cccccc");
        $img->use_sqlite_db = true;

        return $img;
    }
}

class CaptchaRestResponse extends RestResponse
{
    public function __construct($isValid, $enteredValue)
    {
        $this->Body = array('isValid' => $isValid, 'enteredValue' => $enteredValue);
    }
}

class SecurimageRestResponse implements IExactRestResponse
{
    /**
     * @var Securimage
     */
    private $img;

    public function __construct(Securimage $img)
    {
        $this->img = $img;
    }

    /**
     * return void
     */
    public function Respond()
    {
        $this->img->show();
    }
}

?>