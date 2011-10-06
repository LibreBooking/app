<?php 

require_once(ROOT_DIR . 'Domain/Access/namespace.php');

interface IResourcePermissionStore
{
	/**
	 * @param $userId int
	 * @return array[]int
	 */
	function GetPermittedResources($userId);
}

class ResourcePermissionStore implements IResourcePermissionStore
{
	/**
	 * @var IScheduleUserRepository
	 */
	private $_scheduleUserRepository;
	
	/**
	 * @param IScheduleUserRepository $scheduleUserRepository
	 */
	public function __construct(IScheduleUserRepository $scheduleUserRepository)
	{
		$this->_scheduleUserRepository = $scheduleUserRepository;
	}
	
	public function GetPermittedResources($userId)
	{
		$permittedResourceIds = array();
		
		$user = $this->_scheduleUserRepository->GetUser($userId);
		
		$resources = $user->GetAllResources();
		foreach ($resources as $resource)
		{
			$permittedResourceIds[] = $resource->Id();
		}
		
		return $permittedResourceIds;
	}
}

?>