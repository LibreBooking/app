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

require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/namespace.php');

class CustomAttributeValidationRuleTests extends TestBase
{
	/**
	 * @var IAttributeService|PHPUnit_Framework_MockObject_MockObject
	 */
	private $attributeService;

	/**
	 * @var IUserRepository|PHPUnit_Framework_MockObject_MockObject
	 */
	private $userRepository;

	/**
	 * @var CustomAttributeValidationRule
	 */
	private $rule;

	/**
	 * @var TestReservationSeries
	 */
	private $reservation;

	/**
	 * @var FakeUser
	 */
	private $user;

	/**
	 * @var FakeUser
	 */
	private $bookedBy;

	public function setUp(): void
	{
		parent::setup();

		$this->attributeService = $this->createMock('IAttributeService');
		$this->userRepository = $this->createMock('IUserRepository');

		$this->reservation = new TestReservationSeries();
		$this->user = new FakeUser(1);
		$this->bookedBy = new FakeUser(2);
		$this->reservation->WithOwnerId($this->user->Id());
		$this->reservation->WithBookedBy(new FakeUserSession(false, 'America/New_York', $this->bookedBy->Id()));

		$this->bookedBy->_IsResourceAdmin = false;
		$this->bookedBy->_SetIsAdminForUser(false);

		$this->userRepository->expects($this->at(0))
							 ->method('LoadById')
							 ->with($this->equalTo($this->reservation->UserId()))
							 ->will($this->returnValue($this->user));

		$this->userRepository->expects($this->at(1))
							 ->method('LoadById')
							 ->with($this->equalTo($this->reservation->BookedBy()->UserId))
							 ->will($this->returnValue($this->bookedBy));

		$this->rule = $rule = new CustomAttributeValidationRule($this->attributeService, $this->userRepository);
	}

	public function teardown(): void
	{
		parent::teardown();
	}

	public function testChecksEachAttributeInCategory()
	{
		$errors = array('error1', 'error2');

		$validationResult = new AttributeServiceValidationResult(false, $errors, array(
				new InvalidAttribute(new FakeCustomAttribute(), 'error1'),
				new InvalidAttribute(new FakeCustomAttribute(), 'error2')));

		$this->attributeService->expects($this->once())
				->method('Validate')
				->with($this->equalTo(CustomAttributeCategory::RESERVATION), $this->equalTo($this->reservation->AttributeValues()), $this->equalTo(array()), $this->isFalse(), $this->isFalse())
				->will($this->returnValue($validationResult));

		$userAttribute = new FakeCustomAttribute();
		$userAttribute->WithSecondaryEntities(CustomAttributeCategory::USER, 123);

		$result = $this->rule->Validate($this->reservation, null);

		$this->assertEquals(false, $result->IsValid());
		$this->assertStringContainsString('error1', $result->ErrorMessage());
		$this->assertStringContainsString('error2', $result->ErrorMessage());
		$this->assertStringNotContainsString('error3', $result->ErrorMessage(), "don't include the 3rd error because it's for an attribute that doesn't apply");
	}

	public function testWhenAllAttributesAreValid()
	{
		$validationResult = new AttributeServiceValidationResult(true, array());

		$this->attributeService->expects($this->once())
				->method('Validate')
				->with($this->equalTo(CustomAttributeCategory::RESERVATION), $this->equalTo($this->reservation->AttributeValues()), $this->equalTo(array()), $this->isFalse(), $this->isFalse())
				->will($this->returnValue($validationResult));

		$result = $this->rule->Validate($this->reservation, null);

		$this->assertEquals(true, $result->IsValid());
	}

	public function testWhenUserIsAnAdmin_ThenEvaluateAdminOnlyAttributes()
	{
		$this->bookedBy->_IsAdminForUser = true;
		$validationResult = new AttributeServiceValidationResult(true, array());

		$this->attributeService->expects($this->once())
				->method('Validate')
				->with($this->equalTo(CustomAttributeCategory::RESERVATION), $this->equalTo($this->reservation->AttributeValues()), $this->equalTo(array()), $this->isFalse(), $this->isTrue())
				->will($this->returnValue($validationResult));

		$result = $this->rule->Validate($this->reservation, null);

		$this->assertEquals(true, $result->IsValid());
	}

	public function testWhenTheInvalidAttributeIsForASecondaryUser_AndTheReservationUserIsNotThatUser()
	{
		$this->reservation->WithAttributeValue(new AttributeValue(1, null));

		$attributeService = $this->createMock('IAttributeService');

		$userAttribute = new FakeCustomAttribute();
		$userAttribute->WithSecondaryEntities(CustomAttributeCategory::USER, 123);

		$validationResult = new AttributeServiceValidationResult(false, array('error'), array(new InvalidAttribute($userAttribute, 'another message')));

		$attributeService->expects($this->once())
				->method('Validate')
				->with($this->equalTo(CustomAttributeCategory::RESERVATION), $this->equalTo($this->reservation->AttributeValues()))
				->will($this->returnValue($validationResult));

		$rule = new CustomAttributeValidationRule($attributeService, $this->userRepository);

		$result = $rule->Validate($this->reservation, null);

		$this->assertEquals(true, $result->IsValid());
		$this->assertEmpty($result->ErrorMessage());
	}

	public function testWhenTheInvalidAttributeIsForASecondaryResource_AndTheReservationDoesNotHaveThatResource()
	{
		$this->reservation->WithResource(new FakeBookableResource(1));
		$this->reservation->WithAttributeValue(new AttributeValue(1, null));

		$attributeService = $this->createMock('IAttributeService');

		$userAttribute = new FakeCustomAttribute();
		$userAttribute->WithSecondaryEntities(CustomAttributeCategory::RESOURCE, 2);

		$validationResult = new AttributeServiceValidationResult(false, array('error'), array(new InvalidAttribute($userAttribute, 'another message')));

		$attributeService->expects($this->once())
				->method('Validate')
				->with($this->equalTo(CustomAttributeCategory::RESERVATION), $this->equalTo($this->reservation->AttributeValues()))
				->will($this->returnValue($validationResult));

		$rule = new CustomAttributeValidationRule($attributeService, $this->userRepository);

		$result = $rule->Validate($this->reservation, null);

		$this->assertEquals(true, $result->IsValid());
		$this->assertEmpty($result->ErrorMessage());
	}

	public function testWhenTheInvalidAttributeIsForASecondaryResourceType_AndTheReservationDoesNotHaveAResourceWithThatResourceType()
	{
		$resource = new FakeBookableResource(1);
		$resource->SetResourceTypeId(1);
		$this->reservation->WithResource($resource);
		$this->reservation->WithAttributeValue(new AttributeValue(1, null));

		$attributeService = $this->createMock('IAttributeService');

		$userAttribute = new FakeCustomAttribute();
		$userAttribute->WithSecondaryEntities(CustomAttributeCategory::RESOURCE_TYPE, 2);

		$validationResult = new AttributeServiceValidationResult(false, array('error'), array(new InvalidAttribute($userAttribute, 'another message')));

		$attributeService->expects($this->once())
				->method('Validate')
				->with($this->equalTo(CustomAttributeCategory::RESERVATION), $this->equalTo($this->reservation->AttributeValues()))
				->will($this->returnValue($validationResult));

		$rule = new CustomAttributeValidationRule($attributeService, $this->userRepository);

		$result = $rule->Validate($this->reservation, null);

		$this->assertEquals(true, $result->IsValid());
		$this->assertEmpty($result->ErrorMessage());
	}
}