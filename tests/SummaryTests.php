<?php

require_once('../lib/Summary.class.php');
require_once('PHPUnit/Framework.php');

class SummaryTests extends PHPUnit_Framework_TestCase
{
    // contains the object handle of the string class
    var $db = null;

    // constructor of the test suite
    function SummaryTests($name) {
       $this->PHPUnit_Framework_TestCase($name);
    }
	
	function testSummaryIsCorrectLength() {
		$text = 'will fit';
		$day = 1440;
		$span = 30;
		$start = 0;
		$end = 30;
		
		// min = 10
		// chars = 2 * reslength/min
		// chars = 3 * 1440/$day;
		
		$summary = new Summary('will fit');

		$summary->toScheduleCell($day, $span, $start, $end);	
		$this->assertEquals(0, $summary->GetAvailableSize());
		
		$summary->toScheduleCell(1440, $span, $start, 60);
		$this->assertEquals(6, $summary->GetAvailableSize());
		
		$summary->toScheduleCell(1440, $span, $start, 90);	
		$this->assertEquals(9, $summary->GetAvailableSize());
		
		$summary->toScheduleCell(720, $span, $start, 30);	
		$this->assertEquals(5, $summary->GetAvailableSize());
		
		$summary->toScheduleCell(720, $span, $start, 60);	
		$this->assertEquals(10, $summary->GetAvailableSize());
		
		$summary->toScheduleCell(720, $span, $start, 90);	
		$this->assertEquals(15, $summary->GetAvailableSize());
		
		$summary->toScheduleCell(480, $span, $start, 30);	
		$this->assertEquals(8, $summary->GetAvailableSize());
		
		$summary->toScheduleCell(480, $span, $start, 60);	
		$this->assertEquals(16, $summary->GetAvailableSize());
		
		$summary->toScheduleCell(480, $span, $start, 90);	
		$this->assertEquals(24, $summary->GetAvailableSize());
	}
}