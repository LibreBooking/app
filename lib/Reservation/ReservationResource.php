<?php
class ReservationResource implements IResource
{
	private $_id;
	
	public function __construct($resourceId)
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
	 * This will always be an empty string
	 * 
	 * @see IResource::GetName()
	 */
	public function GetName()
	{
		return "";
	}
}
?>