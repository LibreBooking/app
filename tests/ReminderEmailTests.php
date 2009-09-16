<?php
require_once(ROOT_DIR . '/lib/CmnFns.class.php');
require_once(ROOT_DIR . '/lib/ReminderEmail.class.php');
require_once(ROOT_DIR . '/tests/fakes/FakeReminder.php');
require_once(ROOT_DIR . '/tests/fakes/EmailFakes.php');
require_once('PHPUnit/Framework.php');

class ReminderEmailTests extends PHPUnit_Framework_TestCase
{
	function testReminderEmailBuildsMailerCorrectly() {
		//$mailer = new FakeMailer();
		$mailer = $this->getMock('PHPMailer');
		$email = new ReminderEmail($mailer);
		
		$reminder = new FakeReminder();
		$email->buildFromReminder($reminder);
		
		$this->assertEquals($reminder->email, $mailer->addresses[0]);
		$this->assertEquals($subject, $mailer->Subject);
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