<?php

class ViewResourcesPresenter{
    
    /**
     * @var ViewResourcesPage;
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


    public function __construct(
        ResourceViewerViewResourcesPage $page,
        IResourceRepository $resourceRepo,
        IScheduleRepository $scheduleRepo,
        IGroupRepository $groupRepo
        )
    {
    
       $this->page = $page;
       $this->resourceRepo = $resourceRepo;
       $this->scheduleRepo = $scheduleRepo;
       $this->groupRepo = $groupRepo;

       $this->page->PageLoad;
       $this->GetUserResources();
    }

    public function PageLoad(){
        $resources = $this->GetUserResources();

        $this->page->SetResources($resources);

        $this->page->SetScheduleNames($this->GetSchedulesNames());
        $this->page->SetResourceAdminGroupNames($this->GetResourceAdminGroupNames());
        $this->page->SetResourceGroups($this->GetResourceGroupNames());
        $this->page->SetResourceStatusReasons($this->GetResourceStatusReasons());
        $this->page->SetResourceTypes($this->GetResourceTypes());

    }

    private function GetUserResources(){
        /**
         * SERA QUE FICA MELHOR COM ROLES DOS GRUPOS VIEW OU COM PERMISSOES DE UTILIZADOR E DE GRUPOS??? OU OS 2s?????
         */

        //PERMISSOES DE UTILIZADOR
        $resourceIds = [];
        $userId = ServiceLocator::GetServer()->GetUserSession()->UserId;

        $resourceIds = $this->resourceRepo->GetUserResourcePermissions($userId);

        $resourceIds = $this->resourceRepo->GetUserGroupResourcePermissions($userId,$resourceIds);


        //RESOURCE VIEWER RESOURCES
        /*if (ServiceLocator::GetServer()->GetUserSession()->IsResourceAdmin){    
            $resourceIds = $this->resourceRepo->GetResourceAdminResourceIds($userId, $resourceIds);
        }
        */

        //echo '<pre>' , var_dump($resourceIds) , '</pre>';

        //$this->page->BindViewableResourceReservations($resourceIds);

        foreach($resourceIds as $resourceId){
            $resources[] = $this->resourceRepo->LoadById($resourceId);
        }

        return $resources;
    }

    private function GetSchedulesNames(){
        $scheduleNames = [];
        $schedules = $this->scheduleRepo->GetAll();
        foreach($schedules as $schedule){
            $scheduleNames[$schedule->GetId()] = $schedule->GetName();
        }

        return $scheduleNames;
    }

    private function GetResourceAdminGroupNames(){
        $resourceAdminGroupNames = [];

        $resourceAdminGroups = $this->groupRepo->GetGroupsByRole(3); //RESOURCE ADMINS

        foreach($resourceAdminGroups as $resourceAdminGroup){
            $resourceAdminGroupNames[$resourceAdminGroup->Id] = $resourceAdminGroup->Name;
        }

        return $resourceAdminGroupNames;    
    }

    private function GetResourceGroupNames(){
        $resourceGroupNames = [];
        
        $resourceGroups = $this->resourceRepo->GetResourceGroupsList();

        foreach($resourceGroups as $resourceGroup){
            $resourceGroupNames[$resourceGroup->id] = $resourceGroup->name;
        }

        return $resourceGroupNames;    
    }

    private function GetResourceStatusReasons(){
        $resourceStatusReasons = [];

        $resourceStatusReasonsList = $this->resourceRepo->GetStatusReasons();

        foreach($resourceStatusReasonsList as $resourceStatusReason){
            $resourceStatusReasons[$resourceStatusReason->Id()] = $resourceStatusReason->Description();
        }

        return $resourceStatusReasons;  
    }

    private function GetResourceTypes(){
        $resourceTypes = [];

        $resourceTypesList = $this->resourceRepo->GetResourceTypes();

        foreach($resourceTypesList as $resourceType){
            $resourceTypes[$resourceType->Id()]  = $resourceType->Name();
        }

        return $resourceTypes;
    }
    
}