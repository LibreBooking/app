<?php
require_once(ROOT_DIR . 'Domain/namespace.php');

class AddReservationValidationServiceTests extends TestBase
{
	public function setup()
	{
		parent::setup();
	}

	public function teardown()
	{
		parent::teardown();
	}
	
	public function testValidatesAgainstAllRules()
	{
		$reservation = new ReservationSeries();
		$validResult = new ReservationRuleResult(true);
		
		$rule1 = $this->getMock('IReservationValidationRule');
		$rule2 = $this->getMock('IReservationValidationRule');
		$rule3 = $this->getMock('IReservationValidationRule');
		
		$rule1->expects($this->once())
			->method('Validate')
			->with($this->equalTo($reservation))
			->will($this->returnValue($validResult));
			
		$rule2->expects($this->once())
			->method('Validate')
			->with($this->equalTo($reservation))
			->will($this->returnValue($validResult));
			
		$rule3->expects($this->once())
			->method('Validate')
			->with($this->equalTo($reservation))
			->will($this->returnValue($validResult));
		
		$rules = array($rule1, $rule2, $rule3);
		
		$vs = new AddReservationValidationService($rules);
		$result = $vs->Validate($reservation);
		
		$this->assertEquals(true, $result->CanBeSaved());
		$this->assertEquals(0, count($result->GetErrors()));
		$this->assertEquals(0, count($result->GetWarnings()));
	}
	
	public function testValidatesStopsAfterFirstBrokenRule()
	{
		$reservation = new ReservationSeries();
		
		$rule1 = $this->getMock('IReservationValidationRule');
		$rule2 = $this->getMock('IReservationValidationRule');
		$rule3 = $this->getMock('IReservationValidationRule');
		
		$rules = array($rule1, $rule2, $rule3);
		
		$rule1->expects($this->once())
			->method('Validate')
			->with($this->equalTo($reservation))
			->will($this->returnValue(new ReservationRuleResult()));
			
		$error = 'something went wrong';
		
		$rule2->expects($this->once())
			->method('Validate')
			->with($this->equalTo($reservation))
			->will($this->returnValue(new ReservationRuleResult(false, $error)));
		
		$vs = new AddReservationValidationService($rules);
		
		$result = $vs->Validate($reservation);
		
		$this->assertEquals(false, $result->CanBeSaved());
		$actualErrors = $result->GetErrors();
		$this->assertEquals($error, $actualErrors[0]);
		$this->assertEquals(0, count($result->GetWarnings()));
	}
}

?>