<?php
require_once(ROOT_DIR . 'lib/Domain/Access/namespace.php');

class FakeResourceAccess extends ResourceRepository 
{
	public $_GetForScheduleCalled = false;
	public $_LastScheduleId;
	public $_Resources = array();
	
	public function __construct()
	{
		$this->FillRows();
	}

	public function GetScheduleResources($scheduleId)
	{
		$this->_GetForScheduleCalled = true;
		$this->_LastScheduleId = $scheduleId;
		
		return $this->_Resources;
	}
	
	private function FillRows()
	{
		$rows = $this->GetRows();
		foreach ($rows as $row)
		{
			$_Resources[] = Resource::Create($row);
		}
	}
	
	public function GetRows()
	{
		$row1 =  array(ColumnNames::RESOURCE_ID => 1, 
					ColumnNames::RESOURCE_NAME => 'resource 1',
					ColumnNames::RESOURCE_LOCATION => null,
					ColumnNames::RESOURCE_PHONE => null,
					ColumnNames::RESOURCE_NOTES => 'notes 1',
					ColumnNames::RESOURCE_MINLENGTH => null,
					ColumnNames::RESOURCE_MAXLENGTH => null,
					ColumnNames::RESOURCE_AUTOASSIGN => 0,
					ColumnNames::RESOURCE_REQUIRES_APPROVAL => 0,
					ColumnNames::RESOURCE_ALLOW_MULTIDAY => 0,
					ColumnNames::RESOURCE_MAX_PARTICIPANTS => null,
					ColumnNames::RESOURCE_MINNOTICE => null,
					ColumnNames::RESOURCE_MAXNOTICE => null
					);
					
		$row2 =  array(ColumnNames::RESOURCE_ID => 2, 
					ColumnNames::RESOURCE_NAME => 'resource 2',
					ColumnNames::RESOURCE_LOCATION => 'here 2',
					ColumnNames::RESOURCE_PHONE => '2',
					ColumnNames::RESOURCE_NOTES => 'notes 1',
					ColumnNames::RESOURCE_MINLENGTH => 10,
					ColumnNames::RESOURCE_MAXLENGTH => 100,
					ColumnNames::RESOURCE_AUTOASSIGN => 1,
					ColumnNames::RESOURCE_REQUIRES_APPROVAL => 1,
					ColumnNames::RESOURCE_ALLOW_MULTIDAY => 1,
					ColumnNames::RESOURCE_MAX_PARTICIPANTS => 10,
					ColumnNames::RESOURCE_MINNOTICE => 30,
					ColumnNames::RESOURCE_MAXNOTICE => 400
					);	
		
		return array($row1, $row2);								
	}
}

?>