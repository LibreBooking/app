<?php

require_once(ROOT_DIR . 'Domain/Access/namespace.php');

interface IResourcePermissionStore
{
    /**
     * @param $userId int
     * @return array[]int
     */
    function GetAllResources($userId);

    /**
     * @param $userId int
     * @return array[]int
     */
    function GetBookableResources($userId);

    /**
     * @param $userId int
     * @return array[]int
     */
    function GetViewOnlyResources($userId);
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

	public function GetAllResources($userId)
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

    public function GetBookableResources($userId)
    {
        $resourceIds = array();

        $user = $this->_scheduleUserRepository->GetUser($userId);

        $resources = $user->GetBookableResources();

        foreach ($resources as $resource)
        {
            $resourceIds[] = $resource->Id();
        }

        return $resourceIds;
    }

    public function GetViewOnlyResources($userId)
    {
        $resourceIds = array();

        $user = $this->_scheduleUserRepository->GetUser($userId);

        $resources = $user->GetViewOnlyResources();

        foreach ($resources as $resource)
        {
            $resourceIds[] = $resource->Id();
        }

        return $resourceIds;
    }
}
