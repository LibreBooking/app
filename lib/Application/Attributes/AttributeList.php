<?php
/**
Copyright 2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
 */

interface IEntityAttributeList
{
	/**
	 * @return array|string[]
	 */
	public function GetLabels();

	/**
	 * @return array|CustomAttribute[]
	 */
	public function GetDefinitions();

	/**
	 * @param $entityId int
	 * @return array|string[]
	 */
	public function GetValues($entityId);
}

class AttributeList implements IEntityAttributeList
{
	/**
	 * @var array|string[]
	 */
	private $labels = array();

	/**
	 * @var array|string[]
	 */
	private $values = array();

	/**
	 * @var array|int[]
	 */
	private $attributeOrder = array();

	/**
	 * @var array|string[]
	 */
	private $initialValues = array();

	/**
	 * @var array|Attribute[]
	 */
	private $initialAttributes = array();

	/**
	 * @var array|Attribute[]
	 */
	private $entityValues = array();

	/**
	 * @var array|CustomAttribute[]
	 */
	private $definitions = array();

	/**
	 * @var array|CustomAttribute[]
	 */
	private $entityDefinitions = array();

	/**
	 * @var array|int[]
	 */
	private $entityAttributes = array();

	public function AddDefinition(CustomAttribute $attribute)
	{
		$this->labels[] = $attribute->Label();
		if ($attribute->UniquePerEntity())
		{
			$this->entityDefinitions[$attribute->EntityId()][$attribute->Id()] = $attribute;
			$this->attributeOrder[$attribute->Id()] = count($this->attributeOrder);
			$this->entityAttributes[$attribute->Id()] = 1;
		}
		else
		{
			$this->definitions[$attribute->Id()] = $attribute;
			$this->attributeOrder[$attribute->Id()] = count($this->attributeOrder);
		}
	}

	/**
	 * @return array|string[]
	 */
	public function GetLabels()
	{
		return $this->labels;
	}

	/**
	 * @return array|CustomAttribute[]
	 */
	public function GetDefinitions()
	{
		return $this->definitions;
	}

	/**
	 * @param $attributeEntityValue AttributeEntityValue
	 */
	public function AddValue($attributeEntityValue)
	{
		$entityId = $attributeEntityValue->EntityId;
		$attributeId = $attributeEntityValue->AttributeId;

		if (!array_key_exists($entityId, $this->values) && ($this->AttributeExists($attributeId) || $this->EntityAttributeExists($attributeId, $entityId) ))
		{
			$this->values[$entityId] = $this->GetInitialValues($entityId);
			$this->entityValues[$entityId] = $this->GetInitialAttributes($entityId);
		}

		if ($this->AttributeExists($attributeId))
		{
			$this->values[$entityId][$this->GetAttributeIndex($attributeId)] = $attributeEntityValue->Value;
			$this->entityValues[$entityId][$this->GetAttributeIndex($attributeId)] = new Attribute($this->definitions[$attributeId], $attributeEntityValue->Value);
		}
		elseif ($this->EntityAttributeExists($attributeId, $entityId))
		{
			$this->values[$entityId][$this->GetAttributeIndex($attributeId)] = $attributeEntityValue->Value;
			$this->entityValues[$entityId][$this->GetAttributeIndex($attributeId)] = new Attribute($this->entityDefinitions[$entityId][$attributeId], $attributeEntityValue->Value);
		}
	}

	/**
	 * @param $entityId int
	 * @return array|string[]
	 */
	public function GetValues($entityId)
	{
		if (array_key_exists($entityId, $this->values))
		{
			return $this->values[$entityId];
		}

		return $this->GetInitialValues($entityId);
	}

	/**
	 * @param $entityId int
	 * @return array|Attribute[]
	 */
	public function GetAttributeValues($entityId)
	{
		if (array_key_exists($entityId, $this->entityValues))
		{
			return $this->entityValues[$entityId];
		}

		return $this->GetInitialAttributes($entityId);
	}

	/**
	 * @return array|string[]
	 */
	private function GetInitialValues($entityId)
	{
		if (empty($this->initialValues))
		{
			foreach ($this->attributeOrder as $id => $i)
			{
				if (!$this->IsEntityAttribute($id) || $this->EntityAttributeExists($id, $entityId))
				{
					$this->initialValues[$i] = null;
				}
			}
		}

		return $this->initialValues;
	}

	/**
	 * @param int $entityId
	 * @return array|Attribute[]
	 */
	private function GetInitialAttributes($entityId)
	{
		if (empty($this->initialAttributes))
		{
			foreach ($this->attributeOrder as $id => $i)
			{
				if ($this->AttributeExists($id))
				{
					$this->initialAttributes[$i] = new Attribute($this->definitions[$id]);
				}
				elseif ($this->EntityAttributeExists($id, $entityId))
				{
					$this->initialAttributes[$i] = new Attribute($this->entityDefinitions[$entityId][$id]);
				}
			}
		}

		return $this->initialAttributes;
	}

	/**
	 * @param $attributeId int
	 * @return bool
	 */
	private function AttributeExists($attributeId)
	{
		return array_key_exists($attributeId, $this->definitions) && !$this->IsEntityAttribute($attributeId);
	}

	/**
	 * @param $attributeId int
	 * @param $entityId int
	 * @return bool
	 */
	private function EntityAttributeExists($attributeId, $entityId)
	{
		return $this->IsEntityAttribute($attributeId) && array_key_exists($entityId,$this->entityDefinitions) && array_key_exists($attributeId, $this->entityDefinitions[$entityId]);
	}

	/**
	 * @param $attributeId int
	 * @return int
	 */
	private function GetAttributeIndex($attributeId)
	{
		return $this->attributeOrder[$attributeId];
	}

	/**
	 * @param $attributeId int
	 * @return bool
	 */
	private function IsEntityAttribute($attributeId)
	{
		return array_key_exists($attributeId, $this->entityAttributes);
	}
}

?>