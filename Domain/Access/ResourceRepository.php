<?php
/**
Copyright 2011-2014 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
 */

require_once(ROOT_DIR . 'Domain/BookableResource.php');
require_once(ROOT_DIR . 'Domain/ResourceGroup.php');
require_once(ROOT_DIR . 'Domain/ResourceType.php');
require_once(ROOT_DIR . 'Domain/Access/IResourceRepository.php');
require_once(ROOT_DIR . 'Domain/Values/ResourceStatus.php');

class ResourceRepository implements IResourceRepository
{
	/**
	 * @var DomainCache
	 */
	private $_cache;

	const ALL_SCHEDULES = -1;

	public function __construct()
	{
		$this->_cache = new DomainCache();
	}

	/**
	 * @param int $scheduleId
	 * @return array|BookableResource[]
	 */
	public function GetScheduleResources($scheduleId)
	{
		$command = new GetScheduleResourcesCommand($scheduleId);

		$resources = array();

		$reader = ServiceLocator::GetDatabase()
				  ->Query($command);

		while ($row = $reader->GetRow())
		{
			$resources[] = BookableResource::Create($row);
		}

		$reader->Free();

		return $resources;
	}

	public function GetResourceList()
	{
		$resources = array();
		$reader = ServiceLocator::GetDatabase()
				  ->Query(new GetAllResourcesCommand());

		while ($row = $reader->GetRow())
		{
			$resources[] = BookableResource::Create($row);
		}

		$reader->Free();

		return $resources;
	}

	public function GetResourceGroupsList()
	{
		$reader = ServiceLocator::GetDatabase()
				  ->Query(new GetAllResourceGroupsCommand());

		$groups = array();
		while ($row = $reader->GetRow())
		{
			$groups[] = new ResourceGroup($row[ColumnNames::RESOURCE_GROUP_ID],
										  $row[ColumnNames::RESOURCE_GROUP_NAME],
										  $row[ColumnNames::RESOURCE_GROUP_PARENT_ID]);
		}

		$reader->Free();

		return $groups;
	}

	/**
	 * @param int $resourceId
	 * @return BookableResource
	 */
	public function LoadById($resourceId)
	{
		if (!$this->_cache->Exists($resourceId))
		{
			$resource = $this->LoadResource(new GetResourceByIdCommand($resourceId));

			$this->_cache->Add($resourceId, $resource);
		}

		return $this->_cache->Get($resourceId);
	}

	public function LoadByContactInfo($contact_info)
	{
		return $this->LoadResource(new GetResourceByContactInfoCommand($contact_info));
	}

	/**
	 * @param string $publicId
	 * @return BookableResource
	 */
	public function LoadByPublicId($publicId)
	{
		return $this->LoadResource(new GetResourceByPublicIdCommand($publicId));
	}

	/**
	 * @param $command SqlCommand
	 * @return BookableResource
	 */
	private function LoadResource($command)
	{
		$reader = ServiceLocator::GetDatabase()->Query($command);

		$resource = BookableResource::Null();
		if ($row = $reader->GetRow())
		{
			$resource = BookableResource::Create($row);

			$getAttributes = new GetAttributeValuesCommand($resource->GetId(), CustomAttributeCategory::RESOURCE);
			$attributeReader = ServiceLocator::GetDatabase()
							   ->Query($getAttributes);

			while ($attributeRow = $attributeReader->GetRow())
			{
				$resource->WithAttribute(new AttributeValue($attributeRow[ColumnNames::ATTRIBUTE_ID], $attributeRow[ColumnNames::ATTRIBUTE_VALUE]));
			}

			$attributeReader->Free();
		}

		$reader->Free();

		return $resource;
	}

	public function Add(BookableResource $resource)
	{
		$db = ServiceLocator::GetDatabase();
		$addResourceCommand = new AddResourceCommand(
			$resource->GetName(),
			$resource->GetScheduleId(),
			$resource->GetAutoAssign(),
			$resource->GetAdminGroupId());

		$resourceId = $db->ExecuteInsert($addResourceCommand);
		if ($resource->GetAutoAssign())
		{
			$db->Execute(new AutoAssignResourcePermissionsCommand($resourceId));
		}

		$resource->SetResourceId($resourceId);
		return $resourceId;
	}

