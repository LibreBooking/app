<?php
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

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
			$_Resources[] = BookableResource::Create($row);
		}
	}
	
	public function GetRows()
	{
		$row1 =  array(ColumnNames::RESOURCE_ID => 1, 
					ColumnNames::RESOURCE_NAME => 'resource 1',
					ColumnNames::RESOURCE_LOCATION => null,
					ColumnNames::RESOURCE_CONTACT => null,
					ColumnNames::RESOURCE_NOTES => 'notes 1',
					ColumnNames::RESOURCE_MINDURATION => null,
					ColumnNames::RESOURCE_MAXDURATION => null,
					ColumnNames::RESOURCE_AUTOASSIGN => 0,
					ColumnNames::RESOURCE_REQUIRES_APPROVAL => 0,
					ColumnNames::RESOURCE_ALLOW_MULTIDAY => 0,
					ColumnNames::RESOURCE_MAX_PARTICIPANTS => null,
					ColumnNames::RESOURCE_MINNOTICE => null,
					ColumnNames::RESOURCE_MAXNOTICE => null,
					ColumnNames::RESOURCE_DESCRIPTION => null,
					ColumnNames::SCHEDULE_ID => 10,
					ColumnNames::RESOURCE_IMAGE_NAME => null,
					);
					
		$row2 =  array(ColumnNames::RESOURCE_ID => 2, 
					ColumnNames::RESOURCE_NAME => 'resource 2',
					ColumnNames::RESOURCE_LOCATION => 'here 2',
					ColumnNames::RESOURCE_CONTACT => '2',
					ColumnNames::RESOURCE_NOTES => 'notes 1',
					ColumnNames::RESOURCE_MINDURATION => 10,
					ColumnNames::RESOURCE_MAXDURATION => 100,
					ColumnNames::RESOURCE_AUTOASSIGN => 1,
					ColumnNames::RESOURCE_REQUIRES_APPROVAL => 1,
					ColumnNames::RESOURCE_ALLOW_MULTIDAY => 1,
					ColumnNames::RESOURCE_MAX_PARTICIPANTS => 10,
					ColumnNames::RESOURCE_MINNOTICE => 30,
					ColumnNames::RESOURCE_MAXNOTICE => 400,
					ColumnNames::RESOURCE_DESCRIPTION => null,
					ColumnNames::SCHEDULE_ID => 11,
					ColumnNames::RESOURCE_IMAGE_NAME => 'something.gif',
					);	
		
		return array($row1, $row2);								
	}
}

?>