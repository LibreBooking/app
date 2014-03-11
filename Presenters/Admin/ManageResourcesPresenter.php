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

require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Graphics/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');

class ManageResourcesActions
{
	const ActionAdd = 'add';
	const ActionChangeAdmin = 'changeAdmin';
	const ActionChangeConfiguration = 'configuration';
	const ActionChangeDescription = 'description';
	const ActionChangeImage = 'image';
	const ActionChangeLocation = 'location';
	const ActionChangeNotes = 'notes';
	const ActionChangeSchedule = 'schedule';
	const ActionRemoveImage = 'removeImage';
	const ActionRename = 'rename';
	const ActionDelete = 'delete';
	const ActionChangeStatus = 'changeStatus';
	const ActionEnableSubscription = 'enableSubscription';
	const ActionDisableSubscription = 'disableSubscription';
	const ActionChangeAttributes = 'changeAttributes';
	const ActionChangeSort = 'changeSort';
	const ActionChangeResourceType = 'changeResourceType';
	const ActionBulkUpdate = 'bulkUpdate';
}

class ManageResourcesPresenter extends ActionPresenter
{
	/**
	 * @var IManageResourcesPage
	 */
	private $page;

	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;

	/**
	 * @var IScheduleRepository
	 */
	private $scheduleRepository;

	/**
	 * @var IImageFactory
	 */
	private $imageFactory;

	/**
	 * @var IGroupViewRepository
	 */
	private $groupRepository;

	/**
	 * @var IAttributeService
	 */
	private $attributeService;

	/**
	 * @var IUserPreferenceRepository
	 */
	private $userPreferenceRepository;

	public function __construct(
		IManageResourcesPage $page,
		IResourceRepository $resourceRepository,
		IScheduleRepository $scheduleRepository,
		IImageFactory $imageFactory,
		IGroupViewRepository $groupRepository,
		IAttributeService $attributeService,
		IUserPreferenceRepository $userPreferenceRepository)
	{
		parent::__construct($page);

		$this->page = $page;
		$this->resourceRepository = $resourceRepository;
		$this->scheduleRepository = $scheduleRepository;
		$this->imageFactory = $imageFactory;
		$this->groupRepository = $groupRepository;
		$this->attributeService = $attributeService;
		$this->userPreferenceRepository = $userPreferenceRepository;

		$this->AddAction(ManageResourcesActions::ActionAdd, 'Add');
		$this->AddAction(ManageResourcesActions::ActionChangeAdmin, 'ChangeAdmin');
		$this->AddAction(ManageResourcesActions::ActionChangeConfiguration, 'ChangeConfiguration');
		$this->AddAction(ManageResourcesActions::ActionChangeDescription, 'ChangeDescription');
		$this->AddAction(ManageResourcesActions::ActionChangeImage, 'ChangeImage');
		$this->AddAction(ManageResourcesActions::ActionChangeLocation, 'ChangeLocation');
		$this->AddAction(ManageResourcesActions::ActionChangeNotes, 'ChangeNotes');
		$this->AddAction(ManageResourcesActions::ActionChangeSchedule, 'ChangeSchedule');
		$this->AddAction(ManageResourcesActions::ActionRemoveImage, 'RemoveImage');
		$this->AddAction(ManageResourcesActions::ActionRename, 'Rename');
		$this->AddAction(ManageResourcesActions::ActionDelete, 'Delete');
		$this->AddAction(ManageResourcesActions::ActionChangeStatus, 'ChangeStatus');
		$this->AddAction(ManageResourcesActions::ActionEnableSubscription, 'EnableSubscription');
		$this->AddAction(ManageResourcesActions::ActionDisableSubscription, 'DisableSubscription');
		$this->AddAction(ManageResourcesActions::ActionChangeAttributes, 'ChangeAttributes');
		$this->AddAction(ManageResourcesActions::ActionChangeSort, 'ChangeSortOrder');
		$this->AddAction(ManageResourcesActions::ActionChangeResourceType, 'ChangeResourceType');
		$this->AddAction(ManageResourcesActions::ActionBulkUpdate, 'BulkUpdate');
	}

