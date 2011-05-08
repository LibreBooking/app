<?php 
require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
//require_once(ROOT_DIR . 'Presenters/Admin/ManageUsersPresenter.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');


class ManageGroupsPage extends AdminPage
{
	public function __construct()
	{
		parent::__construct('ManageGroups');
		//$this->_presenter = new ManageUsersPresenter($this, new UserRepository());
	}
	
	public function PageLoad()
	{
		$this->_presenter->PageLoad();

		$this->Set('statusDescriptions', array(AccountStatus::ACTIVE => 'Active', AccountStatus::AWAITING_ACTIVATION => 'Inactive', AccountStatus::INACTIVE => 'Inactive'));
		$this->Display('manage_users.tpl');
	}

	public function BindPageInfo(PageInfo $pageInfo)
	{
		$this->Set('page', $pageInfo->CurrentPage);
		$this->Set('totalPages', $pageInfo->TotalPages);
		$this->Set('totalResults', $pageInfo->Total);
		$this->Set('pages', range(1, $pageInfo->TotalPages));
        $this->Set('resultsStart', $pageInfo->ResultsStart);
        $this->Set('resultsEnd', $pageInfo->ResultsEnd);
	}
	
	public function BindUsers($users)
	{
		$this->Set('users', $users);
	}
	
	public function ProcessAction()
	{
		$this->_presenter->ProcessAction();
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
	public function GetUserId()
	{
		return $this->server->GetQuerystring(QueryStringKeys::USER_ID);
	}

	public function FulfilDataRequest()
	{
		$groups = ServiceLocator::GetDatabase()->Query(new AdHocCommand('select * from groups'));
		$data = json_encode($groups);
		$this->Set('data', $data);
		$this->Display('json_data.tpl');
	}
}
?>