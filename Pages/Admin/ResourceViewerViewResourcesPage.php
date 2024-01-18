<?php

require_once(ROOT_DIR . 'Presenters/Admin/ViewResourcesPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Admin/namespace.php');
require_once(ROOT_DIR . 'Pages/Page.php');
require_once(ROOT_DIR . 'Pages/IPageable.php');
require_once(ROOT_DIR . 'lib/Application/Attributes/namespace.php');
require_once(ROOT_DIR . 'Pages/Admin/ManageResourcesPage.php');

class ResourceViewerViewResourcesPage extends Page implements IPageable
{
    private $presenter;
    protected $pageablePage;

    public function __construct()
    {
        parent::__construct('CheckResources');
        $this->presenter = new ViewResourcesPresenter($this,new ResourceRepository(), new ScheduleRepository(), new GroupRepository(), new AttributeService(new AttributeRepository()));
        $this->pageablePage = new PageablePage($this);

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
        $this->Set("ResourceTypes",$resourceTypes);
    }

    public function SetResourcePermissionTypes($resourcePermissionTypes){
        $this->Set("ResourcePermissionTypes",$resourcePermissionTypes);
    }

    /**
     * @param PageInfo $pageInfo
     * @return void
     */
    public function BindPageInfo(PageInfo $pageInfo)
    {
        $this->pageablePage->BindPageInfo($pageInfo);
    }

        /**
     * @return int
     */
    public function GetPageNumber()
    {
        return $this->pageablePage->GetPageNumber();
    }

    /**
     * @return int
     */
    public function GetPageSize()
    {
        $pageSize = $this->pageablePage->GetPageSize();

        if ($pageSize > 10) {
            return 10;
        }
        return $pageSize;
    }
    

    public function SetFilterValues($values)
    {
        $this->Set('ResourceNameFilter', $values->ResourceNameFilter);
        $this->Set('ScheduleIdFilter', $values->ScheduleIdFilter);
        $this->Set('ResourceTypeFilter', $values->ResourceTypeFilter);
        $this->Set('ResourceStatusFilterId', $values->ResourceStatusFilterId == '' ? '' : intval($values->ResourceStatusFilterId));
        $this->Set('ResourceStatusReasonFilterId', $values->ResourceStatusReasonFilterId == '' ? '' : intval($values->ResourceStatusReasonFilterId));
        $this->Set('CapacityFilter', $values->CapacityFilter);
        $this->Set('RequiresApprovalFilter', $values->RequiresApprovalFilter);
        $this->Set('AutoPermissionFilter', $values->AutoPermissionFilter);
        $this->Set('AllowMultiDayFilter', $values->AllowMultiDayFilter);
    }

    public function GetFilterValues()
    {
        $filterValues = new ResourceFilterValues();

        $filterValues->ResourceNameFilter = $this->GetQuerystring(FormKeys::RESOURCE_NAME);
        $filterValues->ScheduleIdFilter = $this->GetQuerystring(FormKeys::SCHEDULE_ID);
        $filterValues->ResourceTypeFilter = $this->GetQuerystring(FormKeys::RESOURCE_TYPE_ID);
        $filterValues->ResourceStatusFilterId = $this->GetQuerystring(FormKeys::RESOURCE_STATUS_ID);
        $filterValues->ResourceStatusReasonFilterId = $this->GetQuerystring(FormKeys::RESOURCE_STATUS_REASON_ID);
        $filterValues->CapacityFilter = $this->GetQuerystring(FormKeys::MAX_PARTICIPANTS);
        $filterValues->RequiresApprovalFilter = $this->GetQuerystring(FormKeys::REQUIRES_APPROVAL);
        $filterValues->AutoPermissionFilter = $this->GetQuerystring(FormKeys::AUTO_ASSIGN);
        $filterValues->AllowMultiDayFilter = $this->GetQuerystring(FormKeys::ALLOW_MULTIDAY);
        $filterValues->SetAttributes(AttributeFormParser::GetAttributes($this->GetQuerystring(FormKeys::ATTRIBUTE_PREFIX)));

        return $filterValues;
    }

    /**
     * @param $resources AdminResourceJson[]
     */
    public function SetResourcesJson($resources)
    {
        $this->SetJson($resources);
    }

    public function SetJsonResponse($response)
    {
        parent::SetJson($response);
    }

    public function BindAttributeFilters($attributeFilters)
    {
        $this->Set('AttributeFilters', $attributeFilters);
    }

    public function FilterButtonPressed()
    {
        return count($_GET) > 0;
    }
}
