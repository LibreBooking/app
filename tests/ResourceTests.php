<?php
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Domain/Access/namespace.php');

class ResourceTests extends TestBase
{
	public function setup()
	{
		parent::setup();		
	}
	
	public function teardown()
	{
		parent::teardown();
	}
	
	public function testCanGetAllResourcesForASchedule()
	{
//		$this->markTestIncomplete("need to decide what to do with this.  
//			ideas: put into factory which knows how to create from db rows |
//			create data access class for query |
//			create data class for resource object");
		$expected = array();
		$scheduleId = 10;
		
		$rows = FakeResourceAccess::GetRows();
		$this->db->SetRow(0, $rows);
		
		foreach ($rows as $row)
		{
			$expected[] = Resource::Create($row);
		}
		
		$resourceAccess = new ResourceRepository();
		$resources = $resourceAccess->GetScheduleResources($scheduleId);
		
		$this->assertEquals(new GetScheduleResourcesCommand($scheduleId), $this->db->_Commands[0]);
		$this->assertTrue($this->db->GetReader(0)->_FreeCalled);
		$this->assertEquals(count($rows), count($resources));
		$this->assertEquals($expected, $resources);
	}
	
	
}

?>