<?php
/**
 * Copyright 2012-2019 Nick Korbel
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
	/**
	 * @var DomainCache
	 */
	private $cache;

	public function __construct()
	{
		$this->cache = new DomainCache();
	}

	public function Add(CustomAttribute $attribute)
	{
		$id = ServiceLocator::GetDatabase()->ExecuteInsert(
				new AddAttributeCommand($attribute->Label(), $attribute->Type(), $attribute->Category(), $attribute->Regex(),
										$attribute->Required(), $attribute->PossibleValues(), $attribute->SortOrder(),
										$attribute->AdminOnly(), $attribute->SecondaryCategory(), $attribute->SecondaryEntityIds(),
										$attribute->IsPrivate()));

		foreach ($attribute->EntityIds() as $entityId)
		{
			ServiceLocator::GetDatabase()->ExecuteInsert(new AddAttributeEntityCommand($id, $entityId));
		}

		return $id;
	}

	/**
	 * @param int|CustomAttributeCategory $category
	 * @return array|CustomAttribute[]
	 */
	public function GetByCategory($category)
	{
		if (!$this->cache->Exists($category))
		{
			$reader = ServiceLocator::GetDatabase()->Query(new GetAttributesByCategoryCommand($category));

			$attributes = array();
			while ($row = $reader->GetRow())
			{
				$attributes[] = CustomAttribute::FromRow($row);
			}

			$this->cache->Add($category, $attributes);
			$reader->Free();
		}

		return $this->cache->Get($category);
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

		$reader->Free();
		return $attribute;
	}

	/**
	 * @param CustomAttribute $attribute
	 */
	public function Update(CustomAttribute $attribute)
	{
		$db = ServiceLocator::GetDatabase();
		$db->Execute(new UpdateAttributeCommand($attribute->Id(), $attribute->Label(), $attribute->Type(), $attribute->Category(),
												$attribute->Regex(), $attribute->Required(), $attribute->PossibleValues(), $attribute->SortOrder(),
												$attribute->AdminOnly(), $attribute->SecondaryCategory(),
												$attribute->SecondaryEntityIds(), $attribute->IsPrivate()));

		foreach ($attribute->RemovedEntityIds() as $entityId)
		{
			$db->Execute(new RemoveAttributeEntityCommand($attribute->Id(), $entityId));
		}

		foreach ($attribute->AddedEntityIds() as $entityId)
		{
			$db->Execute(new AddAttributeEntityCommand($attribute->Id(), $entityId));
		}
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

		$reader->Free();
		return $values;
	}

	public function DeleteById($attributeId)
	{
		ServiceLocator::GetDatabase()->Execute(new DeleteAttributeCommand($attributeId));
		ServiceLocator::GetDatabase()->Execute(new DeleteAttributeValuesCommand($attributeId));
		ServiceLocator::GetDatabase()->Execute(new DeleteAttributeColorRulesCommand($attributeId));
	}
}