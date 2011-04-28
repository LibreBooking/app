<?php
class FakeBookableResource extends BookableResource
{
	public $_id;
	public $_name;
	
	public function __construct($id, $name)
	{
		$this->_id = $id;
		$this->_name = $name;
	}
	
	public function GetResourceId()
	{
		return $this->_id;
	}
	
	public function GetName()
	{
		return $this->_name;
	}
}
?>