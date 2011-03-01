<?php
require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/namespace.php');
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/namespace.php');
require_once(ROOT_DIR . 'tests/Domain/Reservation/TestReservationSeries.php');

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
		
		$userSession = new FakeUserSession(false, 'CST', 1909);

		$resource = new ReservationResource($resourceId);
		$resource1 = new ReservationResource($resourceId1);
		
		$reservation = new TestReservationSeries();
		$reservation->WithOwnerId($userId);
		$reservation->WithResourceId($resourceId);
		$reservation->AddResource($resourceId1);
		$reservation->AddResource($resourceId2);
		
		$service = new FakePermissionService(array(true, false));
		$factory = $this->getMock('IPermissionServiceFactory');
		
		$factory->expects($this->once())
			->method('GetPermissionService')
			->with($this->equalTo($userId))
			->will($this->returnValue($service));		
			
		$rule = new PermissionValidationRule($factory, $userSession);
		$result = $rule->Validate($reservation);
			
		$this->assertEquals(false, $result->IsValid());
		
		$this->assertEquals($resource, $service->Resources[0]);
		$this->assertEquals($resource1, $service->Resources[1]);
	}
	
	public function testSkipsPermissionCheckIfUserIsAnAdmin()
	{
		$userSession = new FakeUserSession(true, 'CST', 1909);
		
		$rule = new PermissionValidationRule($this->getMock('IPermissionServiceFactory'), $userSession);
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