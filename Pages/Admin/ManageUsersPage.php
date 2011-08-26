<?php 
require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageUsersPresenter.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

interface IManageUsersPage extends IPageable, IActionPage
{
	/**
	 * @abstract
	 * @param UserItemView[] $users
	 * @return void
	 */
	function BindUsers($users);

	/**
	 * @abstract
	 * @return int
	 */
	public function GetUserId();

	/**
	 * @abstract
	 * @param BookableResources[] $resources
	 * @return void
	 */
	public function BindResources($resources);

	/**
	 * @abstract
	 * @param mixed $objectToSerialize
	 * @return void
	 */
	public function SetJsonResponse($objectToSerialize);

	/**
	 * @abstract
	 * @return int[] resource ids the user has permission to
	 */
	public function GetAllowedResourceIds();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetPassword();
}

interface IPageable
{
	/**
	 * @abstract
	 * @return int
	 */
	function GetPageNumber();

	/**
	 * @abstract
	 * @return int
	 */
	function GetPageSize();

	/**
	 * @abstract
	 * @param PageInfo $pageInfo
	 * @return void
	 */
	function BindPageInfo(PageInfo $pageInfo);
}

class ManageUsersPage extends AdminPage implements IManageUsersPage
{
	public function __construct()
	{
		parent::__construct('ManageUsers');
		$this->_presenter = new ManageUsersPresenter(
			$this,
			new UserRepository(),
			new ResourceRepository(),
			new PasswordEncryption());
	}
	
	public function PageLoad()
	{
		$this->_presenter->PageLoad();

		$this->Set('statusDescriptions', array(AccountStatus::ACTIVE => 'Active', AccountStatus::AWAITING_ACTIVATION => 'Pending', AccountStatus::INACTIVE => 'Inactive'));
		$this->Display('manage_users.tpl');
	}

	public function BindPageInfo(PageInfo $pageInfo)
	{
		$this->set('PageInfo', $pageInfo);
	}
	
	public function BindUsers($users)
	{
		$this->Set('users', $users);
	}
	
	public function ProcessAction()
	{
		$this->_presenter->ProcessAction();
	}

	public function ProcessDataRequest()
	{
		$this->_presenter->ProcessDataRequest();
	}

	public function GetPageNumber()
	{
		return $this->GetQuerystring(QueryStringKeys::PAGE);
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
		return $this->GetQuerystring(QueryStringKeys::USER_ID);
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

	/**
	 * @return string
	 */
	public function GetPassword()
	{
		return $this->GetForm(FormKeys::PASSWORD);
	}

	function GetAction()
	{
		return parent::GetAction();
	}

	/**
	 * @param mixed $objectToSerialize
	 * @return void
	 */
	public function SetJsonResponse($objectToSerialize)
	{
		parent::SetJson($objectToSerialize);
	}

	function TakingAction()
	{
		return parent::GetAction();
	}
}
?>