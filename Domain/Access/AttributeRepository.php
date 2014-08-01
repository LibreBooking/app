<?php
/**
 * Copyright 2012-2014 Nick Korbel
 *
 * This file is part of Booked Scheduler.
 *
 * Booked Scheduler is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Booked Scheduler is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
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
	 * @param array|int[] $entityIds if null is passed, get all entity values
	 * @return array|AttributeEntityValue[]
	 */
	public function GetEntityValues($category, $entityIds = null);

}

class AttributeRepository implements IAttributeRepository
{
	public function __construct()
	{
	}

	public function Add(CustomAttribute $attribute)
	{
		return ServiceLocator::GetDatabase()
			   ->ExecuteInsert(
			new AddAttributeCommand($attribute->Label(), $attribute->Type(), $attribute->Category(), $attribute->Regex(),
									$attribute->Required(), $attribute->PossibleValues(), $attribute->SortOrder(), $attribute->EntityId(), $attribute->AdminOnly(),
									$attribute->SecondaryCategory(), $attribute->SecondaryEntityId(), $attribute->IsPrivate()));
	}

	/**
	 * @param int|CustomAttributeCategory $category
	 * @return array|CustomAttribute[]
	 */
	public function GetByCategory($category)
	{
		if (!DomainCache::Exists($category, 'attr-category'))
		{
			$reader = ServiceLocator::GetDatabase()->Query(new GetAttributesByCategoryCommand($category));

			$attributes = array();
			while ($row = $reader->GetRow())
			{
				$attributes[] = CustomAttribute::FromRow($row);
			}

			DomainCache::Add($category, $attributes, 'attr-category');

		}

		return DomainCache::Get($category, 'attr-category');
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
		ServiceLocator::GetDatabase()
		->Execute(
			new UpdateAttributeCommand($attribute->Id(), $attribute->Label(), $attribute->Type(), $attribute->Category(),
									   $attribute->Regex(), $attribute->Required(), $attribute->PossibleValues(), $attribute->SortOrder(),
									   $attribute->EntityId(), $attribute->AdminOnly(), $attribute->SecondaryCategory(), $attribute->SecondaryEntityId(), $attribute->IsPrivate()));
	}

	/**
	 * @param int|CustomAttributeCategory $category
	 * @param array|int[] $entityIds
	 * @return array|AttributeEntityValue[]
	 */
	public function GetEntityValues($category, $entityIds = null)
	{
		$values = array();

		if (!is_array($entityIds) && !empty($entityIds))
		{
			$entityIds = array($entityIds);
		}

		if (empty($entityIds))
		{
			$reader = ServiceLocator::GetDatabase()
									->Query(new GetAttributeAllValuesCommand($category));
		}
		else
		{
			$reader = ServiceLocator::GetDatabase()
									->Query(new GetAttributeMultipleValuesCommand($category, $entityIds));
		}
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

	public function DeleteById($attributeId)
	{
		ServiceLocator::GetDatabase()
					  ->Execute(new DeleteAttributeCommand($attributeId));
		ServiceLocator::GetDatabase()
					  ->Execute(new DeleteAttributeValuesCommand($attributeId));
	}
}