<?php
class FakeBookableResource extends BookableResource
{
	public function __construct($id, $name = null)
	{
		$this->_resourceId = $id;
		$this->_name = $name;
	}
}
?>