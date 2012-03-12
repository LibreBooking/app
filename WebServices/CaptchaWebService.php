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
		if (!function_exists('sqlite_open'))
		{
			Log::Error('php_sqlite extension must be enabled in php.ini for captcha to work');
		}
        $ip = $server->GetQueryString('ip');
        $img = $this->GetImage($ip);

        return new SecurimageRestResponse($img);
    }

    public function ValidateCaptcha(IRestServer $server)
    {
        try
        {
            $captcha = $server->GetQueryString('captcha');
            $ip = $server->GetQueryString('ip');

            $securimage = $this->GetImage($ip);
            $isValid = $securimage->check($captcha);

            Log::Debug("Captcha Validation for IP %s. Entered: %s", $ip, $captcha);

            return new CaptchaRestResponse($isValid, $captcha);
        }
        catch(Exception $ex)
        {
            Log::Error("Error during captcha validation: %s", $ex);
        }

        return new NullRestResponse();
    }

    /**
     * @param string $ip
     * @return Securimage
     */
    private function GetImage($ip)
    {
        $img = new Securimage(array(), $ip);

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