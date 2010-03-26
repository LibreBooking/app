<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');

class Resource implements IResource 
{	
	public function Resource($name, $additionalFields = array())
	{
		$resourceEditCommand = new ResourceEditCommand(
					$name, 
					$additionalFields['location'],
					$additionalFields['contact_info'],
					$additionalFields['description'], 
					$additionalFields['notes'], 
					$additionalFields['isactive'], 
					$additionalFields['min_duration'], 
					$additionalFields['min_increment'], 
					$additionalFields['max_duration'], 
					$additionalFields['unit_cost'], 
					$additionalFields['autoassign'], 
					$additionalFields['requires_approval'], 
					$additionalFields['allow_multiple_day_reservations'], 
					$additionalFields['max_participants'], 
					$additionalFields['min_notice_time'], 
					$additionalFields['max_notice_time'], 
					$additionalFields['constraint_id'], 
					$additionalFields['long_quota_id'], 
					$additionalFields['day_quota_id']
					);
					
		$userId = ServiceLocator::GetDatabase()->ExecuteInsert($resourceEditCommand);
		
		//$this->AutoAssignPermissions($userId);
	}
		
/*	private function AutoAssignPermissions($userId)
	{
		$autoAssignCommand = new AutoAssignPermissionsCommand($userId);	
		ServiceLocator::GetDatabase()->Execute($autoAssignCommand);
	}*/
}
?>