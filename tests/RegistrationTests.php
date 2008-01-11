<?php
require_once('../lib/Authorization/namespace.php');
require_once('fakes/FakeServer.php');

class RegistrationTests extends PHPUnit_Framework_TestCase
{
	private $registration;
	private $db;
	private $fakeServer;
	
	public function setUp()
	{
		$this->db = new FakeDatabase();
		$this->fakeServer = new FakeServer();

		ServiceLocator::SetDatabase($this->db);
		ServiceLocator::SetServer($this->fakeServer);
		
		$this->registration = new Registration();
	}
	
	public function testChecksIfUserAlreadyRegistered()
	{
		$rows = array(array());
		$this->db->SetRows($rows);
		
		$exists = $this->registration->UserExists($loginName, $emailAddress);
		
		$this->assertEquals(new CheckUserExistanceCommand($loginName, $emailAddress), $this->db->_LastCommand);
		$this->assertFalse($exists);
		
		$rows = array(array(ColumnNames::USER_ID => 100));
		$this->db->SetRows($rows);
		
		$exists = $this->registration->UserExists($loginName, $emailAddress);
		$this->assertTrue($exists);
	}
}
?>