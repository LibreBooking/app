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
	
	public function testChecksIfUserHasPermission()
	{
		$userId = 98;
		$user = new FakeUserSession();
		$user->UserId = $userId;
		
		$resourceId = 100;
		$resourceId1 = 1;
		$resourceId2 = 2;

		$rr1 = new ReservationResource($resourceId);
		$rr2 = new ReservationResource($resourceId1);

		$resource = new FakeBookableResource($resourceId, null);
		$resource1 = new FakeBookableResource($resourceId1, null);
		$resource2 = new FakeBookableResource($resourceId2, null);
		
		$reservation = new TestReservationSeries();
		$reservation->WithOwnerId($userId);
		$reservation->WithResource($resource);
		$reservation->AddResource($resource1);
		$reservation->AddResource($resource2);
		$reservation->WithBookedBy($user);
		
		$service = new FakePermissionService(array(true, false));
		$factory = $this->getMock('IPermissionServiceFactory');
		
		$factory->expects($this->once())
			->method('GetPermissionService')
			->will($this->returnValue($service));		
			
		$rule = new PermissionValidationRule($factory);
		$result = $rule->Validate($reservation);
			
		$this->assertEquals(false, $result->IsValid());
		
		$this->assertEquals($rr1, $service->Resources[0]);
		$this->assertEquals($rr2, $service->Resources[1]);
		$this->assertEquals($rr2, $service->Resources[1]);
		$this->assertEquals($user, $service->User);
	}
}

class FakePermissionService implements IPermissionService
{
	/**
	 * @var array|IResource[]
	 */
	public $Resources;

	/**
	 * @var UserSession
	 */
	public $User;
	
	public $ReturnValues;
	
	private $_invocationCount = 0;
	public function __construct($returnValues)
	{
		$this->ReturnValues = $returnValues;
	}
	
	public function CanAccessResource(IResource $resource, UserSession $user)
	{
		$this->Resources[] = $resource;
		$this->User = $user;
		
		return $this->ReturnValues[$this->_invocationCount++];
	}
}
?>