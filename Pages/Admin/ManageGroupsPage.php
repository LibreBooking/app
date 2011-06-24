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
}

class ManageGroupsPage extends AdminPage implements IManageGroupsPage
{
	private $presenter;
	public function __construct()
	{
		parent::__construct('ManageGroups');
		$this->presenter = new ManageGroupsPresenter($this, new GroupRepository());
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
		return $this->server->GetQuerystring(QueryStringKeys::GROUP_ID);
	}

	public function FulfilDataRequest()
	{
		$this->presenter->ProcessDataRequest();
//		$groups = ServiceLocator::GetDatabase()->Query(new AdHocCommand('select * from groups'));
//		$data = json_encode($groups);
//		$this->Set('data', $data);
//		$this->Display('json_data.tpl');
	}

	public function SetJsonResponse($response)
	{
		parent::SetJson($response);
	}
}
?>