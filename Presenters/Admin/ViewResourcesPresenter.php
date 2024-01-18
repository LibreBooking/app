<?php

class ViewResourcesPresenter{
    
    /**
     * @var ResourceViewerViewResourcesPage;
     */
    private $page;

    /**
     * @var IResourceRepository;
     */
    private $resourceRepo;

    /**
     * @var IScheduleRepository;
     */
    private $scheduleRepo;

    /**
     * @var IGroupRepository;
     */
    private $groupRepo;

    /**
    * @var IAttributeService
    */
    private $attributeService;

    /**
     * @var int;
     */
    private $userId;

    public function __construct(
        ResourceViewerViewResourcesPage $page,
        IResourceRepository $resourceRepo,
        IScheduleRepository $scheduleRepo,
        IGroupRepository $groupRepo,
        IAttributeService $attributeService,
        )
    {
    
       $this->page = $page;
       $this->resourceRepo = $resourceRepo;
       $this->scheduleRepo = $scheduleRepo;
       $this->groupRepo = $groupRepo;
       $this->attributeService = $attributeService;

       $this->userId = ServiceLocator::GetServer()->GetUserSession()->UserId;

       $this->page->PageLoad;
    }

    public function PageLoad(){
        $resources = $this->GetUserResources();

        $this->page->SetResources($resources);

        $this->page->SetScheduleNames($this->GetSchedulesNames());
        $this->page->SetResourceAdminGroupNames($this->GetResourceAdminGroupNames());
        $this->page->SetResourceGroups($this->GetResourceGroupNames());
        $this->page->SetResourceStatusReasons($this->GetResourceStatusReasons());
        $this->page->SetResourceTypes($this->GetResourceTypes());
        $this->page->SetResourcePermissionTypes($this->GetUserResourcePermissionTypes());

        $resourceAttributes = $this->attributeService->GetByCategory(CustomAttributeCategory::RESOURCE);

        $filterValues = $this->page->GetFilterValues();

        foreach($resources as $resource){
            $resourceIds[] = $resource->GetId();
        }

        $results = $this->resourceRepo->GetUserList(
            $resourceIds,
            $this->page->GetPageNumber(),
            $this->page->GetPageSize(),
            null,
            null,
            $filterValues->AsFilter($resourceAttributes)
        );
        $resources = $results->Results();

        $this->page->SetResources($resources);
        $this->page->BindPageInfo($results->PageInfo());
        
        //$this->InitializeFilter($filterValues, $resourceAttributes);
    }

    private function GetUserResources(){
        $resources = [];

        $resourceIds = [];

        $resourceIds = $this->resourceRepo->GetUserResourcePermissions($this->userId);

        $resourceIds = $this->resourceRepo->GetUserGroupResourcePermissions($this->userId,$resourceIds);

        foreach($resourceIds as $resourceId){
            $resource = $this->resourceRepo->LoadById($resourceId);
            if($resource->GetStatusId() != 0){
                $resources[$resourceId] = $resource;
            }
        }

        return $resources;
    }

    private function GetSchedulesNames(){
        $scheduleNames = [];
        $schedules = $this->scheduleRepo->GetAll();
        foreach($schedules as $schedule){
            $scheduleNames[$schedule->GetId()] = $schedule;
        }

        return $scheduleNames;
    }

    private function GetResourceAdminGroupNames(){
        $resourceAdminGroupNames = [];

        $resourceAdminGroups = $this->groupRepo->GetGroupsByRole(3); //RESOURCE ADMINS

        foreach($resourceAdminGroups as $resourceAdminGroup){
            $resourceAdminGroupNames[$resourceAdminGroup->Id] = $resourceAdminGroup;
        }

        return $resourceAdminGroupNames;    
    }

    private function GetResourceGroupNames(){
        $resourceGroupNames = [];
        
        $resourceGroups = $this->resourceRepo->GetResourceGroupsList();

        foreach($resourceGroups as $resourceGroup){
            $resourceGroupNames[$resourceGroup->id] = $resourceGroup;
        }

        return $resourceGroupNames;    
    }

    private function GetResourceStatusReasons(){
        $resourceStatusReasons = [];

        $resourceStatusReasonsList = $this->resourceRepo->GetStatusReasons();

        foreach($resourceStatusReasonsList as $resourceStatusReason){
            $resourceStatusReasons[$resourceStatusReason->Id()] = $resourceStatusReason;
        }

        return $resourceStatusReasons;  
    }

    private function GetResourceTypes(){
        $resourceTypes = [];

        $resourceTypesList = $this->resourceRepo->GetResourceTypes();

        foreach($resourceTypesList as $resourceType){
            $resourceTypes[$resourceType->Id()]  = $resourceType;
        }

        return $resourceTypes;
    }

    //To show user what type of permission he has to the resource (view only or full access)
    private function GetUserResourcePermissionTypes(){
        //USER
        $resourcePermissionTypes = [];

        $command = new GetUserPermissionsCommand($this->userId);
        $reader = ServiceLocator::GetDatabase()->Query($command);
        
        while ($row = $reader->GetRow()) {
                $resourcePermissionTypes[$row[ColumnNames::RESOURCE_ID]] = $row[ColumnNames::PERMISSION_TYPE];
                $resourcePermissionTypes[$row[ColumnNames::RESOURCE_ID]] = $row[ColumnNames::PERMISSION_TYPE];
        }
            
        $reader->Free();

        //USER GROUPS
        $command = new SelectUserGroupPermissions($this->userId);
        $reader = ServiceLocator::GetDatabase()->Query($command);

        while ($row = $reader->GetRow()) {
            $resourceId = $row[ColumnNames::RESOURCE_ID];
            $permissionType = $row[ColumnNames::PERMISSION_TYPE];

            if (!array_key_exists($resourceId,$resourcePermissionTypes)){
                $resourceId = $permissionType;
            }
            else if (array_key_exists($resourceId,$resourcePermissionTypes) && $resourcePermissionTypes[$resourceId] == 1 &&  $permissionType == 0){
                $resourcePermissionTypes[$resourceId] = $permissionType;
            }
        }

        return $resourcePermissionTypes;
    }

    // /**
    //  * @param ResourceFilterValues $filterValues
    //  * @param CustomAttribute[] $resourceAttributes
    //  */
    // public function InitializeFilter($filterValues, $resourceAttributes)
    // {
    //     $filters = $filterValues->Attributes;
    //     $attributeFilters = [];
    //     foreach ($resourceAttributes as $attribute) {
    //         $attributeValue = null;
    //         if (array_key_exists($attribute->Id(), $filters)) {
    //             $attributeValue = $filters[$attribute->Id()];
    //         }
    //         $attributeFilters[] = new LBAttribute($attribute, $attributeValue);
    //     }

    //     $this->page->BindAttributeFilters($attributeFilters);
    //     $this->page->SetFilterValues($filterValues);
    // }
}