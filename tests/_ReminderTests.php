<?php
@define('BASE_DIR', dirname(__FILE__) . '/..');
require_once('fakes/FakeReservation.php');
require_once(BASE_DIR . '/lib/Reminder.class.php');
require_once('PHPUnit.php');

class ReminderTests extends PHPUnit_TestCase
{
 	function ReminderTests($name) {
       $this->PHPUnit_TestCase($name);
    }
	
	function testCalculateReminderTimeGetsCorrectValue() {
		$res = new FakeReservation();		
		$reminder = new Reminder();
		
		// Same day
		$reminder_time = $reminder->_calculateReminderTime($res->start_date, $res->start, 15);
		$hour = $res->start / 60;
		$min = ($res->start % 60) - 15;
		$date_part = getdate($res->start_date);
		$this->assertEquals( date(REMINDER_DATE_FORMAT, mktime($hour, $min, 0, $date_part['mon'], $date_part['mday'], $date_part['year'])), $reminder_time, 'incorrect reminder time');
		
		// Earlier day
		$reminder_time = $reminder->_calculateReminderTime($res->start_date, $res->start, 600);
		$hour = $res->start / 60;
		$min = ($res->start % 60) - 600;
		$date_part = getdate($res->start_date);
		$this->assertEquals( date(REMINDER_DATE_FORMAT, mktime($hour, $min, 0, $date_part['mon'], $date_part['mday'], $date_part['year'])), $reminder_time, 'incorrect reminder time');
	}
	
	function testToDateTimeGetsCorrectDatetime() {
		$reminder = new Reminder();
		$reminder->reminder_time = 200603220745;
		$this->assertEquals(mktime(07, 45, 00, 03, 22, 2006), $reminder->toDateTime());
	}
	
	function testGetMinutuesPriorGetsCorrectNumberOfMinutes() {
		$res = new FakeReservation();		
		$reminder = new Reminder();
		
		// Same day
		$reminder->reminder_time = 200603220745;		
		$expected_time = 15;
		$this->assertEquals($expected_time, $reminder->getMinutuesPrior($res), 'minutes prior is incorrect');
		
		// Earlier day
		$reminder->reminder_time = 200603212200;		
		$expected_time = 600;
		$this->assertEquals($expected_time, $reminder->getMinutuesPrior($res), 'minutes prior is incorrect');
		
		// No reminder
		$reminder->reminder_time = 0;
		$expected_time = 0;
		$this->assertEquals(0, $reminder->getMinutuesPrior($res), 'minutes prior is incorrect');
	}
	
	function testSetReminderTimeSetsTimeToZeroIfNotValid() {
		$reminder = new Reminder();
		$reminder->set_reminder_time(null);
		$this->assertEquals(0, $reminder->reminder_time);
		
		$reminder->set_reminder_time('');
		$this->assertEquals(0, $reminder->reminder_time);
		
		$reminder->set_reminder_time(000000);
		$this->assertEquals(0, $reminder->reminder_time);
	}
}
?>
