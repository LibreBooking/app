<?php 
require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageGroupsPresenter.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

interface IManageGroupsPage
{
	public function GetGroupId();

	public function BindGroups($groups);

	public function BindPageInfo(PageInfo $pageInfo);

	public function GetPageNumber();

	public function GetPageSize();

	public function SetJsonResponse($response);

	public function GetUserId();
	
	public function BindResources($resources);

	public function GetAllowedResourceIds();

	public function GetGroupName();
}

class ManageGroupsPage extends AdminPage implements IManageGroupsPage
{
	private $presenter;
	public function __construct()
	{
		parent::__construct('ManageGroups');
		$this->presenter = new ManageGroupsPresenter($this, new GroupRepository(), new ResourceRepository());
	}
	
	public function PageLoad()
	{
		$this->presenter->PageLoad();

		$this->Display('manage_groups.tpl');
	}

	public function BindPageInfo(PageInfo $pageInfo)
	{
		$this->Set('PageInfo', $pageInfo);
	}
	
	public function BindGroups($groups)
	{
		$this->Set('groups', $groups);
	}
	
	public function ProcessAction()
	{
		$this->presenter->ProcessAction();
	}

	public function GetPageNumber()
	{
		return $this->server->GetQuerystring(QueryStringKeys::PAGE);
	}

	public function GetPageSize()
	{
		return 50;
	}

	/**
	 * @return int
	 */
	public function GetGroupId()
	{
		return $this->GetQuerystring(QueryStringKeys::GROUP_ID);
	}

	public function FulfilDataRequest()
	{
		$this->presenter->ProcessDataRequest();
	}

	public function SetJsonResponse($response)
	{
		parent::SetJson($response);
	}

	public function GetUserId()
	{
		return $this->GetForm(FormKeys::USER_ID);
	}

	/**
	 * @param BookableResources[] $resources
	 * @return void
	 */
	public function BindResources($resources)
	{
		$this->Set('resources', $resources);
	}

	/**
	 * @return int[] resource ids the user has permission to
	 */
	public function GetAllowedResourceIds()
	{
		return $this->GetForm(FormKeys::RESOURCE_ID);
	}

	public function GetGroupName()
	{
		return $this->GetForm(FormKeys::GROUP_NAME);
	}
}
?>