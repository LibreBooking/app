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

require_once(ROOT_DIR . 'Domain/CustomAttribute.php');

interface IAttributeRepository
{
	/**
	 * @abstract
	 * @param CustomAttribute $attribute
	 * @return int
	 */
	public function Add(CustomAttribute $attribute);

	/**
	 * @abstract
	 * @param $attributeId int
	 * @return CustomAttribute
	 */
	public function LoadById($attributeId);

	/**
	 * @abstract
	 * @param CustomAttribute $attribute
	 */
	public function Update(CustomAttribute $attribute);

	/**
	 * @abstract
	 * @param $attributeId int
	 * @return void
	 */
	public function DeleteById($attributeId);

	/**
	 * @abstract
	 * @param int|CustomAttributeCategory $category
	 * @return array|CustomAttribute[]
	 */
	public function GetByCategory($category);

	/**
	 * @abstract
	 * @param int|CustomAttributeCategory $category
	 * @param array|int[] $entityIds
	 * @return array|AttributeEntityValue[]
	 */
	public function GetEntityValues($category, $entityIds);

}

class AttributeRepository implements IAttributeRepository
{
	public function Add(CustomAttribute $attribute)
	{
		return ServiceLocator::GetDatabase()->ExecuteInsert(
			new AddAttributeCommand($attribute->Label(), $attribute->Type(), $attribute->Category(), $attribute->Regex(), $attribute->Required(), $attribute->PossibleValues(), $attribute->SortOrder()));
	}

	/**
	 * @param int|CustomAttributeCategory $category
	 * @return array|CustomAttribute[]
	 */
	public function GetByCategory($category)
	{
		$reader = ServiceLocator::GetDatabase()->Query(new GetAttributesByCategoryCommand($category));

		$attributes = array();
		while ($row = $reader->GetRow())
		{
			$attributes[] = CustomAttribute::FromRow($row);
		}

		return $attributes;
	}

	/**
	 * @param $attributeId int
	 * @return CustomAttribute
	 */
	public function LoadById($attributeId)
	{
		$reader = ServiceLocator::GetDatabase()->Query(new GetAttributeByIdCommand($attributeId));

		$attribute = null;
		if ($row = $reader->GetRow())
		{
			$attribute = CustomAttribute::FromRow($row);
		}

		return $attribute;
	}

	/**
	 * @param CustomAttribute $attribute
	 */
	public function Update(CustomAttribute $attribute)
	{
		ServiceLocator::GetDatabase()->Execute(
			new UpdateAttributeCommand($attribute->Id(), $attribute->Label(), $attribute->Type(), $attribute->Category(),
				$attribute->Regex(), $attribute->Required(), $attribute->PossibleValues(), $attribute->SortOrder()));
	}

	/**
	 * @param int|CustomAttributeCategory $category
	 * @param array|int[] $entityIds
	 * @return array|AttributeEntityValue[]
	 */
	public function GetEntityValues($category, $entityIds)
	{
		$values = array();

		if (!is_array($entityIds) && !empty($entityIds))
		{
			$entityIds = array($entityIds);
		}

		$reader = ServiceLocator::GetDatabase()->Query(new GetAttributeMultipleValuesCommand($category, $entityIds));

		$attribute = null;
		while ($row = $reader->GetRow())
		{
			$values[] = new AttributeEntityValue(
				$row[ColumnNames::ATTRIBUTE_ID],
				$row[ColumnNames::ATTRIBUTE_ENTITY_ID],
				$row[ColumnNames::ATTRIBUTE_VALUE]);
		}

		return $values;
	}

	/**
	 * @param $attributeId int
	 * @return void
	 */
	public function DeleteById($attributeId)
	{
		ServiceLocator::GetDatabase()->Execute(new DeleteAttributeCommand($attributeId));
		ServiceLocator::GetDatabase()->Execute(new DeleteAttributeValuesCommand($attributeId));
	}
}

?>