<?php
/**
 * Copyright 2019 Nick Korbel
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

require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'WebServices/Requests/Account/CreateAccountRequest.php');
require_once(ROOT_DIR . 'WebServices/Requests/Account/UpdateAccountRequest.php');
require_once(ROOT_DIR . 'WebServices/Requests/Account/UpdateAccountPasswordRequest.php');
require_once(ROOT_DIR . 'WebServices/Responses/Account/AccountResponse.php');
require_once(ROOT_DIR . 'WebServices/Validators/AccountRequestValidator.php');

interface IAccountController
{
    /**
     * @param CreateAccountRequest $request
     * @return AccountControllerResult
     */
    public function Create(CreateAccountRequest $request);

    /**
     * @param UpdateAccountRequest $request
     * @param WebServiceUserSession $session
     * @return AccountControllerResult
     */
    public function Update(UpdateAccountRequest $request, WebServiceUserSession $session);

    /**
     * @param UpdateAccountPasswordRequest $request
     * @param WebServiceUserSession $session
     * @return AccountControllerResult
     */
    public function UpdatePassword(UpdateAccountPasswordRequest $request, WebServiceUserSession $session);

    /**
     * @param WebServiceUserSession $session
     * @return User
     */
    public function LoadUser(WebServiceUserSession $session);

    /**
     * @param WebServiceUserSession $session
     * @return IEntityAttributeList
     */
    public function GetUserAttributes(WebServiceUserSession $session);
}

class AccountController implements IAccountController
{
    /**
     * @var IRegistration
     */
    private $registration;
    /**
     * @var IAccountRequestValidator
     */
    private $requestValidator;
    /**
     * @var IUserRepository
     */
    private $userRepository;
    /**
     * @var PasswordEncryption
     */
    private $passwordEncryption;
    /**
     * @var IAttributeService
     */
    private $attributeService;

    public function __construct(IRegistration $registration,
                                IUserRepository $userRepository,
                                IAccountRequestValidator $requestValidator,
                                PasswordEncryption $passwordEncryption,
                                IAttributeService $attributeService)
    {
        $this->registration = $registration;
        $this->requestValidator = $requestValidator;
        $this->userRepository = $userRepository;
        $this->passwordEncryption = $passwordEncryption;
        $this->attributeService = $attributeService;
    }

    public function Create(CreateAccountRequest $request)
    {
        $errors = $this->requestValidator->ValidateCreate($request);

        if (!empty($errors)) {
            return new AccountControllerResult(null, $errors);
        }

        $attributes = array();
        foreach ($request->GetCustomAttributes() as $a) {
            $attributes[] = new AttributeValue($a->attributeId, $a->attributeValue);
        }

        $user = $this->registration->Register($request->userName,
            $request->emailAddress,
            $request->firstName,
            $request->lastName,
            $request->password,
            $request->GetTimezone(),
            $request->GetLanguage(),
            null,
            $request->GetAdditionalFields(),
            $attributes,
            null,
            $request->acceptTermsOfService
        );

        return new AccountControllerResult($user->Id(), null, $user->StatusId() == AccountStatus::AWAITING_ACTIVATION ? array() : null);
    }

    public function Update(UpdateAccountRequest $request, WebServiceUserSession $session)
    {
        $errors = $this->requestValidator->ValidateUpdate($request, $session);

        if (!empty($errors)) {
            return new AccountControllerResult(null, $errors);
        }

        $user = $this->userRepository->LoadById($session->UserId);
        $attributes = array();
        foreach ($request->GetCustomAttributes() as $a) {
            $attributes[] = new AttributeValue($a->attributeId, $a->attributeValue);
        }

        $user->ChangeName($request->firstName, $request->lastName);
        $user->ChangeEmailAddress($request->emailAddress);
        $user->ChangeUsername($request->userName);
        $user->ChangeTimezone($request->GetTimezone());
        $user->ChangeAttributes($request->phone, $request->organization, $request->position);
        $user->ChangeCustomAttributes($attributes);
        $user->ChangeEmailAddress($request->emailAddress);
        $user->ChangeLanguage($request->GetLanguage());

        $this->userRepository->Update($user);

        return new AccountControllerResult($user->Id());
    }

    public function UpdatePassword(UpdateAccountPasswordRequest $request, WebServiceUserSession $session)
    {
        $errors = $this->requestValidator->ValidatePasswordUpdate($request, $session);

        if (!empty($errors)) {
            return new AccountControllerResult(null, $errors);
        }

        $user = $this->userRepository->LoadById($session->UserId);
        $password = $this->passwordEncryption->EncryptPassword($request->newPassword);
        $user->ChangePassword($password->EncryptedPassword(), $password->Salt());
        $this->userRepository->Update($user);

        return new AccountControllerResult($user->Id());
    }

    public function LoadUser(WebServiceUserSession $session)
    {
        return $this->userRepository->LoadById($session->UserId);
    }

    public function GetUserAttributes(WebServiceUserSession $session)
    {
        return $this->attributeService->GetAttributes(CustomAttributeCategory::USER, array($session->UserId));
    }
}

class AccountControllerResult
{

    /**
     * @var int
     */
    private $userId;

    /**
     * @var array|string[]
     */
    private $errors = array();
    /**
     * @var array|string[]
     */
    private $messages;

    /**
     * @param int $userId
     * @param array|string[] $errors
     * @param array|string[] $messages
     */
    public function __construct($userId, $errors = array(), $messages = array())
    {
        $this->userId = $userId;
        $this->errors = $errors;
        $this->messages = $messages;
    }

    /**
     * @return bool
     */
    public function WasSuccessful()
    {
        return !empty($this->userId) && empty($this->errors);
    }

    /**
     * @return int
     */
    public function UserId()
    {
        return $this->userId;
    }

    /**
     * @return array|string[]
     */
    public function Errors()
    {
        return $this->errors;
    }

    /**
     * @return array|string[]
     */
    public function Messages()
    {
        return $this->messages;
    }
}
