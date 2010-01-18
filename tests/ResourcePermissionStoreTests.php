<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');

class ResourcePermissionStoreTests extends TestBase
{
	public function testRepositoryIsAccessedForUserPermissionInformation()
	{
		$userId = 99;
		
		$rid1 = 1;
		$rid2 = 2;
		$r1 = new ScheduleResource($rid1, 'resource 1');
		$r2 = new ScheduleResource($rid2, 'resource 2');
		$resources = array($r1, $r2);
		
		$rid3 = 3;
		$rid4 = 4;
		$r3 = new ScheduleResource($rid3, 'resource 3');
		$r4 = new ScheduleResource($rid4, 'resource 4');
		
		$g1 = new ScheduleGroup(100, array($r1, $r3));
		$g2 = new ScheduleGroup(200, array($r1, $r4, $r3));
		$groups = array($g1, $g2);
		
		$user = $this->getMock('IScheduleUser');
		
		$user->expects($this->once())
			->method('GetAllResources')
			->will($this->returnValue(array($r1, $r2, $r3, $r4)));
		
		$userRepository = $this->getMock('IScheduleUserRepository');
		
		$userRepository->expects($this->once())
			->method('GetUser')
			->with($this->equalTo($userId))
			->will($this->returnValue($user));
		
		$rps = new ResourcePermissionStore($userRepository);
		
		$permittedResources = $rps->GetPermittedResources($userId);
		
		$this->assertEquals(4, count($permittedResources));
		$this->assertContains($rid1, $permittedResources);
		$this->assertContains($rid2, $permittedResources);
		$this->assertContains($rid3, $permittedResources);
		$this->assertContains($rid4, $permittedResources);
	}
}
?>