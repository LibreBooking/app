<?php
require_once(ROOT_DIR . 'lib/Domain/namespace.php');

class Resource implements IResource 
{	
	public function Resource($name, $additionalFields = array())
	{
		$resourceEditCommand = new ResourceEditCommand(
					$name, 
					$additionalFields['phone'],
					$additionalFields['institution'],
					$additionalFields['position'], 
					);
					
		$userId = ServiceLocator::GetDatabase()->ExecuteInsert($resourceCommand);
		
		//$this->AutoAssignPermissions($userId);
	}
		
/*	private function AutoAssignPermissions($userId)
	{
		$autoAssignCommand = new AutoAssignPermissionsCommand($userId);	
		ServiceLocator::GetDatabase()->Execute($autoAssignCommand);
	}*/
}
?>