	public function PageLoad()
	{
		$resourceAttributes = $this->attributeService->GetByCategory(CustomAttributeCategory::RESOURCE);

		$filterValues = $this->page->GetFilterValues();

		$results = $this->resourceRepository->GetList($this->page->GetPageNumber(), $this->page->GetPageSize(), null, null, $filterValues->AsFilter($resourceAttributes));
		$resources = $results->Results();
		$this->page->BindResources($resources);
		$this->page->BindPageInfo($results->PageInfo());

		$schedules = $this->scheduleRepository->GetAll();
		$scheduleList = array();

		/* @var $schedule Schedule */
		foreach ($schedules as $schedule)
		{
			$scheduleList[$schedule->GetId()] = $schedule->GetName();
		}
		$this->page->BindSchedules($scheduleList);
		$this->page->AllSchedules($schedules);

		$resourceTypes = $this->resourceRepository->GetResourceTypes();
		$resourceTypeList = array();

		/* @var $resourceType ResourceType */
		foreach ($resourceTypes as $resourceType)
		{
			$resourceTypeList[$resourceType->Id()] = $resourceType;
		}
		$this->page->BindResourceTypes($resourceTypeList);

		$statusReasons = $this->resourceRepository->GetStatusReasons();
		$statusReasonList = array();

		foreach ($statusReasons as $reason)
		{
			$statusReasonList[$reason->Id()] = $reason;
		}
		$this->page->BindResourceStatusReasons($statusReasonList);

		$groups = $this->groupRepository->GetGroupsByRole(RoleLevel::RESOURCE_ADMIN);
		$this->page->BindAdminGroups($groups);

		$resourceIds = array();
		foreach ($resources as $resource)
		{
			$resourceIds[] = $resource->GetId();
		}

		$attributeList = $this->attributeService->GetAttributes(CustomAttributeCategory::RESOURCE, $resourceIds);
		$this->page->BindAttributeList($attributeList);


		$this->InitializeFilter($filterValues, $resourceAttributes);
	}

	public function Add()
	{
		$name = $this->page->GetResourceName();
		$scheduleId = $this->page->GetScheduleId();
		$autoAssign = $this->page->GetAutoAssign();
		$resourceAdminGroupId = $this->page->GetAdminGroupId();

		Log::Debug("Adding new resource with name: %s, scheduleId: %s, autoAssign: %s, resourceAdminGroupId %s", $name, $scheduleId, $autoAssign, $resourceAdminGroupId);

		$resource = BookableResource::CreateNew($name, $scheduleId, $autoAssign);
		$resource->SetAdminGroupId($resourceAdminGroupId);
		$this->resourceRepository->Add($resource);
	}

	public function ChangeConfiguration()
	{
		$resourceId = $this->page->GetResourceId();
		$minDuration = $this->page->GetMinimumDuration();
		$maxDuration = $this->page->GetMaximumDuration();
		$allowMultiDay = $this->page->GetAllowMultiday();
		$requiresApproval = $this->page->GetRequiresApproval();
		$autoAssign = $this->page->GetAutoAssign();
		$minNotice = $this->page->GetStartNoticeMinutes();
		$maxNotice = $this->page->GetEndNoticeMinutes();
		$maxParticipants = $this->page->GetMaxParticipants();
		$bufferTime = $this->page->GetBufferTime();

		Log::Debug('Updating resource id %s', $resourceId);

		$resource = $this->resourceRepository->LoadById($resourceId);

		$resource->SetMinLength($minDuration);
		$resource->SetMaxLength($maxDuration);
		$resource->SetAllowMultiday($allowMultiDay);
		$resource->SetRequiresApproval($requiresApproval);
		$resource->SetAutoAssign($autoAssign);
		$resource->SetMinNotice($minNotice);
		$resource->SetMaxNotice($maxNotice);
		$resource->SetMaxParticipants($maxParticipants);
		$resource->SetBufferTime($bufferTime);

		$this->resourceRepository->Update($resource);
	}

	public function Delete()
	{
		$resource = $this->resourceRepository->LoadById($this->page->GetResourceId());
		$this->resourceRepository->Delete($resource);
	}

