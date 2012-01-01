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

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');

class ManageUsersActions
{
    const Activate = 'activate';
    const AddUser = 'addUser';
    const Deactivate = 'deactivate';
    const DeleteUser = 'deleteUser';
    const Password = 'password';
    const Permissions = 'permissions';
    const UpdateUser = 'updateUser';
}

class ManageUsersPresenter extends ActionPresenter
{
    /**
     * @var \IManageUsersPage
     */
    private $page;

    /**
     * @var \UserRepository
     */
    private $userRepository;

    /**
     * @var ResourceRepository
     */
    private $resourceRepository;

    /**
     * @var PasswordEncryption
     */
    private $passwordEncryption;

    /**
     * @var IRegistration
     */
    private $registration;

    /**
     * @param IManageUsersPage $page
     * @param UserRepository $userRepository
     * @param IResourceRepository $resourceRepository
     * @param PasswordEncryption $passwordEncryption
     * @param IRegistration $registration
     */
    public function __construct(IManageUsersPage $page,
                                UserRepository $userRepository,
                                IResourceRepository $resourceRepository,
                                PasswordEncryption $passwordEncryption,
                                IRegistration $registration)
    {
        parent::__construct($page);

        $this->page = $page;
        $this->userRepository = $userRepository;
        $this->resourceRepository = $resourceRepository;
        $this->passwordEncryption = $passwordEncryption;
        $this->registration = $registration;

        $this->AddAction(ManageUsersActions::Activate, 'Activate');
        $this->AddAction(ManageUsersActions::AddUser, 'AddUser');
        $this->AddAction(ManageUsersActions::Deactivate, 'Deactivate');
        $this->AddAction(ManageUsersActions::DeleteUser, 'DeleteUser');
        $this->AddAction(ManageUsersActions::Password, 'ResetPassword');
        $this->AddAction(ManageUsersActions::Permissions, 'ChangePermissions');
        $this->AddAction(ManageUsersActions::UpdateUser, 'UpdateUser');
    }

    public function PageLoad()
    {
        if ($this->page->GetUserId() != null)
        {
            $userList = $this->userRepository->GetList(1, 1, null, null, new SqlFilterEquals(ColumnNames::USER_ID, $this->page->GetUserId()));
        }
        else
        {
            $userList = $this->userRepository->GetList($this->page->GetPageNumber(), $this->page->GetPageSize());
        }

        $this->page->BindUsers($userList->Results());
        $this->page->BindPageInfo($userList->PageInfo());

        $this->page->BindResources($this->resourceRepository->GetResourceList());
    }

    public function Deactivate()
    {
        $user = $this->userRepository->LoadById($this->page->GetUserId());
        $user->Deactivate();
        $this->userRepository->Update($user);
    }

    public function Activate()
    {
        $user = $this->userRepository->LoadById($this->page->GetUserId());
        $user->Activate();
        $this->userRepository->Update($user);
    }

    public function AddUser()
    {
        $this->registration->Register(
            $this->page->GetUserName(),
            $this->page->GetEmail(),
            $this->page->GetFirstName(),
            $this->page->GetLastName(),
            $this->page->GetPassword(),
            $this->page->GetTimezone(),
            Configuration::Instance()->GetKey(ConfigKeys::LANGUAGE),
            Pages::DEFAULT_HOMEPAGE_ID);
    }

    public function UpdateUser()
    {
        Log::Debug('Updating user %s', $this->page->GetUserId());
        $user = $this->userRepository->LoadById($this->page->GetUserId());
        $user->ChangeName($this->page->GetFirstName(), $this->page->GetLastName());
        $user->ChangeEmailAddress($this->page->GetEmail());
        $user->ChangeUsername($this->page->GetUserName());
        $user->ChangeTimezone($this->page->GetTimezone());
        $user->ChangeAttributes($this->page->GetPhone(), $this->page->GetOrganization(), $this->page->GetPosition());

        $this->userRepository->Update($user);
    }

    public function DeleteUser()
    {
        $userId = $this->page->GetUserId();
        Log::Debug('Deleting user %s', $userId);

        $this->userRepository->DeleteById($userId);
    }

    public function ChangePermissions()
    {
        $user = $this->userRepository->LoadById($this->page->GetUserId());
        $allowedResources = array();

        if (is_array($this->page->GetAllowedResourceIds()))
        {
            $allowedResources = $this->page->GetAllowedResourceIds();
        }
        $user->ChangePermissions($allowedResources);
        $this->userRepository->Update($user);
    }

    public function ResetPassword()
    {
        $salt = $this->passwordEncryption->Salt();
        $encryptedPassword = $this->passwordEncryption->Encrypt($this->page->GetPassword(), $salt);

        $user = $this->userRepository->LoadById($this->page->GetUserId());
        $user->ChangePassword($encryptedPassword, $salt);
        $this->userRepository->Update($user);
    }

    public function ProcessDataRequest()
    {
        if ($this->page->GetDataRequest() == 'groupMembers')
        {
            $this->page->SetJsonResponse($users);
        }
        else
        {
            $this->page->SetJsonResponse($this->GetUserResourcePermissions());
        }
    }

    /**
     * @return int[] all resource ids the user has permission to
     */
    public function GetUserResourcePermissions()
    {
        $user = $this->userRepository->LoadById($this->page->GetUserId());
        return $user->AllowedResourceIds();
    }

    protected function LoadValidators($action)
    {
        if ($action == ManageUsersActions::UpdateUser)
        {
            Log::Debug('Loading validators for %s', $action);

            $this->page->RegisterValidator('emailformat', new EmailValidator($this->page->GetEmail()));
            $this->page->RegisterValidator('uniqueemail', new UniqueEmailValidator($this->page->GetEmail(), $this->page->GetUserId()));
            $this->page->RegisterValidator('uniqueusername', new UniqueUserNameValidator($this->page->GetUserName(), $this->page->GetUserId()));
        }

        if ($action == ManageUsersActions::AddUser)
        {
            Log::Debug('Loading validators for %s', $action);

            $this->page->RegisterValidator('addUserEmailformat', new EmailValidator($this->page->GetEmail()));
            $this->page->RegisterValidator('addUserUniqueemail', new UniqueEmailValidator($this->page->GetEmail()));
            $this->page->RegisterValidator('addUserUsername', new UniqueUserNameValidator($this->page->GetUserName()));
        }
    }
}
?>