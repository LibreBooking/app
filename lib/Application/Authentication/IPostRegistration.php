<?php

interface IPostRegistration
{
    public function HandleSelfRegistration(User $user, IRegistrationPage $page, ILoginContext $loginContext);
}