	public function ChangeDescription()
	{
		$resource = $this->resourceRepository->LoadById($this->page->GetResourceId());

		$resource->SetDescription($this->page->GetDescription());

		$this->resourceRepository->Update($resource);
	}

	public function ChangeNotes()
	{
		$resource = $this->resourceRepository->LoadById($this->page->GetResourceId());

		$resource->SetNotes($this->page->GetNotes());

		$this->resourceRepository->Update($resource);
	}

	public function Rename()
	{
		$resource = $this->resourceRepository->LoadById($this->page->GetResourceId());

		$resource->SetName($this->page->GetResourceName());

		$this->resourceRepository->Update($resource);
	}

	public function ChangeLocation()
	{
		$resource = $this->resourceRepository->LoadById($this->page->GetResourceId());

		$resource->SetLocation($this->page->GetLocation());
		$resource->SetContact($this->page->GetContact());

		$this->resourceRepository->Update($resource);
	}

	public function ChangeImage()
	{
		Log::Debug("Changing resource image for resource id %s", $this->page->GetResourceId());

		$uploadedImage = $this->page->GetUploadedImage();

		if ($uploadedImage->IsError())
		{
			die("Image error: " . $uploadedImage->Error());
		}

		$fileType = strtolower($uploadedImage->Extension());

		$supportedTypes = array('jpeg', 'gif', 'png', 'jpg');

		if (!in_array($fileType, $supportedTypes))
		{
			die("Invalid image type: $fileType");
		}

		$image = $this->imageFactory->Load($uploadedImage->TemporaryName());
		$image->ResizeToWidth(300);

		$fileName = "resource{$this->page->GetResourceId()}.$fileType";
		$imageUploadDirectory = Configuration::Instance()->GetKey(ConfigKeys::IMAGE_UPLOAD_DIRECTORY);

		$path = '';

		if (is_dir($imageUploadDirectory))
		{
			$path = $imageUploadDirectory;
		}
		else if (is_dir(ROOT_DIR . $imageUploadDirectory))
		{
			$path = ROOT_DIR . $imageUploadDirectory ;
		}

		$path = "$path/$fileName";
		Log::Debug("Saving resource image $path");

		$image->Save($path);

		$this->SaveResourceImage($fileName);
	}

	public function RemoveImage()
	{
		$this->SaveResourceImage(null);
	}

	public function ChangeStatus()
	{
		$resourceId = $this->page->GetResourceId();
		$statusId = $this->page->GetStatusId();
		$statusReasonId = $this->page->GetStatusReasonId();
		$statusReason = $this->page->GetNewStatusReason();

		Log::Debug('Changing resource status. ResourceId: %s', $resourceId);

		$resource = $this->resourceRepository->LoadById($resourceId);

		if (empty($statusReasonId) && !empty($statusReason))
		{
			$statusReasonId = $this->resourceRepository->AddStatusReason($statusId, $statusReason);
		}

		$resource->ChangeStatus($statusId, $statusReasonId);
		$this->resourceRepository->Update($resource);
	}

	public function ChangeSchedule()
	{
		$resourceId = $this->page->GetResourceId();
		Log::Debug('Changing schedule for resource %s', $resourceId);

		$resource = $this->resourceRepository->LoadById($resourceId);

		$scheduleId = $this->page->GetScheduleId();
		$resource->SetScheduleId($scheduleId);
		$this->resourceRepository->Update($resource);
	}

	public function ChangeAdmin()
	{
		$resourceId = $this->page->GetResourceId();
		Log::Debug('Changing resource admin for resource %s', $resourceId);

		$resource = $this->resourceRepository->LoadById($resourceId);
		$adminGroupId = $this->page->GetAdminGroupId();
		$resource->SetAdminGroupId($adminGroupId);
		$this->resourceRepository->Update($resource);
	}

	public function EnableSubscription()
	{
		$resourceId = $this->page->GetResourceId();
		Log::Debug('Enable calendar subscription for resource %s', $resourceId);

		$resource = $this->resourceRepository->LoadById($resourceId);
		$resource->EnableSubscription();
		$this->resourceRepository->Update($resource);
	}

