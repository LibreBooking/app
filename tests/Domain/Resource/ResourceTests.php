<?php
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'tests/fakes/namespace.php');

class ResourceTests extends TestBase
{
	public function setup()
	{
		parent::setup();		
	}
	
	public function teardown()
	{
		parent::teardown();
	}
	
	public function testCanGetAllResourcesForASchedule()
	{
		$expected = array();
		$scheduleId = 10;
		
		$ra = new FakeResourceAccess();
		$rows = $ra->GetRows();
		$this->db->SetRow(0, $rows);
		
		foreach ($rows as $row)
		{
			$expected[] = Resource::Create($row);
		}
		
		$resourceAccess = new ResourceRepository();
		$resources = $resourceAccess->GetScheduleResources($scheduleId);
		
		$this->assertEquals(new GetScheduleResourcesCommand($scheduleId), $this->db->_Commands[0]);
		$this->assertTrue($this->db->GetReader(0)->_FreeCalled);
		$this->assertEquals(count($rows), count($resources));
		$this->assertEquals($expected, $resources);
	}
	
	public function testResourceServiceChecksPermissionForEachResource()
	{
		$scheduleId = 100;
		
		$permissionService = $this->getMock('IPermissionService');
		$resourceRepository = $this->getMock('IResourceRepository');
		
		$resourceService = new ResourceService($resourceRepository);
		
		$resource1 = new FakeResource(1, 'resource1');
		$resource2 = new FakeResource(2, 'resource2');
		$resource3 = new FakeResource(3, 'resource3');
		$resource4 = new FakeResource(4, 'resource4');
		$resources = array($resource1, $resource2, $resource3, $resource4);

		$resourceRepository->expects($this->once())
			->method('GetScheduleResources')
			->with($this->equalTo($scheduleId))
			->will($this->returnValue($resources));
			
		$permissionService->expects($this->at(0))
			->method('CanAccessResource')
			->with($this->equalTo($resource1))
			->will($this->returnValue(true));
		
		$permissionService->expects($this->at(1))
			->method('CanAccessResource')
			->with($this->equalTo($resource2))
			->will($this->returnValue(true));
		
		$permissionService->expects($this->at(2))
			->method('CanAccessResource')
			->with($this->equalTo($resource3))
			->will($this->returnValue(true));
		
		$permissionService->expects($this->at(3))
			->method('CanAccessResource')
			->with($this->equalTo($resource4))
			->will($this->returnValue(false));
		
		$resourceDto1 = new ResourceDto(1, 'resource1', true);
		$resourceDto2 = new ResourceDto(2, 'resource2', true);
		$resourceDto3 = new ResourceDto(3, 'resource3', true);
		$resourceDto4 = new ResourceDto(4, 'resource4', false);
		
		$expected = array($resourceDto1, $resourceDto2, $resourceDto3, $resourceDto4);
		
		$actual = $resourceService->GetScheduleResources($scheduleId, true, $permissionService);

		$this->assertEquals($expected, $actual);
	}	
	
	public function testResourcesAreNotReturnedIfNotIncludingInaccessibleResources()
	{
		$scheduleId = 100;
		
		$permissionService = $this->getMock('IPermissionService');
		$resourceRepository = $this->getMock('IResourceRepository');
		
		$resourceService = new ResourceService($resourceRepository);
		
		$resource1 = new FakeResource(1, 'resource1');
		
		$resourceRepository->expects($this->once())
			->method('GetScheduleResources')
			->with($this->equalTo($scheduleId))
			->will($this->returnValue(array($resource1)));
			
		$permissionService->expects($this->at(0))
			->method('CanAccessResource')
			->with($this->equalTo($resource1))
			->will($this->returnValue(false));
			
		$includeInaccessibleResources = false;
		$actual = $resourceService->GetScheduleResources($scheduleId, $includeInaccessibleResources, $permissionService);
		
		$this->assertEquals(0, count($actual));
	}
	
	public function testCanUpdateResource()
	{
		$id = 8383;
		$name = "name";
		$location = "location";
		$contact = "contact";
		$notes = "notes"; 
		$minLength = "2:30"; 
		$maxLength = "4:30";
		$autoAssign = 1;
		$requiresApproval = 0;
		$allowMultiday = 1;
		$maxParticipants = 100;
		$minNotice = "10:15";
		$maxNotice= "15:15";
		$description = "description";
		$scheduleId = 19819;
		$imageName = 'something.png';
								
		$resource = new Resource($id, 
								$name, 
								$location, 
								$contact, 
								$notes, 
								$minLength, 
								$maxLength, 
								$autoAssign, 
								$requiresApproval, 
								$allowMultiday,
								$maxParticipants,
								$minNotice,
								$maxNotice,
								$description,
								$scheduleId);
		$resource->SetImage($imageName);
		
		$resourceRepository = new ResourceRepository();
		$resourceRepository->Update($resource);
		
		$expectedUpdateResourceCommand = new UpdateResourceCommand(
								$id, 
								$name, 
								$location, 
								$contact, 
								$notes, 
								Time::Parse($minLength), 
								Time::Parse($maxLength), 
								$autoAssign, 
								$requiresApproval, 
								$allowMultiday,
								$maxParticipants,
								Time::Parse($minNotice),
								Time::Parse($maxNotice),
								$description,
								$imageName);
								
		$expectedUpdateScheduleCommand = new UpdateResourceScheduleCommand($id, $scheduleId);
								
		$actualUpdateResourceCommand = $this->db->_Commands[0];
		$actualUpdateScheduleCommand = $this->db->_Commands[1];
		
		$this->assertEquals($expectedUpdateResourceCommand, $actualUpdateResourceCommand);
		$this->assertEquals($expectedUpdateScheduleCommand, $actualUpdateScheduleCommand);
	}
}

?>