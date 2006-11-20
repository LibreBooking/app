<?php
require_once('lib/ReminderEmail.class.php');
require_once('fakes/FakeReminder.php');
require_once('fakes/EmailFakes.php');
require_once('PHPUnit.php');

class ReminderEmailTests extends PHPUnit_TestCase
{
 	function ReminderEmailTests() {
       $this->PHPUnit_TestCase('Reminder Email Tests');
    }
	
	function testReminderEmailBuildsMailerCorrectly() {
		$mailer = new FakeMailer();
		$email = new ReminderEmail($mailer);
		
		$reminder = new FakeReminder();
		$email->buildFromReminder($reminder);
		
		$this->assertEquals($reminder->email, $mailer->addresses[0]);
	}
}
?>