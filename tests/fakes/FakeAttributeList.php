<?php

class FakeAttributeList implements IEntityAttributeList
{
	private $_attributes = array();
	private $_entityAttributes = array();

	/**
	 * @param array|Attribute[] $attributes
	 */
	public function __construct($attributes = array())
	{
		$this->_attributes = $attributes;
	}

	/**
	 * @return array|string[]
	 */
	public function GetLabels()
	{
		// TODO: Implement GetLabels() method.
	}

	/**
	 * @param null $entityId
	 * @return array|CustomAttribute[]
	 */
	public function GetDefinitions($entityId = null)
	{
		// TODO: Implement GetDefinitions() method.
	}

	/**
	 * @param $entityId int|null
	 * @return array|Attribute[]
	 */
	public function GetAttributes($entityId = null)
	{
		if (array_key_exists($entityId, $this->_entityAttributes))
		{
			return $this->_entityAttributes[$entityId];
		}
		return $this->_attributes;
	}

	public function Add($entityId, $attribute)
	{
		$this->_entityAttributes[$entityId][] = $attribute;
	}
}

?>
