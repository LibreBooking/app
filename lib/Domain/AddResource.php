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
/*	private $_name;
	private $_location;
	private $_contactInfo;
	private $_description;
	private $_notes;
	private $_isActive;
	private $_minDuration;
	private $_minIncrement;
	private $_maxDuration;
	private $_unitCost;
	private $_autoAssign;
	private $_requiresApproval;
	private $_allowMultiday;
	private $_maxParticipants;
	private $_minNotice;
	private $_maxNotice;
	
	private function __construct($name,
								$location,
								$contactInfo,
								$description,
								$notes,
								$isActive,
								$minDuration,
								$minIncrement,
								$maxDuration,
								$autoAssign,
								$unitCost,
								$requiresApproval,
								$allowMultiday,
								$maxParticipants,
								$minNotice,
								$maxNotice)
	{
		$this->SetResourceName($resourceName);
		$this->SetLocation($location);
		$this->SetContactInfo($contactInfo);
		$this->SetDescription($description);
		$this->SetNotes($notes);
		$this->SetIsActive($isActive);
		$this->SetMinDuration($minDuration);
		$this->SetMaxDuration($maxDuration);
		$this->SetAutoAssign($autoAssign);
		$this->SetUnitCost($unitCost);
		$this->SetRequiresApproval($requiresApproval);
		$this->SetAllowMultiday($allowMultiday);
		$this->SetMaxParticipants($maxParticipants);
		$this->SetMinNotice($minNotice);
		$this->SetMaxNotice($maxNotice);
	}
*/
	public function AddResource($name, $additionalFields = array())
	{

		$addResourceCommand = new AddResourceCommand(
					$name, 
					$additionalFields['location'],
					$additionalFields['contactInfo'],
					$additionalFields['description'], 
					$additionalFields['notes'], 
					$additionalFields['isActive'], 
					$additionalFields['minDuration'], 
					$additionalFields['minIncrement'], 
					$additionalFields['maxDuration'], 
					$additionalFields['unitCost'], 
					$additionalFields['autoAssign'], 
					$additionalFields['requiresApproval'], 
					$additionalFields['allowMultiday'], 
					$additionalFields['maxParticipants'], 
					$additionalFields['minNotice'], 
					$additionalFields['maxNotice'] 
					);
					
		$userId = ServiceLocator::GetDatabase()->ExecuteInsert($addResourceCommand);
		
		/*$this->AutoAssignPermissions($userId);
	}
		
	private function AutoAssignPermissions($userId)
	{
		$autoAssignCommand = new AutoAssignPermissionsCommand($userId);	
		ServiceLocator::GetDatabase()->Execute($autoAssignCommand);*/
	}
}
?>