	public function Update(BookableResource $resource)
	{
		$db = ServiceLocator::GetDatabase();

		$updateResourceCommand = new UpdateResourceCommand(
			$resource->GetResourceId(),
			$resource->GetName(),
			$resource->GetLocation(),
			$resource->GetContact(),
			$resource->GetNotes(),
			$resource->GetMinLength(),
			$resource->GetMaxLength(),
			$resource->GetAutoAssign(),
			$resource->GetRequiresApproval(),
			$resource->GetAllowMultiday(),
			$resource->GetMaxParticipants(),
			$resource->GetMinNotice(),
			$resource->GetMaxNotice(),
			$resource->GetDescription(),
			$resource->GetImage(),
			$resource->GetScheduleId(),
			$resource->GetAdminGroupId(),
			$resource->GetIsCalendarSubscriptionAllowed(),
			$resource->GetPublicId(),
			$resource->GetSortOrder(),
			$resource->GetResourceTypeId(),
			$resource->GetStatusId(),
			$resource->GetStatusReasonId(),
			$resource->GetBufferTime()
		);

		$db->Execute($updateResourceCommand);


		foreach ($resource->GetRemovedAttributes() as $removed)
		{
			$db->Execute(new RemoveAttributeValueCommand($removed->AttributeId, $resource->GetId()));
		}

		foreach ($resource->GetAddedAttributes() as $added)
		{
			$db->Execute(new AddAttributeValueCommand($added->AttributeId, $added->Value, $resource->GetId(), CustomAttributeCategory::RESOURCE));
		}

		if ($resource->WasAutoAssignToggledOn())
		{
			$db->Execute(new AutoAssignResourcePermissionsCommand($resource->GetId()));
		}
	}

	public function Delete(BookableResource $resource)
	{
		Log::Debug("Deleting resource %s (%s)", $resource->GetResourceId(), $resource->GetName());

		$resourceId = $resource->GetResourceId();

		$db = ServiceLocator::GetDatabase();
		$db->Execute(new DeleteResourceReservationsCommand($resourceId));
		$db->Execute(new DeleteResourceCommand($resourceId));
	}

	public function GetAccessoryList()
	{
		$command = new GetAllAccessoriesCommand();
		$accessories = array();

		$reader = ServiceLocator::GetDatabase()
				  ->Query($command);

		while ($row = $reader->GetRow())
		{
			$accessories[] = AccessoryDto::Create($row);
		}

		$reader->Free();

		return $accessories;
	}

	public function GetResourceGroups($scheduleId = ResourceRepository::ALL_SCHEDULES, $resourceFilter = null)
	{
		$groups = ServiceLocator::GetDatabase()
				  ->Query(new GetAllResourceGroupsCommand());
		$resources = ServiceLocator::GetDatabase()
					 ->Query(new GetAllResourceGroupAssignmentsCommand($scheduleId));

		$_groups = array();
		$_assignments = array();

		/** @var BookableResource[] $resourceList */
		$resourceList = array();

		$_groups[] = new ResourceGroup(0, Resources::GetInstance()->GetString('All'));
		foreach ($this->GetScheduleResources($scheduleId) as $r)
		{
				$resourceList[$r->GetId()] = $r;
				$_assignments[] = new ResourceGroupAssignment(0, $r);
		}
		
		while ($row = $groups->GetRow())
		{
			$_groups[] = new ResourceGroup($row[ColumnNames::RESOURCE_GROUP_ID],
										   $row[ColumnNames::RESOURCE_GROUP_NAME],
										   $row[ColumnNames::RESOURCE_GROUP_PARENT_ID]);
		}

		while ($row = $resources->GetRow())
		{
			$resourceId = $row[ColumnNames::RESOURCE_ID];
			if (array_key_exists($resourceId, $resourceList))
			{
				$r = $resourceList[$resourceId];
				$_assignments[] = new ResourceGroupAssignment($row[ColumnNames::RESOURCE_GROUP_ID], $r);
			}
		}

		return $this->BuildResourceGroupTree($_groups, $_assignments, $resourceFilter);
	}

	/**
	 * @param $groups ResourceGroup[]
	 * @param $assignments ResourceGroupAssignment[]
	 * @param $resourceFilter IResourceFilter|null
	 * @return ResourceGroupTree
	 */
	private function BuildResourceGroupTree($groups, $assignments, $resourceFilter)
	{
		$tree = new ResourceGroupTree();

		foreach ($groups as $g)
		{
			$tree->AddGroup($g);
		}

		foreach ($assignments as $assignment)
		{
			if ($resourceFilter == null || $resourceFilter->ShouldInclude($assignment))
			{
				$tree->AddAssignment($assignment);
			}
		}

		return $tree;
	}

	public function AddResourceToGroup($resourceId, $groupId)
	{
		ServiceLocator::GetDatabase()
		->Execute(new AddResourceToGroupCommand($resourceId, $groupId));
	}

	public function RemoveResourceFromGroup($resourceId, $groupId)
	{
		ServiceLocator::GetDatabase()
		->Execute(new RemoveResourceFromGroupCommand($resourceId, $groupId));
	}

	public function AddResourceGroup(ResourceGroup $group)
	{
		$id = ServiceLocator::GetDatabase()
			  ->ExecuteInsert(new AddResourceGroupCommand($group->name, $group->parent_id));

		$group->WithId($id);

		return $group;
	}

	public function LoadResourceGroup($groupId)
	{
		$rows = ServiceLocator::GetDatabase()
				->Query(new GetResourceGroupCommand($groupId));

		if ($row = $rows->GetRow())
		{
			return new ResourceGroup($row[ColumnNames::RESOURCE_GROUP_ID], $row[ColumnNames::RESOURCE_GROUP_NAME], $row[ColumnNames::RESOURCE_GROUP_PARENT_ID]);
		}

		return null;
	}

