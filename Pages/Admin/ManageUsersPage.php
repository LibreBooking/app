<?php 
require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
//require_once(ROOT_DIR . 'Presenters/Admin/ManageUsersPresenter.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');


class ManageUsersPage extends AdminPage
{
	public function __construct()
	{
		parent::__construct('ManageUsers');
//		$this->_presenter = new ManageUsersPresenter(
//								$this,
//								new UserRepository()
//								);
	}
	
	public function PageLoad()
	{
		//$this->_presenter->PageLoad();
		$pageNumber = 1;
		$pageSize = 50;
		
		$r = new UserRepository();
		$pageable = $r->GetList($pageNumber, $pageSize);

		$this->BindUsers($pageable->Results());
		$this->BindPageInfo($pageable->PageInfo());
		
		$this->Display('manage_users.tpl');
	}

	public function BindPageInfo(PageInfo $pageInfo)
	{
		$this->Set('page', $pageInfo->CurrentPage);
		$this->Set('totalPages', $pageInfo->TotalPages);
		$this->Set('totalResults', $pageInfo->Total);
		$this->Set('pages', range(1, $pageInfo->TotalPages));
	}
	public function BindUsers($users)
	{
		$this->Set('users', $users);
	}
	
	public function ProcessAction()
	{
		$this->_presenter->ProcessAction();
	}
}



?>