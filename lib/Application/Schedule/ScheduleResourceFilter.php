<?php
/**
Copyright 2013-2015 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

interface IScheduleResourceFilter
{
	/**
	 * @param BookableResource[] $resources
	 * @param IResourceRepository $resourceRepository
	 * @param IAttributeService $attributeService
	 * @return int[] filtered resource ids
	 */
	public function FilterResources($resources, IResourceRepository $resourceRepository,
									IAttributeService $attributeService);
}

class ScheduleResourceFilter implements IScheduleResourceFilter
{
	public $ScheduleId;
	public $ResourceId;
	public $GroupId;
	public $ResourceTypeId;
	public $MinCapacity;
	public $ResourceAttributes;
	public $ResourceTypeAttributes;

	/**
	 * @param int|null $scheduleId
	 * @param int|null $resourceTypeId
	 * @param int|null $minCapacity
	 * @param AttributeValue[]|null $resourceAttributes
	 * @param AttributeValue[]|null $resourceTypeAttributes
	 */
	public function __construct($scheduleId = null,
								$resourceTypeId = null,
								$minCapacity = null,
								$resourceAttributes = null,
								$resourceTypeAttributes = null)
	{
		$this->ScheduleId = $scheduleId;
		$this->ResourceTypeId = $resourceTypeId;
		$this->MinCapacity = empty($minCapacity) ? null : $minCapacity;
		$this->ResourceAttributes = empty($resourceAttributes) ? array() : $resourceAttributes;
		$this->ResourceTypeAttributes = empty($resourceTypeAttributes) ? array() : $resourceTypeAttributes;
	}

	public static function FromCookie($val)
	{
		if (empty($val))
		{
			return new ScheduleResourceFilter();
		}
		return new ScheduleResourceFilter($val->ScheduleId, $val->ResourceTypeId, $val->MinCapacity, $val->ResourceAttributes, $val->ResourceTypeAttributes);
	}

	private function HasFilter()
	{
		return !empty($this->ResourceId) || !empty($this->GroupId) || !empty($this->ResourceTypeId) || !empty($this->MinCapacity) || !empty($this->ResourceAttributes) || !empty($this->ResourceTypeAttributes);
	}

	public function FilterResources($resources, IResourceRepository $resourceRepository,
									IAttributeService $attributeService)
	{
		$resourceIds = array();

		if (!$this->HasFilter())
		{
			foreach ($resources as $resource)
			{
				$resourceIds[] = $resource->GetId();
			}

			return $resourceIds;
		}

		$groupResourceIds = array();
		if (!empty($this->GroupId) && empty($this->ResourceId))
		{
			$groups = $resourceRepository->GetResourceGroups($this->ScheduleId);
			$groupResourceIds = $groups->GetResourceIds($this->GroupId);
		}

		$resourceAttributeValues = null;
		if (!empty($this->ResourceAttributes))
		{
			$resourceAttributeValues = $attributeService->GetAttributes(CustomAttributeCategory::RESOURCE, null);
		}

		$resourceTypeAttributeValues = null;
		if (!empty($this->ResourceTypeAttributes))
		{
			$resourceTypeAttributeValues = $attributeService->GetAttributes(CustomAttributeCategory::RESOURCE_TYPE,
																			null);
		}

		$resourceIds = array();

		foreach ($resources as $resource)
		{
			$resourceIds[] = $resource->GetId();

			if (!empty($this->ResourceId) && $resource->GetId() != $this->ResourceId)
			{
				array_pop($resourceIds);
				continue;
			}

			if (!empty($this->GroupId) && !in_array($resource->GetId(), $groupResourceIds))
			{
				array_pop($resourceIds);
				continue;
			}

			if (!empty($this->MinCapacity) && $resource->GetMaxParticipants() < $this->MinCapacity)
			{
				array_pop($resourceIds);
				continue;
			}

			if (!empty($this->ResourceTypeId) && $resource->GetResourceTypeId() != $this->ResourceTypeId)
			{
				array_pop($resourceIds);
				continue;
			}

			$resourceAttributesPass = true;
			if (!empty($this->ResourceAttributes))
			{
				$values = $resourceAttributeValues->GetAttributes($resource->GetId());

				/** var @attribute AttributeValue */
				foreach ($this->ResourceAttributes as $attribute)
				{
					$value = $this->GetAttribute($values, $attribute->AttributeId);
					if (!$this->AttributeValueMatches($attribute, $value))
					{
						$resourceAttributesPass = false;
						break;
					}
				}
			}

			if (!$resourceAttributesPass)
			{
				array_pop($resourceIds);
				continue;
			}

			$resourceTypeAttributesPass = true;

			if (!empty($this->ResourceTypeAttributes))
			{
				if (!$resource->HasResourceType())
				{
					array_pop($resourceIds);
					// there's a filter but this resource doesn't have a resource type
					continue;
				}
				$values = $resourceTypeAttributeValues->GetAttributes($resource->GetResourceTypeId());

				/** var @attribute AttributeValue */
				foreach ($this->ResourceTypeAttributes as $attribute)
				{
					$value = $this->GetAttribute($values, $attribute->AttributeId);
					if (!$this->AttributeValueMatches($attribute, $value))
					{
						$resourceTypeAttributesPass = false;
						break;
					}
				}
			}

			if (!$resourceTypeAttributesPass)
			{
				array_pop($resourceIds);
				continue;
			}

		}

		return $resourceIds;
	}

	/**
	 * @param Attribute[] $attributes
	 * @param int $attributeId
	 * @return null|Attribute
	 */
	private function GetAttribute($attributes, $attributeId)
	{
		foreach ($attributes as $attribute)
		{
			if ($attribute->Id() == $attributeId)
			{
				return $attribute;
			}
		}
		return null;
	}

	/**
	 * @param AttributeValue $attribute
	 * @param Attribute $value
	 * @return bool
	 */
	private function AttributeValueMatches($attribute, $value)
	{
		if ($value == null)
		{
			return false;
		}

		if ($value->Type() == CustomAttributeTypes::SINGLE_LINE_TEXTBOX || $value->Type() == CustomAttributeTypes::MULTI_LINE_TEXTBOX)
		{
			return strripos($value->Value(), $attribute->Value) !== false;
		}
		else
		{
			return $value->Value() == $attribute->Value;
		}
	}
}

?>