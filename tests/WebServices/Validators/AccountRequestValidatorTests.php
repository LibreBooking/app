<?php
/**
Copyright 2019 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'WebServices/Validators/AccountRequestValidator.php');

class AccountRequestValidatorTests extends TestBase
{
	/**
	 * @var FakeAttributeService
	 */
	private $attributeService;

	/**
	 * @var AccountRequestValidator
	 */
	private $validator;

	/**
	 * @var FakeUserRepository
	 */
	private $userRepository;
    /**
     * @var WebServiceUserSession
     */
    private $session;

    public function setUp(): void
	{
		parent::setup();

		$this->attributeService = new FakeAttributeService();
		$this->userRepository = new FakeUserRepository();
		$this->session = new WebServiceUserSession(1);

		$this->validator = new AccountRequestValidator($this->attributeService, $this->userRepository);
	}

	public function testWhenCreateRequestIsJunk()
	{
		$errors = $this->validator->ValidateCreate(null);
		$this->assertEquals(1, count($errors));
	}

	public function testCreateRequiredFields()
	{
		$this->expectsAttributeValidator();
		$request = CreateAccountRequest::Example();
		$request->firstName = null;
        $request->lastName = '';
		$request->userName = ' ';
        $request->password = ' ';
        $request->emailAddress = null;
        $request->timezone = ' ';
		$request->language = ' ';

		$this->userRepository->_Exists = null;

		$errors = $this->validator->ValidateCreate($request);
		$this->assertTrue(count($errors) == 6);
	}

	public function testCreateValidatesEmailFormat()
	{
		$this->expectsAttributeValidator();
		$request = CreateAccountRequest::Example();
		$request->emailAddress = 'aaaaaa.com';
        $this->userRepository->_Exists = null;

        $errors = $this->validator->ValidateCreate($request);
		$this->assertTrue(count($errors) == 1);
	}

	public function testCreateValidatesExistingEmail()
	{
		$this->expectsAttributeValidator();
		$request = CreateAccountRequest::Example();

		$this->userRepository->_Exists = 1;

		$errors = $this->validator->ValidateCreate($request);
		$this->assertTrue(count($errors) == 2);
	}

	public function testCreateValidatesAttributes()
	{
		$request = CreateAccountRequest::Example();
		$result = new AttributeServiceValidationResult(false, array('error'));
		$this->attributeService->_ValidationResult = $result;

		$errors = $this->validator->ValidateCreate($request);
		$this->assertTrue(count($errors) == 1);
	}

	public function testWhenUpdateRequestIsJunk()
	{
		$errors = $this->validator->ValidateUpdate(null, $this->session);
		$this->assertEquals(1, count($errors));
	}

	public function testUpdateRequiredFields()
	{
		$this->expectsAttributeValidator();
		$request = UpdateAccountRequest::Example();
		$request->firstName = null;
		$request->lastName = '';
		$request->userName = ' ';
		$request->timezone = ' ';

		$errors = $this->validator->ValidateUpdate($request, $this->session);
		$this->assertTrue(count($errors) == 3);
	}

	public function testUpdateValidatesEmailFormat()
	{
		$this->expectsAttributeValidator();
		$request = UpdateAccountRequest::Example();
		$request->emailAddress = 'aaaaaa.com';
		$errors = $this->validator->ValidateUpdate($request, $this->session);
		$this->assertTrue(count($errors) == 1);
	}

	public function testUpdateValidatesExistingEmail()
	{
		$this->expectsAttributeValidator();
		$request = UpdateAccountRequest::Example();

		$this->userRepository->_Exists = 2;

		$errors = $this->validator->ValidateUpdate($request, $this->session);
		$this->assertTrue(count($errors) == 2);
	}

	public function testUpdateValidatesAttributes()
	{
		$request = UpdateAccountRequest::Example();
		$result = new AttributeServiceValidationResult(false, array('error'));
        $this->attributeService->_ValidationResult = $result;

        $errors = $this->validator->ValidateUpdate($request, $this->session);
		$this->assertTrue(count($errors) == 1);
	}

	public function testValidatePasswordRequired()
	{
        $request = UpdateAccountPasswordRequest::Example();
        $request->newPassword = '';
        $errors = $this->validator->ValidatePasswordUpdate($request, $this->session);
        $this->assertTrue(count($errors) == 2);
	}

	public function testValidatePasswordMatch()
	{
        $request = UpdateAccountPasswordRequest::Example();
        $request->newPassword = '123abc';
        $request->currentPassword = 'old';

        $enc = new PasswordEncryption();
        $pw = $enc->EncryptPassword($request->currentPassword);

        $this->userRepository->_User->encryptedPassword = $pw->EncryptedPassword();
        $this->userRepository->_User->passwordSalt = $pw->Salt();

        $errors = $this->validator->ValidatePasswordUpdate($request, $this->session);
        $this->assertTrue(count($errors) == 0);
	}

    public function testValidatePasswordDoesNotMatch()
	{
        $request = UpdateAccountPasswordRequest::Example();
        $request->newPassword = '123abc';
        $request->currentPassword = 'old';

        $enc = new PasswordEncryption();
        $pw = $enc->EncryptPassword('no match');

        $this->userRepository->_User->encryptedPassword = $pw->EncryptedPassword();
        $this->userRepository->_User->passwordSalt = $pw->Salt();

        $errors = $this->validator->ValidatePasswordUpdate($request, $this->session);
        $this->assertTrue(count($errors) == 1);
	}

	private function expectsAttributeValidator()
	{
        $this->attributeService->_ValidationResult = new AttributeServiceValidationResult(true, null);
	}
}