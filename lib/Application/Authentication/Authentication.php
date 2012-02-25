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


require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Database/namespace.php');
require_once(ROOT_DIR . 'lib/Database/Commands/namespace.php');
require_once(ROOT_DIR . 'Domain/Values/RoleLevel.php');

class Authentication implements IAuthentication
{
    /**
     * @var PasswordMigration
     */
    private $passwordMigration = null;

    /**
     * @var IRoleService
     */
    private $roleService;

    /**
     * @var IUserRepository
     */
    private $userRepository;

    public function __construct(IRoleService $roleService, IUserRepository $userRepository)
    {
        $this->roleService = $roleService;
        $this->userRepository = $userRepository;
    }

    public function SetMigration(PasswordMigration $migration)
    {
        $this->passwordMigration = $migration;
    }

    /**
     * @return PasswordMigration
     */
    private function GetMigration()
    {
        if (is_null($this->passwordMigration))
        {
            $this->passwordMigration = new PasswordMigration();
        }

        return $this->passwordMigration;
    }

    public function Validate($username, $password)
    {
        Log::Debug('Trying to log in as: %s', $username);

        $command = new AuthorizationCommand($username);
        $reader = ServiceLocator::GetDatabase()->Query($command);
        $valid = false;

        if ($row = $reader->GetRow())
        {
            Log::Debug('User was found: %s', $username);
            $migration = $this->GetMigration();
            $password = $migration->Create($password, $row[ColumnNames::OLD_PASSWORD], $row[ColumnNames::PASSWORD]);
            $salt = $row[ColumnNames::SALT];

            if ($password->Validate($salt))
            {
                $password->Migrate($row[ColumnNames::USER_ID]);
                $valid = true;
            }
        }

        Log::Debug('User: %s, was validated: %d', $username, $valid);
        return $valid;
    }

    /**
     * @param string $username
     * @param ILoginContext $loginContext
     */
    public function Login($username, $loginContext)
    {
        Log::Debug('Logging in with user: %s', $username);

        $user = $this->userRepository->LoadByUsername($username);
        if ($user->StatusId() == AccountStatus::ACTIVE)
        {
            $loginData = $loginContext->GetData();
            $loginTime = LoginTime::Now();
            $userid = $user->Id();
            $language = $user->Language();

            if (!empty($loginData->Language))
            {
                $language = $loginData->Language;
            }

            $user->Login($loginTime, $language);
            $this->userRepository->Update($user);

            $this->SetUserSession($user, $loginContext->GetServer());

            if ($loginContext->GetData()->Persist)
            {
                $this->SetLoginCookie($userid, $loginTime, $loginContext->GetServer());
            }
        }
    }

    public function Logout(UserSession $userSession)
    {
        Log::Debug('Logout userId: %s', $userSession->UserId);

        $this->DeleteLoginCookie($userSession->UserId);
        ServiceLocator::GetServer()->SetSession(SessionKeys::USER_SESSION, null);

        @session_unset();
        @session_destroy();
    }

    public function CookieLogin($cookieValue, $loginContext)
    {
        $loginCookie = LoginCookie::FromValue($cookieValue);
        $valid = false;

        if (!is_null($loginCookie))
        {
            $validEmail = $this->ValidateCookie($loginCookie);
            $valid = !is_null($validEmail);

            if ($valid)
            {
                $this->Login($validEmail, $loginContext);
            }
        }

        return $valid;
    }

    public function AreCredentialsKnown()
    {
        return false;
    }

    public function HandleLoginFailure(ILoginPage $loginPage)
    {
        $loginPage->SetShowLoginError();
    }

    /**
     * @param User $user
     * @param Server $server
     */
    private function SetUserSession(User $user, $server)
    {
        $userSession = new UserSession($user->Id());
        $userSession->Email = $user->EmailAddress();
        $userSession->FirstName = $user->FirstName();
        $userSession->LastName = $user->LastName();
        $userSession->Timezone = $user->Timezone();
        $userSession->HomepageId = $user->Homepage();

		$userSession->IsAdmin = $this->roleService->IsApplicationAdministrator($user);
		$userSession->IsGroupAdmin = $this->roleService->IsGroupAdministrator($user);
		$userSession->IsResourceAdmin = $this->roleService->IsResourceAdministrator($user);

        $server->SetUserSession($userSession);
    }

    /**
     * @param int $userid
     * @param string $lastLogin
     * @param Server $server
     */
    private function SetLoginCookie($userid, $lastLogin, $server)
    {
        $cookie = new LoginCookie($userid, $lastLogin);
        $server->SetCookie($cookie);
    }

    private function DeleteLoginCookie($userid)
    {
        $cookie = new LoginCookie($userid, null);
        ServiceLocator::GetServer()->SetCookie($cookie);
    }

    private function ValidateCookie($loginCookie)
    {
        $valid = false;
        $reader = ServiceLocator::GetDatabase()->Query(new CookieLoginCommand($loginCookie->UserID));

        if ($row = $reader->GetRow())
        {
            $valid = $row[ColumnNames::LAST_LOGIN] == $loginCookie->LastLogin;
        }

        return $valid ? $row[ColumnNames::EMAIL] : null;
    }

}

?>