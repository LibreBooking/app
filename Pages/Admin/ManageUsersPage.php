<?php 
require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageUsersPresenter.php');
require_once(ROOT_DIR . 'Domain/Access/UserRepository.php');


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
		
		$r = new PageableDataStore();
		$users = $r->GetUsers($pageNumber, $pageSize);
		$rowCount = $r->GetList();
		
		$this->Display('manage_users.tpl');
	}
	
	public function BindResources($resources)
	{
		$this->Set('Resources', $resources);
	}
	
	public function BindSchedules($schedules)
	{
		$this->Set('Schedules', $schedules);
	}
	
	public function ProcessAction()
	{
		$this->_presenter->ProcessAction();
	}
}



?>