<?php
require_once(ROOT_DIR . 'lib/Application/Reservation/Validation/namespace.php');
require_once(ROOT_DIR . 'tests/Domain/Reservation/TestReservationSeries.php');

class ReservationValidationRuleProcessorTests extends TestBase
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
		$reservation = new ExistingReservationSeries();
		$validResult = new ReservationRuleResult(true);
		
		$rule1 = $this->getMock('IUpdateReservationValidationRule');
		$rule2 = $this->getMock('IUpdateReservationValidationRule');
		$rule3 = $this->getMock('IUpdateReservationValidationRule');
		
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
		
		$vs = new ReservationValidationRuleProcessor($rules);
		$result = $vs->Validate($reservation);
		
		$this->assertEquals(true, $result->CanBeSaved());
		$this->assertEquals(0, count($result->GetErrors()));
		$this->assertEquals(0, count($result->GetWarnings()));
	}
	
	public function testValidatesStopsAfterFirstBrokenRule()
	{
		$reservation = new ExistingReservationSeries();
		
		$rule1 = $this->getMock('IUpdateReservationValidationRule');
		$rule2 = $this->getMock('IUpdateReservationValidationRule');
		$rule3 = $this->getMock('IUpdateReservationValidationRule');
		
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
		
		$vs = new ReservationValidationRuleProcessor($rules);
		
		$result = $vs->Validate($reservation);
		
		$this->assertEquals(false, $result->CanBeSaved());
		$actualErrors = $result->GetErrors();
		$this->assertEquals($error, $actualErrors[0]);
		$this->assertEquals(0, count($result->GetWarnings()));
	}
}

?>