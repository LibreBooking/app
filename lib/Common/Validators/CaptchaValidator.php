<?php

class CaptchaValidator extends ValidatorBase implements IValidator
{
    private $captchaValue;
    private $captchaService;

    public function __construct($captchaValue, ICaptchaService $captchaService)
    {
        $this->captchaValue = $captchaValue;
        $this->captchaService = $captchaService;
    }

    public function Validate()
    {
        $this->isValid = $this->captchaService->IsCorrect($this->captchaValue);
    }
}
