<?php

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
	private function __construct()
	{

	}

	public function GetImageUrl()
	{
		$url = new Url(Configuration::Instance()->GetScriptUrl() . '/Services/Authentication/show-captcha.php');
		$url->AddQueryString('show', 'true');
		return $url->__toString();
	}

	public function IsCorrect($captchaValue)
	{
		require_once(ROOT_DIR . 'lib/external/securimage/securimage.php');

		$img = new securimage();
		$isValid = $img->check($captchaValue);

		Log::Debug('Checking captcha value. Value entered: %s. IsValid: %s', $captchaValue, (int)$isValid);

		return $isValid;
	}

	/**
	 * @static
	 * @return ICaptchaService
	 */
	public static function Create()
	{
		if (Configuration::Instance()->GetKey(ConfigKeys::REGISTRATION_ENABLE_CAPTCHA, new BooleanConverter()) ||
            (Configuration::Instance()->GetSectionKey(ConfigSection::AUTHENTICATION, ConfigKeys::AUTHENTICATION_CAPTCHA_ON_LOGIN, new BooleanConverter()))
        )
		{
			if (Configuration::Instance()->GetSectionKey(ConfigSection::RECAPTCHA, ConfigKeys::RECAPTCHA_ENABLED,
														 new BooleanConverter())
			)
			{
//				Log::Debug('Using ReCaptchaService');
				return new ReCaptchaService();
			}
//			Log::Debug('Using CaptchaService');
			return new CaptchaService();
		}

		return new NullCaptchaService();
	}
}

class ReCaptchaService implements ICaptchaService
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
		$server = ServiceLocator::GetServer();

		require_once(ROOT_DIR . 'lib/external/recaptcha/recaptchalib.php');
		$privatekey = Configuration::Instance()->GetSectionKey(ConfigSection::RECAPTCHA, ConfigKeys::RECAPTCHA_PRIVATE_KEY);

		$recap = new ReCaptcha($privatekey);
		$resp = $recap->verifyResponse($server->GetRemoteAddress(), $server->GetForm('g-recaptcha-response'));

		Log::Debug('ReCaptcha IsValid: %s', $resp->success);

		return $resp->success;
	}
}
