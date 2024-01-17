<?php

//require_once(ROOT_DIR . 'Pages/Admin/ManageResourcesPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ViewResourcesPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Admin/namespace.php');
require_once(ROOT_DIR . 'Pages/Page.php');

class ResourceViewerViewResourcesPage extends Page
{
    private $presenter;

    public function __construct()
    {
        parent::__construct('ViewResources');
        $this->presenter = new ViewResourcesPresenter($this,new ResourceRepository(), new ScheduleRepository(), new GroupRepository());


        // $this->presenter = new ManageResourcesPresenter(
        //     $this,
        //     new ResourceAdminResourceRepository(new UserRepository(), ServiceLocator::GetServer()->GetUserSession()),
        //     new ScheduleRepository(),
        //     new ImageFactory(),
        //     new GroupRepository(),
        //     new AttributeService(new AttributeRepository()),
        //     new UserPreferenceRepository(),
        //     new ReservationViewRepository()
        // );
    }

    public function PageLoad(){
        $this->presenter->PageLoad();
        $this->Display(ROOT_DIR.'tpl/Admin/Resources/view_resources.tpl');
    }

    public function SetResources($resources){
        $this->Set("Resources",$resources);
    }

    public function SetScheduleNames($scheduleNames){
        $this->Set("Schedules",$scheduleNames);
    }

    public function SetResourceAdminGroupNames($resourceAdminGroupNames){
        $this->Set("ResourceAdminGroupNames",$resourceAdminGroupNames);
    }

    public function SetResourceGroups($resourceGroupNames){
        $this->Set("ResourceGroupNames",$resourceGroupNames);
    }

    public function SetResourceStatusReasons($resourceStatusReasons){
        $this->Set("StatusReasons",$resourceStatusReasons);
    }

    public function SetResourceTypes($resourceTypes){
        var_dump($resourceTypes);
        $this->Set("ResourceTypes",$resourceTypes);
    }

}