	public function DisableSubscription()
	{
		$resourceId = $this->page->GetResourceId();
		Log::Debug('Disable calendar subscription for resource %s', $resourceId);

		$resource = $this->resourceRepository->LoadById($resourceId);
		$resource->DisableSubscription();
		$this->resourceRepository->Update($resource);
	}

	public function ChangeAttributes()
	{
		$resourceId = $this->page->GetResourceId();
		Log::Debug('Changing attributes for resource %s', $resourceId);

		$resource = $this->resourceRepository->LoadById($resourceId);

		$attributes = $this->GetAttributeValues();

		$resource->ChangeAttributes($attributes);
		$this->resourceRepository->Update($resource);
	}

	public function ChangeSortOrder()
	{
		$resourceId = $this->page->GetResourceId();
		$sortOrder = $this->page->GetSortOrder();
		Log::Debug('Changing sort order for resource %s', $resourceId);

		$resource = $this->resourceRepository->LoadById($resourceId);
		$resource->SetSortOrder($sortOrder);
		$this->resourceRepository->Update($resource);
	}

	public function ChangeResourceType()
	{
		$resourceId = $this->page->GetResourceId();
		$resourceTypeId = $this->page->GetResourceTypeId();
		Log::Debug('Changing resource type for resource %s', $resourceId);

		$resource = $this->resourceRepository->LoadById($resourceId);
		$resource->SetResourceTypeId($resourceTypeId);
		$this->resourceRepository->Update($resource);
	}

	private function GetAttributeValues()
	{
		$attributes = array();
		foreach ($this->page->GetAttributes() as $attribute)
		{
			$attributes[] = new AttributeValue($attribute->Id, $attribute->Value);
		}
		return $attributes;
	}

	private function SaveResourceImage($fileName)
	{
		$resource = $this->resourceRepository->LoadById($this->page->GetResourceId());

		$resource->SetImage($fileName);

		$this->resourceRepository->Update($resource);
	}

	/**
	 * @param ResourceFilterValues $filterValues
	 * @param CustomAttribute[] $resourceAttributes
	 */
	public function InitializeFilter($filterValues, $resourceAttributes)
	{
		$filters = $filterValues->Attributes;
		$attributeFilters = array();
		foreach ($resourceAttributes as $attribute)
		{
			$attributeValue = null;
			if (array_key_exists($attribute->Id(), $filters))
			{
				$attributeValue = $filters[$attribute->Id()];
			}
			$attributeFilters[] = new Attribute($attribute, $attributeValue);
		}

		$this->page->BindAttributeFilters($attributeFilters);
		$this->page->SetFilterValues($filterValues);
	}

