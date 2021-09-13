<?php

require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Common/Validators/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class PasswordPresenter
{
    /**
     * @var \IPasswordPage
     */
    private $page;

    /**
     * @var \IUserRepository
     */
    private $userRepository;

    /**
     * @var \PasswordEncryption
     */
    private $passwordEncryption;

    public function __construct(IPasswordPage $page, IUserRepository $userRepository, PasswordEncryption $passwordEncryption)
    {
        $this->page = $page;
        $this->userRepository = $userRepository;
        $this->passwordEncryption = $passwordEncryption;
    }

    public function PageLoad()
    {
        $this->page->SetAllowedActions(PluginManager::Instance()->LoadAuthentication());

        if ($this->page->ResettingPassword()) {
            $this->LoadValidators();

            if ($this->page->IsValid()) {
                $this->page->EnforceCSRFCheck();
                $user = $this->GetUser();
                $password = $this->page->GetPassword();
                $encrypted = $this->passwordEncryption->EncryptPassword($password);

                $user->ChangePassword($encrypted->EncryptedPassword(), $encrypted->Salt());
                $this->userRepository->Update($user);

                $this->page->ShowResetPasswordSuccess(true);
            }
        }
    }

    private function LoadValidators()
    {
        $this->page->RegisterValidator('currentpassword', new PasswordValidator($this->page->GetCurrentPassword(), $this->GetUser()));
        $this->page->RegisterValidator('passwordmatch', new EqualValidator($this->page->GetPassword(), $this->page->GetPasswordConfirmation()));
        $this->page->RegisterValidator('passwordcomplexity', new PasswordComplexityValidator($this->page->GetPassword()));
    }

    /**
     * @return User
     */
    private function GetUser()
    {
        $userId = ServiceLocator::GetServer()->GetUserSession()->UserId;

        return $this->userRepository->LoadById($userId);
    }
}
