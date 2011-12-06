<?php
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');

class RegistrationPresenter
{
    /**
     * @var IRegistrationPage
     */
    private $page;

    /**
     * @var IRegistration
     */
    private $registration;

    /**
     * @var IAuthentication
     */
    private $auth;

    /**
     * @var ICaptchaService
     */
    private $captchaService;

    /**
     * @param IRegistrationPage $page
     * @param IRegistration|null $registration
     * @param IAuthentication|null $authentication
     * @param ICaptchaService|null $captchaService
     */
    public function __construct(IRegistrationPage $page, $registration = null, $authentication = null, $captchaService = null)
    {
        $this->page = $page;
        $this->SetRegistration($registration);
        $this->SetAuthentication($authentication);
        $this->SetCaptchaService($captchaService);

        if ($page->IsPostBack())
        {
            $this->LoadValidators();
        }
    }

    private function SetRegistration($registration)
    {
        if (is_null($registration))
        {
            $this->registration = new Registration();
        }
        else
        {
            $this->registration = $registration;
        }
    }

    private function SetAuthentication($authorization)
    {
        if (is_null($authorization))
        {
            $this->auth = PluginManager::Instance()->LoadAuthentication();
        }
        else
        {
            $this->auth = $authorization;
        }
    }

    private function SetCaptchaService($captchaService)
    {
        if (is_null($captchaService))
        {
            $this->captchaService = new CaptchaService();
        }
        else
        {
            $this->captchaService = $captchaService;
        }
    }

    public function PageLoad()
    {
        $this->BounceIfNotAllowingRegistration();

        if ($this->page->RegisterClicked())
        {
            $this->Register();
        }

        $this->page->SetCaptchaImageUrl($this->captchaService->GetImageUrl());
        $this->PopulateTimezones();
        $this->PopulateHomepages();
    }

    public function Register()
    {
        if ($this->page->IsValid())
        {

            $additionalFields = array('phone' => $this->page->GetPhone(),
                'organization' => $this->page->GetOrganization(),
                'position' => $this->page->GetPosition());

            $this->registration->Register(
                $this->page->GetLoginName(),
                $this->page->GetEmail(),
                $this->page->GetFirstName(),
                $this->page->GetLastName(),
                $this->page->GetPassword(),
                $this->page->GetTimezone(),
                Configuration::Instance()->GetKey(ConfigKeys::LANGUAGE),
                intval($this->page->GetHomepage()),
                $additionalFields);

            $this->auth->Login($this->page->GetEmail(), false);
            $this->page->Redirect(Pages::UrlFromId($this->page->GetHomepage()));
        }
    }

    private function BounceIfNotAllowingRegistration()
    {
        if (!Configuration::Instance()->GetKey(ConfigKeys::ALLOW_REGISTRATION, new BooleanConverter()))
        {
            $this->page->Redirect(Pages::LOGIN);
        }
    }

    private function PopulateTimezones()
    {
        $timezoneValues = array();
        $timezoneOutput = array();

        foreach ($GLOBALS['APP_TIMEZONES'] as $timezone)
        {
            $timezoneValues[] = $timezone;
            $timezoneOutput[] = $timezone;
        }

        $this->page->SetTimezones($timezoneValues, $timezoneOutput);

        $timezone = Configuration::Instance()->GetKey(ConfigKeys::SERVER_TIMEZONE);
        if ($this->page->IsPostBack())
        {
            $timezone = $this->page->GetTimezone();
        }

        $this->page->SetTimezone($timezone);
    }

    private function PopulateHomepages()
    {
        $homepageValues = array();
        $homepageOutput = array();

        $pages = Pages::GetAvailablePages();
        foreach ($pages as $pageid => $page)
        {
            $homepageValues[] = $pageid;
            $homepageOutput[] = Resources::GetInstance()->GetString($page['name']);
        }

        $this->page->SetHomepages($homepageValues, $homepageOutput);

        $homepageId = 1;
        if ($this->page->IsPostBack())
        {
            $homepageId = $this->page->GetHomepage();
        }

        $this->page->SetHomepage($homepageId);
    }

    private function LoadValidators()
    {
        $this->page->RegisterValidator('fname', new RequiredValidator($this->page->GetFirstName()));
        $this->page->RegisterValidator('lname', new RequiredValidator($this->page->GetLastName()));
        $this->page->RegisterValidator('username', new RequiredValidator($this->page->GetLoginName()));
        $this->page->RegisterValidator('passwordmatch', new EqualValidator($this->page->GetPassword(), $this->page->GetPasswordConfirm()));
        $this->page->RegisterValidator('passwordcomplexity', new RegexValidator($this->page->GetPassword(), Configuration::Instance()->GetKey(ConfigKeys::PASSWORD_PATTERN)));
        $this->page->RegisterValidator('emailformat', new EmailValidator($this->page->GetEmail()));
        $this->page->RegisterValidator('uniqueemail', new UniqueEmailValidator($this->page->GetEmail()));
        $this->page->RegisterValidator('uniqueusername', new UniqueUserNameValidator($this->page->GetLoginName()));
        $this->page->RegisterValidator('captcha', new CaptchaValidator($this->page->GetCaptcha(), $this->captchaService));
    }
}

?>