	public function UpdateResourceGroup(ResourceGroup $group)
	{
		ServiceLocator::GetDatabase()
		->Execute(new UpdateResourceGroupCommand($group->id, $group->name, $group->parent_id));
	}

	public function DeleteResourceGroup($groupId)
	{
		ServiceLocator::GetDatabase()
		->Execute(new DeleteResourceGroupCommand($groupId));
	}

	public function GetResourceTypes()
	{
		$types = array();

		$reader = ServiceLocator::GetDatabase()
				  ->Query(new GetAllResourceTypesCommand());

		while ($row = $reader->GetRow())
		{
			$types[] = new ResourceType($row[ColumnNames::RESOURCE_TYPE_ID], $row[ColumnNames::RESOURCE_TYPE_NAME], $row[ColumnNames::RESOURCE_TYPE_DESCRIPTION]);
		}

		$reader->Free();

		return $types;
	}

	public function LoadResourceType($resourceTypeId)
	{
		$resourceType = null;
		$reader = ServiceLocator::GetDatabase()
				  ->Query(new GetResourceTypeCommand($resourceTypeId));
		if ($row = $reader->GetRow())
		{
			$resourceType = new ResourceType($row[ColumnNames::RESOURCE_TYPE_ID], $row[ColumnNames::RESOURCE_TYPE_NAME], $row[ColumnNames::RESOURCE_TYPE_DESCRIPTION]);

			$getAttributes = new GetAttributeValuesCommand($resourceTypeId, CustomAttributeCategory::RESOURCE_TYPE);
			$attributeReader = ServiceLocator::GetDatabase()
							   ->Query($getAttributes);

			while ($attributeRow = $attributeReader->GetRow())
			{
				$resourceType->WithAttribute(new AttributeValue($attributeRow[ColumnNames::ATTRIBUTE_ID], $attributeRow[ColumnNames::ATTRIBUTE_VALUE]));
			}

			$attributeReader->Free();
		}

		$reader->Free();
		return $resourceType;
	}

	public function AddResourceType(ResourceType $type)
	{
		return ServiceLocator::GetDatabase()
			   ->ExecuteInsert(new AddResourceTypeCommand($type->Name(), $type->Description()));
	}

	public function UpdateResourceType(ResourceType $type)
	{
		$db = ServiceLocator::GetDatabase();
		$db->Execute(new UpdateResourceTypeCommand($type->Id(), $type->Name(), $type->Description()));

		foreach ($type->GetRemovedAttributes() as $removed)
		{
			$db->Execute(new RemoveAttributeValueCommand($removed->AttributeId, $type->Id()));
		}

		foreach ($type->GetAddedAttributes() as $added)
		{
			$db->Execute(new AddAttributeValueCommand($added->AttributeId, $added->Value, $type->Id(), CustomAttributeCategory::RESOURCE_TYPE));
		}
	}

	public function RemoveResourceType($id)
	{
		ServiceLocator::GetDatabase()
		->Execute(new DeleteResourceTypeCommand($id));
	}

	public function GetStatusReasons()
	{
		$reasons = array();

		$reader = ServiceLocator::GetDatabase()->Query(new GetAllResourceStatusReasonsCommand());

		while ($row = $reader->GetRow())
		{
			$reasons[] = new ResourceStatusReason($row[ColumnNames::RESOURCE_STATUS_REASON_ID], $row[ColumnNames::RESOURCE_STATUS_ID], $row[ColumnNames::RESOURCE_STATUS_DESCRIPTION]);
		}

		$reader->Free();

		return $reasons;
	}

	public function AddStatusReason($statusId, $reasonDescription)
	{
		return ServiceLocator::GetDatabase()->ExecuteInsert(new AddResourceStatusReasonCommand($statusId, $reasonDescription));
	}


	public function UpdateStatusReason($reasonId, $reasonDescription)
	{
		ServiceLocator::GetDatabase()->Execute(new UpdateResourceStatusReasonCommand($reasonId, $reasonDescription));
	}

	public function RemoveStatusReason($reasonId)
	{
		ServiceLocator::GetDatabase()->Execute(new DeleteResourceStatusReasonCommand($reasonId));
	}
}

class AccessoryDto
{
	/**
	 * @var int
	 */
	public $Id;

	/**
	 * @var string
	 */
	public $Name;

	/**
	 * @var int
	 */
	public $QuantityAvailable;

	public function __construct($id, $name, $quantityAvailable)
	{
		$this->Id = $id;
		$this->Name = $name;
		$this->QuantityAvailable = $quantityAvailable;
	}

	public static function Create($row)
	{
		return new AccessoryDto($row[ColumnNames::ACCESSORY_ID], $row[ColumnNames::ACCESSORY_NAME], $row[ColumnNames::ACCESSORY_QUANTITY]);
	}
}

interface IResourceFilter
{
	/**
	 * @param IResource $resource
	 * @return bool
	 */
	function ShouldInclude($resource);
}
