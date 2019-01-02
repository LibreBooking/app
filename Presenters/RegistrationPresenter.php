<?php
/**
 * Copyright 2011-2019 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');

class RegisterActions
{
    const Register = 'register';
}

class RegistrationPresenter extends ActionPresenter
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
     * @var IAttributeService
     */
    private $attributeService;

    /**
     * @var ITermsOfServiceRepository
     */
    private $termsRepository;

    /**
     * @param IRegistrationPage $page
     * @param IRegistration|null $registration
     * @param IAuthentication|null $authentication
     * @param ICaptchaService|null $captchaService
     * @param IAttributeService|null $attributeService
     * @param ITermsOfServiceRepository|null $termsOfServiceRepository
     */
    public function __construct(
        IRegistrationPage $page,
        $registration = null,
        $authentication = null,
        $captchaService = null,
        $attributeService = null,
        $termsOfServiceRepository = null)
    {
        parent::__construct($page);

        $this->page = $page;
        $this->SetRegistration($registration);
        $this->SetAuthentication($authentication);
        $this->SetCaptchaService($captchaService);
        $this->SetAttributeService($attributeService);
        $this->SetTermsRepository($termsOfServiceRepository);

        $this->AddAction(RegisterActions::Register, 'Register');
    }

    private function SetRegistration($registration)
    {
        if (is_null($registration)) {
            $this->registration = new Registration();
        }
        else {
            $this->registration = $registration;
        }
    }

    private function SetAuthentication($authorization)
    {
        if (is_null($authorization)) {
            $this->auth = PluginManager::Instance()->LoadAuthentication();
        }
        else {
            $this->auth = $authorization;
        }
    }

    private function SetCaptchaService($captchaService)
    {
        if (is_null($captchaService)) {
            $this->captchaService = CaptchaService::Create();
        }
        else {
            $this->captchaService = $captchaService;
        }
    }

    private function SetAttributeService($attributeService)
    {
        if (is_null($attributeService)) {
            $this->attributeService = new AttributeService(new AttributeRepository());
        }
        else {
            $this->attributeService = $attributeService;
        }
    }

    private function SetTermsRepository($termsOfServiceRepository)
    {
        if (is_null($termsOfServiceRepository)) {
            $this->termsRepository = new TermsOfServiceRepository();
        }
        else {
            $this->termsRepository = $termsOfServiceRepository;
        }
    }

    public function PageLoad()
    {
        $this->BounceIfNotAllowingRegistration();

        $attributes = $this->attributeService->GetAttributes(CustomAttributeCategory::USER);
        $this->page->SetAttributes($attributes->GetAttributes());

        $this->page->SetCaptchaImageUrl($this->captchaService->GetImageUrl());
        $this->PopulateTimezones();
        $this->PopulateHomepages();
        $this->PopulateTerms();
    }

    public function Register()
    {
        $additionalFields = array('phone' => $this->page->GetPhone(),
            'organization' => $this->page->GetOrganization(),
            'position' => $this->page->GetPosition());

        $language = Resources::GetInstance()->CurrentLanguage;
        $user = $this->registration->Register(
            $this->page->GetLoginName(),
            $this->page->GetEmail(),
            $this->page->GetFirstName(),
            $this->page->GetLastName(),
            $this->page->GetPassword(),
            $this->page->GetTimezone(),
            $language,
            intval($this->page->GetHomepage()),
            $additionalFields,
            $this->GetAttributeValues(),
            null,
            $this->page->GetTermsOfServiceAcknowledgement());

        $context = new WebLoginContext(new LoginData(false, $language));
        $plugin = PluginManager::Instance()->LoadPostRegistration();
        $plugin->HandleSelfRegistration($user, $this->page, $context);
    }

    /**
     * @return array|AttributeValue[]
     */
    private function GetAttributeValues()
    {
        $attributes = array();
        foreach ($this->page->GetAttributes() as $attribute) {
            $attributes[] = new AttributeValue($attribute->Id, $attribute->Value);
        }
        return $attributes;
    }

    private function BounceIfNotAllowingRegistration()
    {
        if (!Configuration::Instance()->GetKey(ConfigKeys::ALLOW_REGISTRATION, new BooleanConverter())) {
            $this->page->RedirectPage(Pages::LOGIN);
        }
    }

    private function PopulateTimezones()
    {
        $timezoneValues = array();
        $timezoneOutput = array();

        foreach ($GLOBALS['APP_TIMEZONES'] as $timezone) {
            $timezoneValues[] = $timezone;
            $timezoneOutput[] = $timezone;
        }

        $this->page->SetTimezones($timezoneValues, $timezoneOutput);

        $timezone = Configuration::Instance()->GetDefaultTimezone();
        if ($this->page->IsPostBack()) {
            $timezone = $this->page->GetTimezone();
        }

        $this->page->SetTimezone($timezone);
    }

    private function PopulateHomepages()
    {
        $homepageValues = array();
        $homepageOutput = array();

        $pages = Pages::GetAvailablePages();
        foreach ($pages as $pageid => $page) {
            $homepageValues[] = $pageid;
            $homepageOutput[] = Resources::GetInstance()->GetString($page['name']);
        }

        $this->page->SetHomepages($homepageValues, $homepageOutput);

        $homepageId = 1;
        if ($this->page->IsPostBack()) {
            $homepageId = $this->page->GetHomepage();
        }

        $this->page->SetHomepage($homepageId);
    }

    private function PopulateTerms()
    {
        $terms = $this->termsRepository->Load();
        if ($terms != null && $terms->AppliesToRegistration())
        {
            $this->page->SetTerms($terms);
        }
    }

    protected function LoadValidators($action)
    {
        $this->page->RegisterValidator('fname', new RequiredValidator($this->page->GetFirstName()));
        $this->page->RegisterValidator('lname', new RequiredValidator($this->page->GetLastName()));
        $this->page->RegisterValidator('username', new RequiredValidator($this->page->GetLoginName()));
        $this->page->RegisterValidator('passwordmatch', new EqualValidator($this->page->GetPassword(), $this->page->GetPasswordConfirm()));
        $this->page->RegisterValidator('passwordcomplexity', new PasswordComplexityValidator($this->page->GetPassword()));
        $this->page->RegisterValidator('emailformat', new EmailValidator($this->page->GetEmail()));
        $this->page->RegisterValidator('uniqueemail', new UniqueEmailValidator(new UserRepository(), $this->page->GetEmail()));
        $this->page->RegisterValidator('uniqueusername', new UniqueUserNameValidator(new UserRepository(), $this->page->GetLoginName()));
        $this->page->RegisterValidator('captcha', new CaptchaValidator($this->page->GetCaptcha(), $this->captchaService));
        $this->page->RegisterValidator('additionalattributes', new AttributeValidator($this->attributeService, CustomAttributeCategory::USER, $this->GetAttributeValues()));
        $this->page->RegisterValidator('requiredEmailDomain', new RequiredEmailDomainValidator($this->page->GetEmail()));
        $this->page->RegisterValidator('termsOfService', new TermsOfServiceValidator($this->termsRepository, $this->page->GetTermsOfServiceAcknowledgement()));
    }
}