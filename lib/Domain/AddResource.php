<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');

interface IAddResource
{
	/**
	 * @param string $name
	 * @param array $additionalFields key value pair of additional fields to use during resource management
	 */
	public function AddResource($name, $additionalFields = array());
}

class AddResource implements IAddResource 
{	
	public function AddResource($name, $additionalFields = array())
	{
		$name = '';
		$additionalFields['location'] = '';
		$additionalFields['contact_info'] = '';
		$additionalFields['description'] = '';
		$additionalFields['notes'] = '';
		$additionalFields['isactive'] = '';
		$additionalFields['min_duration'] = '';
		$additionalFields['min_increment'] = '';
		$additionalFields['max_duration'] = '';
		$additionalFields['unit_cost'] = '';
		$additionalFields['autoassign'] = '';
		$additionalFields['requires_approval'] = '';
		$additionalFields['allow_multiday'] = '';
		$additionalFields['max_participants'] = '';
		$additionalFields['min_notice_time'] = '';
		$additionalFields['max_notice_time'] = '';
		
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
					$additionalFields['allow_multiday'], 
					$additionalFields['max_participants'], 
					$additionalFields['min_notice_time'], 
					$additionalFields['max_notice_time'] 
					);
					
		$userId = ServiceLocator::GetDatabase()->ExecuteInsert($resourceEditCommand);
		
		/*$this->AutoAssignPermissions($userId);
	}
		
	private function AutoAssignPermissions($userId)
	{
		$autoAssignCommand = new AutoAssignPermissionsCommand($userId);	
		ServiceLocator::GetDatabase()->Execute($autoAssignCommand);*/
	}
}
?>