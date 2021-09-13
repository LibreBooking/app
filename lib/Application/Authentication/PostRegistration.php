<?php

require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');

class PostRegistration implements IPostRegistration
{
    /**
     * @var IWebAuthentication
     */
    protected $authentication;

    /**
     * @var IAccountActivation
     */
    protected $activation;

    public function __construct(IWebAuthentication $authentication, IAccountActivation $activation)
    {
        $this->authentication = $authentication;
        $this->activation = $activation;
    }

    public function HandleSelfRegistration(User $user, IRegistrationPage $page, ILoginContext $loginContext)
    {
        if ($user->StatusId() == AccountStatus::ACTIVE) {
            Log::Debug('PostRegistration - Handling activate user %s', $user->EmailAddress());
            $this->authentication->Login($user->EmailAddress(), $loginContext);
            $page->Redirect(Pages::UrlFromId($user->Homepage()));
        } else {
            Log::Debug('PostRegistration - Handling pending user %s', $user->EmailAddress());
            $this->activation->Notify($user);
            $page->Redirect(Pages::ACTIVATION);
        }
    }
}
