<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/

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
			$this->_Resources[] = BookableResource::Create($row);
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
					ColumnNames::RESOURCE_ADMIN_GROUP_ID => null,
					ColumnNames::ALLOW_CALENDAR_SUBSCRIPTION => 1,
					ColumnNames::PUBLIC_ID => '1232',
					ColumnNames::SCHEDULE_ADMIN_GROUP_ID_ALIAS => 1154,
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
					ColumnNames::RESOURCE_ADMIN_GROUP_ID => 1,
                    ColumnNames::ALLOW_CALENDAR_SUBSCRIPTION => 0,
            	    ColumnNames::PUBLIC_ID => null,
					ColumnNames::SCHEDULE_ADMIN_GROUP_ID_ALIAS => 9292,
					);	
		
		return array($row1, $row2);								
	}
}

?>