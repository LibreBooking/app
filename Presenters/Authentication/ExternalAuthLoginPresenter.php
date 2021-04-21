<?php

require_once(ROOT_DIR . 'Presenters/Authentication/LoginRedirector.php');

class ExternalAuthLoginPresenter
{
    /**
     * @var ExternalAuthLoginPage
     */
    private $page;
    /**
     * @var IWebAuthentication
     */
    private $authentication;
    /**
     * @var IRegistration
     */
    private $registration;

    public function __construct(ExternalAuthLoginPage $page, IWebAuthentication $authentication, IRegistration $registration)
    {
        $this->page = $page;
        $this->authentication = $authentication;
        $this->registration = $registration;
    }

    public function PageLoad()
    {
        if ($this->page->GetType() == 'google') {
            $this->ProcessSocialSingleSignOn('googleprofile.php');
        }
        if ($this->page->GetType() == 'fb') {
            $this->ProcessSocialSingleSignOn('fbprofile.php');
        }
    }

    private function ProcessSocialSingleSignOn($page)
    {
        $code = $_GET['code'];
        Log::Debug('Logging in with social. Code=%s', $code);
        $result = file_get_contents("http://www.social.twinkletoessoftware.com/$page?code=$code");
        $profile = json_decode($result);

        $requiredDomainValidator = new RequiredEmailDomainValidator($profile->email);
        $requiredDomainValidator->Validate();
        if (!$requiredDomainValidator->IsValid()) {
            Log::Debug('Social login with invalid domain. %s', $profile->email);
            $this->page->ShowError(array(Resources::GetInstance()->GetString('InvalidEmailDomain')));
            return;
        }

        Log::Debug('Social login successful. Email=%s', $profile->email);
        $this->registration->Synchronize(new AuthenticatedUser($profile->email,
            $profile->email,
            $profile->first_name,
            $profile->last_name,
            Password::GenerateRandom(),
            Resources::GetInstance()->CurrentLanguage,
            Configuration::Instance()->GetDefaultTimezone(),
            null,
            null,
            null),
            false,
            false);

        $this->authentication->Login($profile->email, new WebLoginContext(new LoginData()));
        LoginRedirector::Redirect($this->page);
    }
}
