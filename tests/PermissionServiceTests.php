<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');

class PermissionServiceTests extends TestBase
{
	public function testAsksStoreForAllowedResourcesAndReturnsTrueIfItExists()
	{
		$userId = 99;
		$resource = new FakeResource(1, 'whatever');
		$resourceIdList = array(3, 1, 4);
		
		$store = $this->getMock('IResourcePermissionStore');
		$ps = new PermissionService($store, $userId);
		
		$store->expects($this->once())
			->method('GetPermittedResources')
			->with($this->equalTo($userId))
			->will($this->returnValue($resourceIdList));
		
		$canAccess = $ps->CanAccessResource($resource);
		
		$this->assertTrue($canAccess);
	}
}
?>