	public function BulkUpdate()
	{
		$scheduleId = $this->page->GetScheduleId();
		$resourceTypeId = $this->page->GetResourceTypeId();
		$location = $this->page->GetLocation();
		$contact = $this->page->GetContact();
		$description = $this->page->GetDescription();
		$notes = $this->page->GetNotes();
		$adminGroupId = $this->page->GetAdminGroupId();

		$statusId = $this->page->GetStatusId();
		$reasonId = $this->page->GetStatusReasonId();

		// need to figure out difference between empty and unchanged
		$minDuration = $this->page->GetMinimumDuration();
		$minDurationNone = $this->page->GetMinimumDurationNone();
		$maxDuration = $this->page->GetMaximumDuration();
		$maxDurationNone = $this->page->GetMaximumDurationNone();
		$bufferTime = $this->page->GetBufferTime();
		$bufferTimeNone = $this->page->GetBufferTimeNone();
		$minNotice = $this->page->GetStartNoticeMinutes();
		$minNoticeNone = $this->page->GetStartNoticeNone();
		$maxNotice = $this->page->GetEndNoticeMinutes();
		$maxNoticeNone = $this->page->GetEndNoticeNone();
		$allowMultiDay = $this->page->GetAllowMultiday();
		$requiresApproval = $this->page->GetRequiresApproval();
		$autoAssign = $this->page->GetAutoAssign();
		$allowSubscription = $this->page->GetAllowSubscriptions();
		$attributes = $this->page->GetAttributes();

		$resourceIds = $this->page->GetBulkUpdateResourceIds();

		foreach ($resourceIds as $resourceId)
		{
			try
			{
				$resource = $this->resourceRepository->LoadById($resourceId);

				if ($this->ChangingDropDown($scheduleId))
				{
					$resource->SetScheduleId($scheduleId);
				}
				if ($this->ChangingDropDown($resourceTypeId))
				{
					$resource->SetResourceTypeId($resourceTypeId);
				}
				if ($this->ChangingValue($location))
				{
					$resource->SetLocation($location);
				}
				if ($this->ChangingValue($contact))
				{
					$resource->SetContact($contact);
				}
				if ($this->ChangingValue($description))
				{
					$resource->SetDescription($description);
				}
				if ($this->ChangingValue($notes))
				{
					$resource->SetNotes($notes);
				}
				if ($this->ChangingDropDown($adminGroupId))
				{
					$resource->SetAdminGroupId($adminGroupId);
				}
				if ($this->ChangingDropDown($statusId))
				{
					$resource->ChangeStatus($statusId, $reasonId);
				}
				if (!$minDurationNone)
				{
					$resource->SetMinLength($minDuration);
				}
				if (!$maxDurationNone)
				{
					$resource->SetMaxLength($maxDuration);
				}
				if (!$bufferTimeNone)
				{
					$resource->SetBufferTime($bufferTime);
				}
				if (!$minNoticeNone)
				{
					$resource->SetMinNotice($minNotice);
				}
				if (!$maxNoticeNone)
				{
					$resource->SetMaxNotice($maxNotice);
				}
				if ($this->ChangingDropDown($allowMultiDay))
				{
					$resource->SetAllowMultiday($allowMultiDay);
				}
				if ($this->ChangingDropDown($requiresApproval))
				{
					$resource->SetRequiresApproval($requiresApproval);
				}
				if ($this->ChangingDropDown($autoAssign))
				{
					$resource->SetAutoAssign($autoAssign);
				}
				if ($this->ChangingDropDown($allowSubscription))
				{
					if ($allowSubscription)
					{
						$resource->EnableSubscription();
					}
					else
					{
						$resource->DisableSubscription();
					}
				}

				/** @var AttributeValue $attribute */
				foreach ($this->GetAttributeValues() as $attribute)
				{
					if (!empty($attribute->Value))
					{
						$resource->ChangeAttribute($attribute);
					}
				}

				$this->resourceRepository->Update($resource);
			}
			catch(Exception $ex)
			{
				Log::Error('Error bulk updating resource. Id=%s. Error=%s', $resourceId, $ex);
			}
		}
	}

	protected function LoadValidators($action)
	{
		if ($action == ManageResourcesActions::ActionChangeAttributes)
		{
			$attributes = $this->GetAttributeValues();
			$this->page->RegisterValidator('attributeValidator', new AttributeValidator($this->attributeService, CustomAttributeCategory::RESOURCE, $attributes, $this->page->GetResourceId()));
		}
		if ($action == ManageResourcesActions::ActionBulkUpdate)
		{
			$attributes = $this->GetAttributeValues();
			$this->page->RegisterValidator('bulkAttributeValidator', new AttributeValidator($this->attributeService, CustomAttributeCategory::RESOURCE, $attributes, null, true));
		}
	}

	public function ProcessDataRequest($dataRequest)
	{
		if ($dataRequest == 'all')
		{
			$this->page->SetResourcesJson(array_map(array('AdminResourceJson', 'FromBookable'), $this->resourceRepository->GetResourceList()));
		}
	}

	private function ChangingDropDown($value)
	{
		return $value != "-1";
	}

	private function ChangingValue($value)
	{
		return !empty($value);
	}
}

class AdminResourceJson
{
	public $Id;
	public $Name;

	public function __construct($id, $name)
	{
		$this->Id = $id;
		$this->Name = $name;
	}

	public static function FromBookable(BookableResource $resource)
	{
		return new AdminResourceJson($resource->GetId(), $resource->GetName());
	}
}