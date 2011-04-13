<?php
require_once(ROOT_DIR . 'Domain/Resource.php');

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
	
	/**
	 * @return Resource[] array of all resources
	 */
	public function GetResourceList();
}

class ResourceRepository implements IResourceRepository
{
	/**
	 * @var DomainCache
	 */
	private $_cache;
	
	public function __construct() 
	{
		$this->_cache = new DomainCache();
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
	
	public function GetResourceList()
	{
		$command = new GetAllResourcesCommand();
		
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
		if (!$this->_cache->Exists($resourceId))
		{
			$command = new GetResourceByIdCommand($resourceId);
	
			$reader = ServiceLocator::GetDatabase()->Query($command);
			
			if ($row = $reader->GetRow())
			{
				$resource = Resource::Create($row);
			}
			
			$reader->Free();
			
			$this->_cache->Add($resourceId, $resource);
		}
		
		return $this->_cache->Get($resourceId);
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