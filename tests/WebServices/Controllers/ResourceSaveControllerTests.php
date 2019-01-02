<?php
/**
Copyright 2013-2019 Nick Korbel

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

require_once(ROOT_DIR . 'WebServices/Controllers/ResourceSaveController.php');

class ResourceSaveControllerTests extends TestBase
{
	/**
	 * @var ResourceSaveController
	 */
	private $controller;

	/**
	 * @var WebServiceUserSession
	 */
	private $session;

	/**
	 * @var IResourceRepository
	 */
	private $repository;

	/**
	 * @var IResourceRequestValidator
	 */
	private $validator;

	public function setup()
	{
		$this->validator = $this->getMock('IResourceRequestValidator');
		$this->repository = $this->getMock('IResourceRepository');
		$this->session = new FakeWebServiceUserSession(1);
		$this->controller = new ResourceSaveController($this->repository, $this->validator);

		parent::setup();
	}

	public function testAddsNewResource()
	{
		$resourceId = 122;
		$request = ResourceRequest::Example();
		$expectedCreateResource = BookableResource::CreateNew($request->name,
															  $request->scheduleId,
															  $request->autoAssignPermissions,
															  $request->sortOrder);

		$expectedUpdateResource = new BookableResource($resourceId,
													   $request->name,
													   $request->location,
													   $request->contact,
													   $request->notes,
													   $request->minLength,
													   $request->maxLength,
													   $request->autoAssignPermissions,
													   $request->requiresApproval,
													   $request->allowMultiday,
													   $request->maxParticipants,
													   $request->minNotice,
													   $request->maxNotice,
													   $request->description,
													   $request->scheduleId);

		$expectedUpdateResource->SetSortOrder($request->sortOrder);
		$expectedUpdateResource->ChangeStatus($request->statusId, $request->statusReasonId);
		$attributes = array(new AttributeValue($request->customAttributes[0]->attributeId, $request->customAttributes[0]->attributeValue));
		$expectedUpdateResource->ChangeAttributes($attributes);
		$expectedUpdateResource->SetCheckin($request->requiresCheckIn, $request->autoReleaseMinutes);
        $expectedUpdateResource->SetColor($request->color);
        $expectedUpdateResource->SetCreditsPerSlot($request->creditsPerSlot);
        $expectedUpdateResource->SetPeakCreditsPerSlot($request->peakCreditsPerSlot);

		$this->validator->expects($this->once())
				->method('ValidateCreateRequest')
				->with($this->equalTo($request))
				->will($this->returnValue(array()));

		$this->repository->expects($this->once())
				->method('Add')
				->with($this->equalTo($expectedCreateResource))
				->will($this->returnValue($resourceId));

		$this->repository->expects($this->once())
				->method('Update')
				->with($this->equalTo($expectedUpdateResource));

		$response = $this->controller->Create($request, $this->session);

		$this->assertTrue($response->WasSuccessful());
		$this->assertEquals($resourceId, $response->ResourceId());
		$this->assertEmpty($response->Errors());
	}

	public function testWhenAddValidationFails()
	{
		$errors = array('something failed');

		$request = ResourceRequest::Example();
		$this->validator->expects($this->once())
				->method('ValidateCreateRequest')
				->with($this->anything())
				->will($this->returnValue($errors));

		$response = $this->controller->Create($request, $this->session);

		$this->assertFalse($response->WasSuccessful());
		$this->assertNull($response->ResourceId());
		$this->assertEquals($errors, $response->Errors());
	}

	public function testUpdatesResource()
	{
		$resourceId = 122;
		$request = ResourceRequest::Example();
		$expectedUpdateResource = new BookableResource($resourceId,
													   $request->name,
													   $request->location,
													   $request->contact,
													   $request->notes,
													   $request->minLength,
													   $request->maxLength,
													   $request->autoAssignPermissions,
													   $request->requiresApproval,
													   $request->allowMultiday,
													   $request->maxParticipants,
													   $request->minNotice,
													   $request->maxNotice,
													   $request->description,
													   $request->scheduleId);

		$expectedUpdateResource->SetSortOrder($request->sortOrder);
		$expectedUpdateResource->ChangeStatus($request->statusId, $request->statusReasonId);
		$attributes = array(new AttributeValue($request->customAttributes[0]->attributeId, $request->customAttributes[0]->attributeValue));
		$expectedUpdateResource->ChangeAttributes($attributes);
        $expectedUpdateResource->SetCheckin($request->requiresCheckIn, $request->autoReleaseMinutes);
        $expectedUpdateResource->SetColor($request->color);
        $expectedUpdateResource->SetCreditsPerSlot($request->creditsPerSlot);
        $expectedUpdateResource->SetPeakCreditsPerSlot($request->peakCreditsPerSlot);

		$this->validator->expects($this->once())
				->method('ValidateUpdateRequest')
				->with($this->equalTo($resourceId), $this->equalTo($request))
				->will($this->returnValue(array()));

		$this->repository->expects($this->once())
				->method('Update')
				->with($this->equalTo($expectedUpdateResource));

		$response = $this->controller->Update($resourceId, $request, $this->session);

		$this->assertTrue($response->WasSuccessful());
		$this->assertEquals($resourceId, $response->ResourceId());
		$this->assertEmpty($response->Errors());
	}

	public function testWhenUpdateValidationFails()
	{
		$resourceId = 123;
		$errors = array('something failed');

		$request = ResourceRequest::Example();
		$this->validator->expects($this->once())
				->method('ValidateUpdateRequest')
				->with($this->anything(), $this->anything())
				->will($this->returnValue($errors));

		$response = $this->controller->Update($resourceId, $request, $this->session);

		$this->assertFalse($response->WasSuccessful());
		$this->assertNull($response->ResourceId());
		$this->assertEquals($errors, $response->Errors());
	}

	public function testDeletesResource()
	{
		$resourceId = 998;
		$resource = new FakeBookableResource($resourceId);

		$this->validator->expects($this->once())
				->method('ValidateDeleteRequest')
				->with($this->equalTo($resourceId))
				->will($this->returnValue(array()));

		$this->repository->expects($this->once())
				->method('LoadById')
				->with($this->equalTo($resourceId))
				->will($this->returnValue($resource));

		$this->repository->expects($this->once())
				->method('Delete')
				->with($this->equalTo($resource));

		$response = $this->controller->Delete($resourceId, $this->session);

		$this->assertTrue($response->WasSuccessful());
		$this->assertEquals($resourceId, $response->ResourceId());
		$this->assertEmpty($response->Errors());
	}

	public function testWhenDeleteFails()
	{
		$resourceId = 998;
		$errors = array('error');

		$this->validator->expects($this->once())
				->method('ValidateDeleteRequest')
				->with($this->equalTo($resourceId))
				->will($this->returnValue($errors));

		$response = $this->controller->Delete($resourceId, $this->session);

		$this->assertFalse($response->WasSuccessful());
		$this->assertEquals($errors, $response->Errors());
		$this->assertEmpty($response->ResourceId());
	}
}

?>