<?php
/**
 * Copyright 2011-2017 Nick Korbel
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

require_once(ROOT_DIR . 'Domain/namespace.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'lib/Graphics/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Admin/ImageUploadDirectory.php');
require_once(ROOT_DIR . 'lib/Application/Admin/ResourceImportCsv.php');
require_once(ROOT_DIR . 'lib/Application/Admin/CsvImportResult.php');

class ManageResourcesActions
{
    const ActionAdd = 'add';
    const ActionChangeAdmin = 'changeAdmin';
    const ActionChangeDescription = 'description';
    const ActionChangeImage = 'image';
    const ActionChangeLocation = 'location';
    const ActionChangeContact = 'contact';
    const ActionChangeNotes = 'notes';
    const ActionChangeSchedule = 'schedule';
    const ActionRemoveImage = 'removeImage';
    const ActionRename = 'rename';
    const ActionDelete = 'delete';
    const ActionChangeStatus = 'changeStatus';
    const ActionEnableSubscription = 'enableSubscription';
    const ActionDisableSubscription = 'disableSubscription';
    const ActionChangeSort = 'changeSort';
    const ActionChangeResourceType = 'changeResourceType';
    const ActionBulkUpdate = 'bulkUpdate';
    const ActionChangeDuration = 'changeDuration';
    const ActionChangeCapacity = 'changeCapacity';
    const ActionChangeAccess = 'changeAccess';
    const ActionChangeAttribute = 'changeAttribute';
    const ActionAddUserPermission = 'addUserPermission';
    const ActionRemoveUserPermission = 'removeUserPermission';
    const ActionAddGroupPermission = 'addGroupPermission';
    const ActionRemoveGroupPermission = 'removeGroupPermission';
    const ActionChangeResourceGroups = 'changeResourceGroups';
    const ActionChangeColor = 'changeColor';
    const ActionChangeCredits = 'changeCredits';
    const ActionPrintQR = 'printQR';
    const ActionCopyResource = 'actionCopyResource';
    const ImportResources = 'importResources';
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
        $this->AddAction(ManageResourcesActions::ActionChangeDescription, 'ChangeDescription');
        $this->AddAction(ManageResourcesActions::ActionChangeImage, 'ChangeImage');
        $this->AddAction(ManageResourcesActions::ActionChangeLocation, 'ChangeLocation');
        $this->AddAction(ManageResourcesActions::ActionChangeContact, 'ChangeContact');
        $this->AddAction(ManageResourcesActions::ActionChangeNotes, 'ChangeNotes');
        $this->AddAction(ManageResourcesActions::ActionChangeSchedule, 'ChangeSchedule');
        $this->AddAction(ManageResourcesActions::ActionRemoveImage, 'RemoveImage');
        $this->AddAction(ManageResourcesActions::ActionRename, 'Rename');
        $this->AddAction(ManageResourcesActions::ActionDelete, 'Delete');
        $this->AddAction(ManageResourcesActions::ActionChangeStatus, 'ChangeStatus');
        $this->AddAction(ManageResourcesActions::ActionEnableSubscription, 'EnableSubscription');
        $this->AddAction(ManageResourcesActions::ActionDisableSubscription, 'DisableSubscription');
        $this->AddAction(ManageResourcesActions::ActionChangeSort, 'ChangeSortOrder');
        $this->AddAction(ManageResourcesActions::ActionChangeResourceType, 'ChangeResourceType');
        $this->AddAction(ManageResourcesActions::ActionBulkUpdate, 'BulkUpdate');
        $this->AddAction(ManageResourcesActions::ActionChangeDuration, 'ChangeDuration');
        $this->AddAction(ManageResourcesActions::ActionChangeCapacity, 'ChangeCapacity');
        $this->AddAction(ManageResourcesActions::ActionChangeAccess, 'ChangeAccess');
        $this->AddAction(ManageResourcesActions::ActionChangeAttribute, 'ChangeAttribute');
        $this->AddAction(ManageResourcesActions::ActionAddUserPermission, 'AddUserPermission');
        $this->AddAction(ManageResourcesActions::ActionRemoveUserPermission, 'RemoveUserPermission');
        $this->AddAction(ManageResourcesActions::ActionAddGroupPermission, 'AddGroupPermission');
        $this->AddAction(ManageResourcesActions::ActionRemoveGroupPermission, 'RemoveGroupPermission');
        $this->AddAction(ManageResourcesActions::ActionChangeResourceGroups, 'ChangeResourceGroups');
        $this->AddAction(ManageResourcesActions::ActionChangeColor, 'ChangeColor');
        $this->AddAction(ManageResourcesActions::ActionChangeCredits, 'ChangeCredits');
        $this->AddAction(ManageResourcesActions::ActionPrintQR, 'PrintQRCode');
        $this->AddAction(ManageResourcesActions::ActionCopyResource, 'ActionCopyResource');
        $this->AddAction(ManageResourcesActions::ImportResources, 'ImportResource');
    }

    public function PageLoad()
    {
        $resourceAttributes = $this->attributeService->GetByCategory(CustomAttributeCategory::RESOURCE);

        $filterValues = $this->page->GetFilterValues();

        $results = $this->resourceRepository->GetList($this->page->GetPageNumber(), $this->page->GetPageSize(), null, null,
            $filterValues->AsFilter($resourceAttributes));
        $resources = $results->Results();
        $this->page->BindResources($resources);
        $this->page->BindPageInfo($results->PageInfo());

        $schedules = $this->scheduleRepository->GetAll();
        $scheduleList = array();

        /* @var $schedule Schedule */
        foreach ($schedules as $schedule) {
            $scheduleList[$schedule->GetId()] = $schedule->GetName();
        }
        $this->page->BindSchedules($scheduleList);
        $this->page->AllSchedules($schedules);

        $resourceTypes = $this->resourceRepository->GetResourceTypes();
        $resourceTypeList = array();

        /* @var $resourceType ResourceType */
        foreach ($resourceTypes as $resourceType) {
            $resourceTypeList[$resourceType->Id()] = $resourceType;
        }
        $this->page->BindResourceTypes($resourceTypeList);

        $statusReasons = $this->resourceRepository->GetStatusReasons();
        $statusReasonList = array();

        foreach ($statusReasons as $reason) {
            $statusReasonList[$reason->Id()] = $reason;
        }
        $this->page->BindResourceStatusReasons($statusReasonList);

        $groups = $this->groupRepository->GetGroupsByRole(RoleLevel::RESOURCE_ADMIN);
        $this->page->BindAdminGroups($groups);

        $attributeList = $this->attributeService->GetByCategory(CustomAttributeCategory::RESOURCE);
        $this->page->BindAttributeList($attributeList);

        $this->InitializeFilter($filterValues, $resourceAttributes);

        $this->page->BindResourceGroups($this->resourceRepository->GetResourceGroups(null, new ResourceFilterNone()));
    }

    public function Add()
    {
        $name = $this->page->GetResourceName();
        $scheduleId = $this->page->GetScheduleId();
        $autoAssign = $this->page->GetAutoAssign();
        $resourceAdminGroupId = $this->page->GetAdminGroupId();

        Log::Debug("Adding new resource with name: %s, scheduleId: %s, autoAssign: %s, resourceAdminGroupId %s", $name, $scheduleId, $autoAssign,
            $resourceAdminGroupId);

        $resource = BookableResource::CreateNew($name, $scheduleId, $autoAssign);
        $resource->SetAdminGroupId($resourceAdminGroupId);
        $this->resourceRepository->Add($resource);
    }

    public function ChangeDuration()
    {
        $resourceId = $this->page->GetResourceId();
        $minDuration = $this->page->GetMinimumDuration();
        $maxDuration = $this->page->GetMaximumDuration();
        $bufferTime = $this->page->GetBufferTime();
        $allowMultiDay = $this->page->GetAllowMultiday();

        $resource = $this->resourceRepository->LoadById($resourceId);
        $resource->SetMinLength($minDuration);
        $resource->SetMaxLength($maxDuration);
        $resource->SetBufferTime($bufferTime);
        $resource->SetAllowMultiday($allowMultiDay);

        Log::Debug('Updating resource id=%s, minDuration=%s, maxDuration=%s, buffer=%s, allowMultiDay=%s',
            $resourceId, $minDuration, $maxDuration, $bufferTime, $allowMultiDay);

        $this->resourceRepository->Update($resource);

        $this->page->BindUpdatedDuration($resource);
    }

    public function ChangeCapacity()
    {
        $resourceId = $this->page->GetResourceId();
        $maxParticipants = $this->page->GetMaxParticipants();

        $resource = $this->resourceRepository->LoadById($resourceId);
        $resource->SetMaxParticipants($maxParticipants);

        Log::Debug('Updating resource id=%s, maxParticipants=%s',
            $resourceId, $maxParticipants);

        $this->resourceRepository->Update($resource);

        $this->page->BindUpdatedCapacity($resource);
    }

    public function ChangeAccess()
    {
        $resourceId = $this->page->GetResourceId();
        $requiresApproval = $this->page->GetRequiresApproval();
        $autoAssign = $this->page->GetAutoAssign();
        $clearAllPermissions = $this->page->GetAutoAssignClear();
        $minNotice = $this->page->GetStartNoticeMinutes();
        $maxNotice = $this->page->GetEndNoticeMinutes();
        $enableCheckin = $this->page->GetEnableCheckin();
        $autoReleaseMinutes = $this->page->GetAutoReleaseMinutes();

        $resource = $this->resourceRepository->LoadById($resourceId);

        $resource->SetRequiresApproval($requiresApproval);
        $resource->SetAutoAssign($autoAssign);
        $resource->SetClearAllPermissions($clearAllPermissions);
        $resource->SetMinNotice($minNotice);
        $resource->SetMaxNotice($maxNotice);
        $resource->SetCheckin($enableCheckin, $autoReleaseMinutes);

        Log::Debug('Updating resource id=%s, requiresApproval=%s, autoAssign=%s, minNotice=%s, maxNotice=%s',
            $resourceId, $requiresApproval, $autoAssign, $minNotice, $maxNotice);

        $this->resourceRepository->Update($resource);

        $this->page->BindUpdatedAccess($resource);
    }

    public function Delete()
    {
        $resource = $this->resourceRepository->LoadById($this->page->GetResourceId());
        $this->resourceRepository->Delete($resource);
    }

    public function ChangeDescription()
    {
        $resource = $this->resourceRepository->LoadById($this->page->GetResourceId());

        $resource->SetDescription($this->page->GetValue());

        $this->resourceRepository->Update($resource);
    }

    public function ChangeNotes()
    {
        $resource = $this->resourceRepository->LoadById($this->page->GetResourceId());

        $resource->SetNotes($this->page->GetValue());

        $this->resourceRepository->Update($resource);
    }

    public function Rename()
    {
        $resource = $this->resourceRepository->LoadById($this->page->GetResourceId());

        $name = $this->page->GetValue();
        if (!empty($name)) {
            $resource->SetName($name);

            $this->resourceRepository->Update($resource);
        }
    }

    public function ChangeLocation()
    {
        $resource = $this->resourceRepository->LoadById($this->page->GetResourceId());

        $resource->SetLocation($this->page->GetValue());

        $this->resourceRepository->Update($resource);
    }

    public function ChangeContact()
    {
        $resource = $this->resourceRepository->LoadById($this->page->GetResourceId());

        $resource->SetContact($this->page->GetValue());

        $this->resourceRepository->Update($resource);
    }

    public function ChangeImage()
    {
        Log::Debug("Changing resource image for resource id %s", $this->page->GetResourceId());

        $uploadedImage = $this->page->GetUploadedImage();

        if ($uploadedImage == null) {
            return;
        }

        if ($uploadedImage->IsError()) {
            die("Image error: " . $uploadedImage->Error());
        }

        $fileType = strtolower($uploadedImage->Extension());

        $supportedTypes = array('jpeg', 'gif', 'png', 'jpg');

        if (!in_array($fileType, $supportedTypes)) {
            die("Invalid image type: $fileType");
        }

        $imageSize = getimagesize($uploadedImage->TemporaryName());
        $bytesNeeded = $imageSize[0] * $imageSize[1] * 3;
        $memoryLimit = ini_get('memory_limit');
        $currentUsage = memory_get_usage();
        $needed = ($bytesNeeded + $currentUsage) / 1048576;
        $limit = str_replace('M', '', $memoryLimit);

        if ($needed > $limit) {
            echo 'Image too big. Resize to a smaller size or reduce the resolution and try again.';
            Log::Error("Uploaded image for %s is too big. Needed %s limit %s", $this->page->GetResourceId(), $needed, $limit);
            die();
        }

        $image = $this->imageFactory->Load($uploadedImage->TemporaryName());
        $image->ResizeToWidth(300);

        $time = time();
        $fileName = "resource{$this->page->GetResourceId()}{$time}.$fileType";
        $imageUploadDirectory = Configuration::Instance()->GetKey(ConfigKeys::IMAGE_UPLOAD_DIRECTORY);

        $path = '';

        if (is_dir($imageUploadDirectory)) {
            $path = $imageUploadDirectory;
        }
        else {
            if (is_dir(ROOT_DIR . $imageUploadDirectory)) {
                $path = ROOT_DIR . $imageUploadDirectory;
            }
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

        if (empty($statusReasonId) && !empty($statusReason)) {
            $statusReasonId = $this->resourceRepository->AddStatusReason($statusId, $statusReason);
        }

        $resource->ChangeStatus($statusId, $statusReasonId);
        $this->resourceRepository->Update($resource);
    }

    public function ChangeSchedule()
    {
        $scheduleId = $this->page->GetValue();
        if (!empty($scheduleId)) {
            $resourceId = $this->page->GetResourceId();
            Log::Debug('Changing schedule for resource %s', $resourceId);
            $resource = $this->resourceRepository->LoadById($resourceId);

            $resource->SetScheduleId($scheduleId);
            $this->resourceRepository->Update($resource);
        }
    }

    public function ChangeAdmin()
    {
        $resourceId = $this->page->GetResourceId();
        Log::Debug('Changing resource admin for resource %s', $resourceId);

        $resource = $this->resourceRepository->LoadById($resourceId);
        $adminGroupId = $this->page->GetValue();
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

    public function ChangeAttribute()
    {
        $resourceId = $this->page->GetResourceId();

        $resource = $this->resourceRepository->LoadById($resourceId);

        $attributeValue = $this->GetInlineAttributeValue();
        Log::Debug('Changing attributes. ResourceId=%s, AttributeId=%s, Value=%s', $resourceId, $attributeValue->AttributeId, $attributeValue->Value);

        $resource->ChangeAttribute($attributeValue);
        $this->resourceRepository->Update($resource);
    }

    private function GetInlineAttributeValue()
    {
        $value = $this->page->GetValue();
        if (is_array($value)) {
            $value = $value[0];
        }
        $id = str_replace(FormKeys::ATTRIBUTE_PREFIX, '', $this->page->GetName());

        return new AttributeValue($id, $value);
    }

    public function ChangeSortOrder()
    {
        $resourceId = $this->page->GetResourceId();
        $sortOrder = $this->page->GetValue();
        Log::Debug('Changing sort order for resource %s', $resourceId);

        $resource = $this->resourceRepository->LoadById($resourceId);
        $resource->SetSortOrder($sortOrder);
        $this->resourceRepository->Update($resource);
    }

    public function ChangeResourceType()
    {
        $resourceTypeId = $this->page->GetValue();
        $resourceId = $this->page->GetResourceId();
        Log::Debug('Changing resource type for resource %s', $resourceId);
        $resource = $this->resourceRepository->LoadById($resourceId);
        $resource->SetResourceTypeId($resourceTypeId);
        $this->resourceRepository->Update($resource);
    }

    private function GetAttributeValues()
    {
        $attributes = array();
        foreach ($this->page->GetAttributes() as $attribute) {
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
        foreach ($resourceAttributes as $attribute) {
            $attributeValue = null;
            if (array_key_exists($attribute->Id(), $filters)) {
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
        $allowMultiDay = $this->page->GetBulkAllowMultiday();
        $requiresApproval = $this->page->GetBulkRequiresApproval();
        $autoAssign = $this->page->GetBulkAutoAssign();
        $enableCheckin = $this->page->GetBulkEnableCheckin();
        $allowSubscription = $this->page->GetAllowSubscriptions();
        $credits = $this->page->GetCredits();
        $peakCredits = $this->page->GetPeakCredits();
        $maxCapacity = $this->page->GetMaxParticipants();
        $unlimitedCapacity = $this->page->GetMaxParticipantsUnlimited();

        $resourceIds = $this->page->GetBulkUpdateResourceIds();

        $emptyDuration = 'dhm';

        foreach ($resourceIds as $resourceId) {
            try {
                $resource = $this->resourceRepository->LoadById($resourceId);

                if ($this->ChangingDropDown($scheduleId)) {
                    $resource->SetScheduleId($scheduleId);
                }
                if ($this->ChangingDropDown($resourceTypeId)) {
                    $resource->SetResourceTypeId($resourceTypeId);
                }
                if ($this->ChangingValue($location)) {
                    $resource->SetLocation($location);
                }
                if ($this->ChangingValue($contact)) {
                    $resource->SetContact($contact);
                }
                if ($this->ChangingValue($description)) {
                    $resource->SetDescription($description);
                }
                if ($this->ChangingValue($notes)) {
                    $resource->SetNotes($notes);
                }
                if ($this->ChangingDropDown($adminGroupId)) {
                    $resource->SetAdminGroupId($adminGroupId);
                }
                if ($this->ChangingDropDown($statusId)) {
                    $resource->ChangeStatus($statusId, $reasonId);
                }
                if (!$minDurationNone && $minDuration != $emptyDuration) {
                    $resource->SetMinLength($minDuration);
                }
                if (!$maxDurationNone && $maxDuration != $emptyDuration) {
                    $resource->SetMaxLength($maxDuration);
                }
                if (!$bufferTimeNone && $bufferTime != $emptyDuration) {
                    $resource->SetBufferTime($bufferTime);
                }
                if (!$minNoticeNone && $minNotice != $emptyDuration) {
                    $resource->SetMinNotice($minNotice);
                }
                if (!$maxNoticeNone && $maxNotice != $emptyDuration) {
                    $resource->SetMaxNotice($maxNotice);
                }
                if ($this->ChangingDropDown($allowMultiDay)) {
                    $resource->SetAllowMultiday($allowMultiDay);
                }
                if ($this->ChangingDropDown($requiresApproval)) {
                    $resource->SetRequiresApproval($requiresApproval);
                }
                if ($this->ChangingDropDown($autoAssign)) {
                    $resource->SetAutoAssign($autoAssign);
                }
                if ($this->ChangingDropDown($enableCheckin)) {
                    $resource->SetCheckin($enableCheckin, $this->page->GetAutoReleaseMinutes());
                }
                if ($this->ChangingDropDown($allowSubscription)) {
                    if ($allowSubscription) {
                        $resource->EnableSubscription();
                    }
                    else {
                        $resource->DisableSubscription();
                    }
                }
                if (!empty($credits)) {
                    $resource->SetCreditsPerSlot($credits);
                }
                if (!empty($peakCredits)) {
                    $resource->SetPeakCreditsPerSlot($peakCredits);
                }

                if ($unlimitedCapacity) {
                    $resource->SetMaxParticipants(null);
                }
                if (!$unlimitedCapacity && $maxCapacity != '') {
                    $resource->SetMaxParticipants($maxCapacity);
                }

                /** @var AttributeValue $attribute */
                foreach ($this->GetAttributeValues() as $attribute) {
                    if (!empty($attribute->Value)) {
                        $resource->ChangeAttribute($attribute);
                    }
                }

                $this->resourceRepository->Update($resource);
            } catch (Exception $ex) {
                Log::Error('Error bulk updating resource. Id=%s. Error=%s', $resourceId, $ex);
            }
        }
    }

    public function AddUserPermission()
    {
        $userId = $this->page->GetPermissionUserId();
        $resourceId = $this->page->GetResourceId();

        $this->resourceRepository->AddResourceUserPermission($resourceId, $userId);
    }

    public function RemoveUserPermission()
    {
        $userId = $this->page->GetPermissionUserId();
        $resourceId = $this->page->GetResourceId();

        $this->resourceRepository->RemoveResourceUserPermission($resourceId, $userId);
    }

    public function AddGroupPermission()
    {
        $groupId = $this->page->GetPermissionGroupId();
        $resourceId = $this->page->GetResourceId();

        $this->resourceRepository->AddResourceGroupPermission($resourceId, $groupId);
    }

    public function RemoveGroupPermission()
    {
        $groupId = $this->page->GetPermissionGroupId();
        $resourceId = $this->page->GetResourceId();

        $this->resourceRepository->RemoveResourceGroupPermission($resourceId, $groupId);
    }

    public function ChangeResourceGroups()
    {
        $resourceId = $this->page->GetResourceId();
        $resourceGroups = $this->page->GetResourceGroupIds();

        $resource = $this->resourceRepository->LoadById($resourceId);
        $currentGroupIds = $resource->GetResourceGroupIds();

        $diff = new ArrayDiff($currentGroupIds, $resourceGroups);

        foreach ($diff->GetRemovedFromArray1() as $i => $groupId) {
            $this->resourceRepository->RemoveResourceFromGroup($resourceId, $groupId);
        }

        foreach ($diff->GetAddedToArray1() as $i => $groupId) {
            $this->resourceRepository->AddResourceToGroup($resourceId, $groupId);
        }

        $resource->SetResourceGroupIds($resourceGroups);

        $groups = $this->resourceRepository->GetResourceGroups();
        $this->page->BindUpdatedResourceGroups($resource, $groups->GetGroupList(false));
    }

    public function ChangeColor()
    {
        $color = $this->page->GetColor();
        $resource = $this->resourceRepository->LoadById($this->page->GetResourceId());

        $resource->SetColor($color);

        $this->resourceRepository->Update($resource);
    }

    public function ChangeCredits()
    {
        $resourceId = $this->page->GetResourceId();
        $credits = $this->page->GetCredits();
        $peakCredits = $this->page->GetPeakCredits();

        $resource = $this->resourceRepository->LoadById($resourceId);
        $resource->SetCreditsPerSlot($credits);
        $resource->SetPeakCreditsPerSlot($peakCredits);

        $this->resourceRepository->Update($resource);

        $this->page->BindUpdatedResourceCredits($resource);
    }

    public function PrintQRCode()
    {
        $qrGenerator = new QRGenerator();

        $resourceId = $this->page->GetResourceId();

        $imageUploadDir = new ImageUploadDirectory();
        $imageName = "/resourceqr{$resourceId}.png";
        $url = $imageUploadDir->GetPath() . $imageName;
        $savePath = $imageUploadDir->GetDirectory() . $imageName;

        $qrPath = sprintf('%s/%s?%s=%s', Configuration::Instance()->GetScriptUrl(), Pages::RESERVATION, QueryStringKeys::RESOURCE_ID, $resourceId);
        $qrGenerator->SavePng($qrPath, $savePath);
        $resource = $this->resourceRepository->LoadById($resourceId);

        $this->page->ShowQRCode($url, $resource->GetName());
    }

    public function ActionCopyResource()
    {
        $sourceId = $this->page->GetResourceId();
        $name = $this->page->GetResourceName();

        $resource = $this->resourceRepository->LoadById($sourceId);
        $resource->AsCopy($name);
        $this->resourceRepository->Add($resource);
        $this->resourceRepository->Update($resource);

        $resourceId = $resource->GetResourceId();

        foreach ($resource->GetResourceGroupIds() as $groupId) {
            $this->resourceRepository->AddResourceToGroup($resourceId, $groupId);
        }

        $groups = $this->resourceRepository->GetGroupsWithPermission($sourceId);
        foreach ($groups->Results() as $group) {
            $this->resourceRepository->AddResourceGroupPermission($resourceId, $group->Id);
        }
        $users = $this->resourceRepository->GetUsersWithPermission($sourceId);
        foreach ($users->Results() as $user) {
            $this->resourceRepository->AddResourceUserPermission($resourceId, $user->Id);
        }
    }

    public function ImportResource()
    {
        ini_set('max_execution_time', 600);

        $shouldUpdate = $this->page->GetUpdateOnImport();

        $attributes = $this->attributeService->GetByCategory(CustomAttributeCategory::RESOURCE);
        /** @var CustomAttribute[] $attributesIndexed */
        $attributesIndexed = array();
        /** @var CustomAttribute $attribute */
        foreach ($attributes as $attribute) {
            if (!$attribute->UniquePerEntity()) {
                $attributesIndexed[strtolower($attribute->Label())] = $attribute;
            }
        }

        $importFile = $this->page->GetImportFile();
        $csv = new ResourceImportCsv($importFile, $attributesIndexed);

        $importCount = 0;
        $messages = array();

        $rows = $csv->GetRows();

        if (count($rows) == 0) {
            $this->page->SetImportResult(new CsvImportResult(0, array(), 'Empty file or missing header row'));
            return;
        }

        $groups = $this->groupRepository->GetGroupsByRole(RoleLevel::RESOURCE_ADMIN);
        $groupsIndexed = array();
        foreach ($groups as $group) {
            $groupsIndexed[strtolower($group->Name())] = $group->Id();
        }

        $resourceGroups = $this->resourceRepository->GetResourceGroups();
        $resourceGroupsIndexed = array();
        foreach ($resourceGroups->GetGroupList() as $group) {
            $resourceGroupsIndexed[strtolower($group->name)] = $group->id;
        }

        $defaultScheduleId = 0;
        $schedules = $this->scheduleRepository->GetAll();
        $schedulesIndexed = array();
        foreach ($schedules as $schedule) {
            $schedulesIndexed[strtolower($schedule->GetName())] = $schedule->GetId();
            if ($schedule->GetIsDefault()) {
                $defaultScheduleId = $schedule->GetId();
            }
        }

        $resourceTypes = $this->resourceRepository->GetResourceTypes();
        $resourceTypesIndexed = array();
        foreach ($resourceTypes as $resourceType) {
            $resourceTypesIndexed[strtolower($resourceType->Name())] = $resourceType->Id();
        }

        $resourceStatusesIndexed = array('available' => ResourceStatus::AVAILABLE, 'unavailable' => ResourceStatus::UNAVAILABLE, 'hidden' => ResourceStatus::HIDDEN);

        for ($i = 0; $i < count($rows); $i++) {

            $row = $rows[$i];

            try {
                $scheduleId = (empty($row->schedule) || !array_key_exists($row->schedule,
                        $schedulesIndexed)) ? $defaultScheduleId : $schedulesIndexed[$row->schedule];
                $resourceTypeId = (empty($row->resourceType) || !array_key_exists($row->resourceType,
                        $resourceTypesIndexed)) ? null : $resourceTypesIndexed[$row->resourceType];
                $adminGroupId = (empty($row->resourceAdministrator) || !array_key_exists($row->resourceAdministrator,
                        $groupsIndexed)) ? null : $groupsIndexed[$row->resourceAdministrator];
                $statusId = (empty($row->status) || !array_key_exists($row->status,
                        $resourceStatusesIndexed)) ? ResourceStatus::AVAILABLE : $resourceStatusesIndexed[$row->status];
                $autoAssign = $row->autoAssign == 'true' || $row->autoAssign == '1';

                if ($shouldUpdate) {
                    $resource = $this->resourceRepository->LoadByName($row->name);
                    if ($resource->GetId() == null)
                    {
                        $shouldUpdate = false;
                    }
                    else{
                        $resource->SetScheduleId($scheduleId);
                        $resource->SetAutoAssign($autoAssign);
                        $resource->SetSortOrder(intval($row->sortOrder));
                    }
                }

                if (!$shouldUpdate) {
                    $resource = BookableResource::CreateNew($row->name, $scheduleId, $autoAssign, intval($row->sortOrder));
                    $this->resourceRepository->Add($resource);
                }

                $resource->ChangeStatus($statusId);
                $resource->SetResourceTypeId($resourceTypeId);
                $resource->SetLocation($row->location);
                $resource->SetContact($row->contact);
                $resource->SetDescription($row->description);
                $resource->SetNotes($row->notes);
                $resource->SetAdminGroupId($adminGroupId);
                $resource->SetColor($row->color);
                $resource->SetRequiresApproval($row->approvalRequired == 'true' || $row->approvalRequired == '1');
                $resource->SetMaxParticipants($row->capacity);

                foreach ($row->attributes as $label => $value) {
                    if (empty($value)) {
                        continue;
                    }
                    if (array_key_exists($label, $attributesIndexed)) {
                        $attribute = $attributesIndexed[$label];
                        $resource->ChangeAttribute(new AttributeValue($attribute->Id(), $value));
                    }
                }

                $this->resourceRepository->Update($resource);

                foreach ($row->resourceGroups as $groupName) {
                    $groupName = strtolower($groupName);
                    if (array_key_exists($groupName, $resourceGroupsIndexed)) {
                        Log::Debug('Assigning resource %s to group %s', $row->name, $groupName);
                        $this->resourceRepository->AddResourceToGroup($resource->GetId(), $resourceGroupsIndexed[$groupName]);
                    }
                }

                $importCount++;
            } catch (Exception $ex) {
                $messages[] = 'Invalid data in row ' . $i;
                Log::Error('Error importing resources. %s', $ex);
            }
        }

        $this->page->SetImportResult(new CsvImportResult($importCount, $csv->GetSkippedRowNumbers(), $messages));
    }

    public function ExportResources()
    {
        $this->PageLoad();
        $this->page->ShowExportCsv();
    }

    protected function LoadValidators($action)
    {
        if ($action == ManageResourcesActions::ActionChangeAttribute) {
            $attributes = $this->GetInlineAttributeValue();
            $this->page->RegisterValidator('attributeValidator', new AttributeValidatorInline($this->attributeService,
                CustomAttributeCategory::RESOURCE, $attributes,
                $this->page->GetResourceId(), true, true));
        }
        if ($action == ManageResourcesActions::ActionBulkUpdate) {
            $attributes = $this->GetAttributeValues();
            $this->page->RegisterValidator('bulkAttributeValidator',
                new AttributeValidator($this->attributeService, CustomAttributeCategory::RESOURCE, $attributes, null, true, true));
        }

        if ($action == ManageResourcesActions::ImportResources) {
            $this->page->RegisterValidator('fileExtensionValidator', new FileExtensionValidator('csv', $this->page->GetImportFile()));
        }
    }

    public function ProcessDataRequest($dataRequest)
    {
        switch ($dataRequest) {
            case 'all' : {
                $this->page->SetResourcesJson(array_map(array('AdminResourceJson', 'FromBookable'), $this->resourceRepository->GetResourceList()));
                break;
            }
            case 'users' : {
                $users = $this->resourceRepository->GetUsersWithPermission($this->page->GetResourceId());
                $response = new UserResults($users->Results(), $users->PageInfo()->Total);
                $this->page->SetJsonResponse($response);
                break;
            }
            case 'groups': {
                $groups = $this->resourceRepository->GetGroupsWithPermission($this->page->GetResourceId());
                $response = new GroupResults($groups->Results(), $groups->PageInfo()->Total);
                $this->page->SetJsonResponse($response);
                break;
            }
            case 'template' : {
                $attributes = $this->attributeService->GetByCategory(CustomAttributeCategory::RESOURCE);
                $importAttributes = array();
                foreach ($attributes as $attribute) {
                    if (!$attribute->UniquePerEntity()) {
                        $importAttributes[] = $attribute;
                    }
                }
                $this->page->ShowTemplateCSV($importAttributes);
                break;
            }
            case 'export': {
                $this->ExportResources();
            }
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

class UserResults
{
    /**
     * @param UserItemView[] $users
     * @param int $totalUsers
     */
    public function __construct($users, $totalUsers)
    {
        foreach ($users as $user) {
            $this->Users[] = new AutocompleteUser($user->Id, $user->First, $user->Last, $user->Email, $user->Username);
        }
        $this->Total = $totalUsers;
    }

    /**
     * @var int
     */
    public $Total;

    /**
     * @var AutocompleteUser[]
     */
    public $Users;
}

class GroupResults
{
    /**
     * @param GroupItemView[] $groups
     * @param int $totalGroups
     */
    public function __construct($groups, $totalGroups)
    {
        $this->Groups = $groups;
        $this->Total = $totalGroups;
    }

    /**
     * @var int
     */
    public $Total;

    /**
     * @var GroupItemView[]
     */
    public $Groups;
}

class ResourceFilterNone implements IResourceFilter
{

    /**
     * @param IResource $resource
     * @return bool
     */
    function ShouldInclude($resource)
    {
        return false;
    }
}