<?php
interface IResourceRepository
{
	/**
	 * Gets all Resources for the given scheduleId
	 *
	 * @param int $scheduleId
	 * @return array[int]BookableResource
	 */
	public function GetScheduleResources($scheduleId);

	/**
	 * @param int $resourceId
	 * @return BookableResource
	 */
	public function LoadById($resourceId);

	/**
	 * @param string $name
	 * @param array $additionalFields key value pair of additional fields to use during resource management
	 * @return int ID of created BookableResource
	 */
	public function AddResource($name, $additionalFields = array());

	/**
	 * @param BookableResource
	 */
	public function Add(BookableResource $resource);

	/**
	 * @param BookableResource
	 */
	public function Update(BookableResource $resource);

	/**
	 * @param BookableResource
	 */
	public function Delete(BookableResource $resource);

	/**
	 * @return BookableResource[] array of all resources
	 */
	public function GetResourceList();
}
?>
 
