<?php
@define('BASE_DIR', dirname(__FILE__) . '/..');
require_once(BASE_DIR . '/lib/CmnFns.class.php');
require_once(BASE_DIR . '/lib/ReminderEmail.class.php');
require_once('fakes/FakeReminder.php');
require_once('fakes/EmailFakes.php');
require_once('PHPUnit.php');

class ReminderEmailTests extends PHPUnit_TestCase
{
 	function ReminderEmailTests($name) {
       $this->PHPUnit_TestCase($name);
    }
	
	function testReminderEmailBuildsMailerCorrectly() {
		$mailer = new FakeMailer();
		$email = new ReminderEmail($mailer);
		
		$reminder = new FakeReminder();
		$email->buildFromReminder($reminder);
		
		$this->assertEquals($reminder->email, $mailer->addresses[0]);
		$this->assertNotNull($mailer->Subject);
		$this->assertEquals($reminder->email, $mailer->From);
		$this->assertEquals('', $mailer->FromName);
		$this->assertNotNull($mailer->Body);
		$this->assertFalse($mailer->isHtml);
	}
	
	function testReminderEmailSendsFromMailer() {
		$mailer = new FakeMailer();
		$email = new ReminderEmail($mailer);
		$email->send();
		$this->assertTrue($mailer->sendWasCalled);
	}
}
?>