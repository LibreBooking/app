<?php
require_once(ROOT_DIR . 'lib/Domain/Resource.php');

interface IResourceAccess
{
	/**
	 * Gets all Resources for the given scheduleId
	 *
	 * @param int $scheduleId
	 * @return array of Resource objects
	 */
	public function GetScheduleResources($scheduleId);
}

class ResourceAccess implements IResourceAccess
{
	public function __construct() 
	{
	}
	
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
}

?>