<?php
require_once(ROOT_DIR . 'lib/Domain/Resource.php');

interface IResourceRepository
{
	/**
	 * Gets all Resources for the given scheduleId
	 *
	 * @param int $scheduleId
	 * @return array[int]Resource
	 */
	public function GetScheduleResources($scheduleId);
	
	/**
	 * @param int $resourceId
	 * @return Resource
	 */
	public function LoadById($resourceId);
	
	/**
	 * @param string $name
	 * @param array $additionalFields key value pair of additional fields to use during resource management
	 * @return int ID of created Resource
	 */
	public function AddResource($name, $additionalFields = array());
}

class ResourceRepository implements IResourceRepository
{
	public function __construct() 
	{
	}
	
	/**
	 * @see IResourceRepository::GetScheduleResources()
	 */
	public function GetScheduleResources($scheduleId)
	{
		$command = new GetScheduleResourcesCommand($scheduleId);
		
		$resources = array();
		
		$reader = ServiceLocator::GetDatabase()->Query($command);
		
		while ($row = $reader->GetRow())
		{
			$resources[] = Resource::Create($row);
		}
		
		$reader->Free();
		
		return $resources;
	}
	
	/**
	 * @see IResourceRepository::LoadById()
	 */
	public function LoadById($resourceId)
	{
		//TODO: Implement for real
		
		return new Resource();
	}
	
	/**
	 * @see IResourceRepository::AddResource()
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
					
		$lastResourceId = ServiceLocator::GetDatabase()->ExecuteInsert($addResourceCommand);
		
		return $lastResourceId;
	}
}

?>