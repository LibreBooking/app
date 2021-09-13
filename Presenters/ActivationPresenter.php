<?php

require_once(ROOT_DIR . 'Pages/ActivationPage.php');

class ActivationPresenter
{
    /**
     * @var IActivationPage
     */
    private $page;

    /**
     * @var IAccountActivation
     */
    private $accountActivation;

    /**
     * @var IWebAuthentication
     */
    private $authentication;

    public function __construct(IActivationPage $page, IAccountActivation $accountActivation, IWebAuthentication $authentication)
    {
        $this->page = $page;
        $this->accountActivation = $accountActivation;
        $this->authentication = $authentication;
    }

    public function PageLoad()
    {
        $activationCode = $this->page->GetActivationCode();
        if (empty($activationCode)) {
            $this->page->ShowSent();
        } else {
            $activationResult = $this->accountActivation->Activate($activationCode);

            if ($activationResult->Activated()) {
                $user = $activationResult->User();
                $this->authentication->Login($user->EmailAddress(), new WebLoginContext(new LoginData(false, $user->Language())));
                $this->page->Redirect(Pages::UrlFromId($user->Homepage()));
            } else {
                $this->page->ShowError();
            }
        }
    }
}
