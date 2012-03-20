<?php
/**
Copyright 2011-2012 Nick Korbel

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
    const ActionBringOnline = 'bringOnline';
    const ActionTakeOffline = 'takeOffline';
    const ActionEnableSubscription = 'enableSubscription';
    const ActionDisableSubscription = 'disableSubscription';
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

    public function __construct(
        IManageResourcesPage $page,
        IResourceRepository $resourceRepository,
        IScheduleRepository $scheduleRepository,
        IImageFactory $imageFactory,
        IGroupViewRepository $groupRepository)
    {
        parent::__construct($page);

        $this->page = $page;
        $this->resourceRepository = $resourceRepository;
        $this->scheduleRepository = $scheduleRepository;
        $this->imageFactory = $imageFactory;
        $this->groupRepository = $groupRepository;

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
        $this->AddAction(ManageResourcesActions::ActionTakeOffline, 'TakeOffline');
        $this->AddAction(ManageResourcesActions::ActionBringOnline, 'BringOnline');
        $this->AddAction(ManageResourcesActions::ActionEnableSubscription, 'EnableSubscription');
        $this->AddAction(ManageResourcesActions::ActionDisableSubscription, 'DisableSubscription');
    }

    public function PageLoad()
    {
        $resources = $this->resourceRepository->GetResourceList();
        $this->page->BindResources($resources);

        $schedules = $this->scheduleRepository->GetAll();
        $scheduleList = array();

        /* @var $schedule Schedule */
        foreach ($schedules as $schedule)
        {
            $scheduleList[$schedule->GetId()] = $schedule->GetName();
        }
        $this->page->BindSchedules($scheduleList);

        $groups = $this->groupRepository->GetGroupsByRole(RoleLevel::RESOURCE_ADMIN);
        $this->page->BindAdminGroups($groups);
    }

    /**
     * @internal should only be used for testing
     */
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

    /**
     * @internal should only be used for testing
     */
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

        Log::Debug('Updating resource id %s. MaxNotice: %s', $resourceId, $maxNotice);

        $resource = $this->resourceRepository->LoadById($resourceId);

        $resource->SetMinLength($minDuration);
        $resource->SetMaxLength($maxDuration);
        $resource->SetAllowMultiday($allowMultiDay);
        $resource->SetRequiresApproval($requiresApproval);
        $resource->SetAutoAssign($autoAssign);
        $resource->SetMinNotice($minNotice);
        $resource->SetMaxNotice($maxNotice);
        $resource->SetMaxParticipants($maxParticipants);

        $this->resourceRepository->Update($resource);
    }

    /**
     * @internal should only be used for testing
     */
    public function Delete()
    {
        $resource = $this->resourceRepository->LoadById($this->page->GetResourceId());
        $this->resourceRepository->Delete($resource);
    }

    /**
     * @internal should only be used for testing
     */
    public function ChangeDescription()
    {
        $resource = $this->resourceRepository->LoadById($this->page->GetResourceId());

        $resource->SetDescription($this->page->GetDescription());

        $this->resourceRepository->Update($resource);
    }

    /**
     * @internal should only be used for testing
     */
    public function ChangeNotes()
    {
        $resource = $this->resourceRepository->LoadById($this->page->GetResourceId());

        $resource->SetNotes($this->page->GetNotes());

        $this->resourceRepository->Update($resource);
    }

    /**
     * @internal should only be used for testing
     */
    public function Rename()
    {
        $resource = $this->resourceRepository->LoadById($this->page->GetResourceId());

        $resource->SetName($this->page->GetResourceName());

        $this->resourceRepository->Update($resource);
    }

    /**
     * @internal should only be used for testing
     */
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
        $path = ROOT_DIR . Configuration::Instance()->GetKey(ConfigKeys::IMAGE_UPLOAD_DIRECTORY) . "/$fileName";

        Log::Debug("Saving resource image $path");

        $image->Save($path);

        $this->SaveResourceImage($fileName);
    }

    public function RemoveImage()
    {
        $this->SaveResourceImage(null);
    }

    public function TakeOffline()
    {
        $resource = $this->resourceRepository->LoadById($this->page->GetResourceId());
        $resource->TakeOffline();
        $this->resourceRepository->Update($resource);
    }

    public function BringOnline()
    {
        $resource = $this->resourceRepository->LoadById($this->page->GetResourceId());
        $resource->BringOnline();
        $this->resourceRepository->Update($resource);
    }

    public function ChangeSchedule()
    {
        $resource = $this->resourceRepository->LoadById($this->page->GetResourceId());
        $scheduleId = $this->page->GetScheduleId();
        $resource->SetScheduleId($scheduleId);
        $this->resourceRepository->Update($resource);
    }

    public function ChangeAdmin()
    {
        $resource = $this->resourceRepository->LoadById($this->page->GetResourceId());
        $adminGroupId = $this->page->GetAdminGroupId();
        $resource->SetAdminGroupId($adminGroupId);
        $this->resourceRepository->Update($resource);
    }

    public function EnableSubscription()
    {
        $resource = $this->resourceRepository->LoadById($this->page->GetResourceId());
        $resource->EnableSubscription();
        $this->resourceRepository->Update($resource);
    }

    public function DisableSubscription()
    {
        $resource = $this->resourceRepository->LoadById($this->page->GetResourceId());
        $resource->DisableSubscription();
        $this->resourceRepository->Update($resource);
    }

    private function SaveResourceImage($fileName)
    {
        $resource = $this->resourceRepository->LoadById($this->page->GetResourceId());

        $resource->SetImage($fileName);

        $this->resourceRepository->Update($resource);
    }
}

?>