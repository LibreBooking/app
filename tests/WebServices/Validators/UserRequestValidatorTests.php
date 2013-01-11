<?php
/**
Copyright 2013 Nick Korbel

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

require_once(ROOT_DIR . 'WebServices/Validators/UserRequestValidator.php');

class UserRequestValidatorTests extends TestBase
{
	/**
	 * @var IAttributeService
	 */
	private $attributeService;

	/**
	 * @var UserRequestValidator
	 */
	private $validator;

	/**
	 * @var IUserViewRepository
	 */
	private $userRepository;

	public function setup()
	{
		parent::setup();

		$this->attributeService = $this->getMock('IAttributeService');
		$this->userRepository = $this->getMock('IUserViewRepository');

		$this->validator = new UserRequestValidator($this->attributeService, $this->userRepository);
	}

	public function testWhenRequestIsJunk()
	{
		$errors = $this->validator->ValidateCreateRequest(null);
		$this->assertEquals(1, count($errors));
	}

	public function testRequiredFields()
	{
		$request = CreateUserRequest::Example();
		$request->firstName = null;
		$request->lastName = '';
		$request->userName = ' ';
		$request->timezone = ' ';
		$request->language = ' ';
		$request->password = ' ';

		$errors = $this->validator->ValidateCreateRequest($request);
		$this->assertTrue(count($errors) == 6);
	}

	public function testValidatesEmailFormat()
	{
		$request = CreateUserRequest::Example();
		$request->emailAddress = 'aaaaaa.com';
		$errors = $this->validator->ValidateCreateRequest($request);
		$this->assertTrue(count($errors) == 1);
	}

	public function testValidatesExistingEmail()
	{
		$request = CreateUserRequest::Example();

		$this->userRepository->expects($this->at(0))
				->method('UserExists')
				->with($this->equalTo($request->emailAddress), $this->isNull())
				->will($this->returnValue(1));

		$errors = $this->validator->ValidateCreateRequest($request);
		$this->assertTrue(count($errors) == 1);
	}

	public function testValidatesExistingUsername()
	{
		$request = CreateUserRequest::Example();

		$this->userRepository->expects($this->at(1))
				->method('UserExists')
				->with($this->isNull(), $this->equalTo($request->userName))
				->will($this->returnValue(1));

		$errors = $this->validator->ValidateCreateRequest($request);
		$this->assertTrue(count($errors) == 1);
	}

	public function testValidatesAttributes()
	{
		$request = CreateUserRequest::Example();
		$result = new AttributeServiceValidationResult(false, array('error'));
		$this->attributeService->expects($this->once())
				->method('Validate')
				->with($this->equalTo(CustomAttributeCategory::USER),
					   $this->equalTo(array(new AttributeValue($request->customAttributes[0]->attributeId, $request->customAttributes[0]->attributeValue))))
				->will($this->returnValue($result));

		$errors = $this->validator->ValidateCreateRequest($request);
		$this->assertTrue(count($errors) == 1);
	}
}

?>