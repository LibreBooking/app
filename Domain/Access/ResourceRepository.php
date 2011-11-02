<?php
require_once(ROOT_DIR . 'Domain/BookableResource.php');
require_once(ROOT_DIR . 'Domain/Access/IResourceRepository.php');

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
	 * @param int $scheduleId
	 * @return array|BookableResource[]
	 */
	public function GetScheduleResources($scheduleId)
	{
		$command = new GetScheduleResourcesCommand($scheduleId);
		
		$resources = array();
		
		$reader = ServiceLocator::GetDatabase()->Query($command);
		
		while ($row = $reader->GetRow())
		{
			$resources[] = BookableResource::Create($row);
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
			$resources[] = BookableResource::Create($row);
		}
		
		$reader->Free();

		return $resources;
	}
	
    /**
     * @param  $resourceId
     * @return BookableResource
     */
	public function LoadById($resourceId)
	{
		if (!$this->_cache->Exists($resourceId))
		{
			$command = new GetResourceByIdCommand($resourceId);
	
			$reader = ServiceLocator::GetDatabase()->Query($command);

            $resource = null;
			if ($row = $reader->GetRow())
			{
				$resource = BookableResource::Create($row);
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
	
	public function Add(BookableResource $resource)
	{
		$db = ServiceLocator::GetDatabase();
		$addResourceCommand = new AddResourceCommand($resource->GetName(), $resource->GetScheduleId());
		
		$db->ExecuteInsert($addResourceCommand);
	}
	
	public function Update(BookableResource $resource)
	{
		$db = ServiceLocator::GetDatabase();
		
		$updateResourceCommand = new UpdateResourceCommand(
								$resource->GetResourceId(), 
								$resource->GetName(), 
								$resource->GetLocation(), 
								$resource->GetContact(), 
								$resource->GetNotes(), 
								$resource->GetMinLength(), 
								$resource->GetMaxLength(), 
								$resource->GetAutoAssign(), 
								$resource->GetRequiresApproval(), 
								$resource->GetAllowMultiday(),
								$resource->GetMaxParticipants(),
								$resource->GetMinNotice(),
								$resource->GetMaxNotice(),
								$resource->GetDescription(),
								$resource->GetImage(),
								$resource->IsOnline(),
								$resource->GetScheduleId());
								
		$db->Execute($updateResourceCommand);
	}
	
	public function Delete(BookableResource $resource)
	{
		Log::Debug("Deleting resource %s (%s)", $resource->GetResourceId(), $resource->GetName());
		
		$resourceId = $resource->GetResourceId();
		
		$db = ServiceLocator::GetDatabase();
		$db->Execute(new DeleteResourceReservationsCommand($resourceId));
		$db->Execute(new DeleteResourceCommand($resourceId));
	}

	public function GetAccessoryList()
	{
		$command = new GetAllAccessoriesCommand();
		$accessories = array();

		$reader = ServiceLocator::GetDatabase()->Query($command);

		while ($row = $reader->GetRow())
		{
			$accessories[] = AccessoryDto::Create($row);
		}

		$reader->Free();

		return $accessories;
	}
}

?>