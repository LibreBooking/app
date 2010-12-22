<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Reservation/namespace.php');
require_once(ROOT_DIR . 'lib/Reservation/Validation/namespace.php');

class PermissionValidationRuleTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function teardown()
	{
		parent::teardown();
	}
	
	public function testChecksIfUserHasPermissionIfUserIsNotAnAdmin()
	{
		$userId = 98;
		$resourceId = 100;
		$resourceId1 = 1;
		$resourceId2 = 2;
		
		$this->fakeServer->UserSession = new FakeUserSession(false, 'CST', 1909);

		$resource = new ReservationResource($resourceId);
		$resource1 = new ReservationResource($resourceId1);
		
		$reservation = new ReservationSeries();
		$reservation->Update($userId, $resourceId, null, null, null);
		$reservation->AddResource($resourceId1);
		$reservation->AddResource($resourceId2);
		
		$service = new FakePermissionService(array(true, false));
		$factory = $this->getMock('IPermissionServiceFactory');
		
		$factory->expects($this->once())
			->method('GetPermissionService')
			->with($this->equalTo($userId))
			->will($this->returnValue($service));		
			
		$rule = new PermissionValidationRule($factory);
		$result = $rule->Validate($reservation);
			
		$this->assertEquals(false, $result->IsValid());
		
		$this->assertEquals($resource, $service->Resources[0]);
		$this->assertEquals($resource1, $service->Resources[1]);
	}
	
	public function testSkipsPermissionCheckIfUserIsAnAdmin()
	{
		$this->fakeServer->UserSession = new FakeUserSession(true, 'CST', 1909);
		
		$rule = new PermissionValidationRule($this->getMock('IPermissionServiceFactory'));
		$result = $rule->Validate(null);
		
		$this->assertEquals(true, $result->IsValid());
	}
}

class FakePermissionService implements IPermissionService
{
	public $Resources;
	public $ReturnValues;
	
	private $_invokationCount = 0;
	public function __construct($returnValues)
	{
		$this->ReturnValues = $returnValues;
	}
	
	public function CanAccessResource(IResource $resource)
	{
		$this->Resources[] = $resource;
		
		return $this->ReturnValues[$this->_invokationCount++];
	}
}
?>