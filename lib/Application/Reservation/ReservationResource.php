<?php
class ReservationResource implements IResource
{
	private $_id;
	private $_resourceName;
	
	public function __construct($resourceId, $resourceName = '')
	{
		$this->_id = $resourceId;
	}
	
	/**
	 * @see IResource::GetResourceId()
	 */
	public function GetResourceId()
	{
		return $this->_id;
	}
	
	/**
	 * @see IResource::GetName()
	 */
	public function GetName()
	{
		return $this->_resourceName;
	}

	/**
	 * @return int
	 */
	public function GetId()
	{
		return $this->_id;
	}
}
?>