<?php
/**
Copyright 2013-2016 Nick Korbel

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

require_once(ROOT_DIR . 'WebServices/Validators/ResourceRequestValidator.php');

class ResourceRequestValidatorTests extends TestBase
{
	/**
	 * @var ResourceRequestValidator
	 */
	private $validator;

	/**
	 * @var IAttributeService
	 */
	private $attributeService;

	public function setup()
	{
		$this->attributeService = $this->getMock('IAttributeService');
		$this->validator = new ResourceRequestValidator($this->attributeService);
		parent::setup();
	}

	public function testBasicRequiredFields()
	{
		$request = ResourceRequest::Example();
		$request->customAttributes = null;
		$request->name = null;
		$request->scheduleId = '   ';

		$createErrors = $this->validator->ValidateCreateRequest($request);
		$updateErrors = $this->validator->ValidateUpdateRequest(1, $request);

		$this->assertEquals(2, count($createErrors));
		$this->assertEquals(2, count($updateErrors));
	}

	public function testTimesAreCheckedWhenProvided()
	{
		$request = ResourceRequest::Example();
		$request->customAttributes = null;
		$request->maxNotice = 'xyz';

		$createErrors = $this->validator->ValidateCreateRequest($request);
		$updateErrors = $this->validator->ValidateUpdateRequest(1, $request);

		$this->assertEquals(1, count($createErrors));
		$this->assertEquals(1, count($updateErrors));
	}

	public function testCustomAttributesAreValidated()
	{
		$request = ResourceRequest::Example();

		$result = new AttributeServiceValidationResult(false, array('error'));
		$this->attributeService->expects($this->atLeastOnce())
				->method('Validate')
				->with($this->equalTo(CustomAttributeCategory::RESOURCE),
					   $this->equalTo(array(new AttributeValue($request->customAttributes[0]->attributeId, $request->customAttributes[0]->attributeValue))))
				->will($this->returnValue($result));

		$createErrors = $this->validator->ValidateCreateRequest($request);
		$updateErrors = $this->validator->ValidateUpdateRequest(1, $request);

		$this->assertEquals(1, count($createErrors));
		$this->assertEquals(1, count($updateErrors));
	}

	public function testUpdateAndDeleteRequireResourceId()
	{
		$request = ResourceRequest::Example();
		$request->customAttributes = null;

		$deleteErrors = $this->validator->ValidateDeleteRequest(null);
		$updateErrors = $this->validator->ValidateUpdateRequest('', $request);

		$this->assertEquals(1, count($deleteErrors));
		$this->assertEquals(1, count($updateErrors));
	}
}

?>