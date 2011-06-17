<?php
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Authorization/namespace.php');

class ManageGroupsActions
{
	const Activate = 'activate';
	const Deactivate = 'deactivate';
	const Password = 'password';
	const Permissions = 'permissions';
}

class ManageGroupsPresenter extends ActionPresenter
{
	/**
	 * @var \IManageGroupsPage
	 */
	private $page;

	/**
	 * @var \GroupRepository
	 */
	private $groupRepository;

	/**
	 * @var ResourceRepository
	 */
	private $resourceRepository;

	/**
	 * @param IManageGroupsPage $page
	 * @param GroupRepository $groupRepository
	 */
	public function __construct(IManageGroupsPage $page, GroupRepository $groupRepository)
	{
		parent::__construct($page);
		
		$this->page = $page;
		$this->groupRepository = $groupRepository;

//		$this->AddAction(ManageGroupsActions::Activate, 'Activate');
//		$this->AddAction(ManageGroupsActions::Deactivate, 'Deactivate');
//		$this->AddAction(ManageGroupsActions::Permissions, 'ChangePermissions');
	}

	public function PageLoad()
	{
		if ($this->page->GetGroupId() != null)
		{
			$groupList = $this->groupRepository->GetList(1, 1, null, null, new EqualsSqlFilter(ColumnNames::GROUP_ID, $this->page->GeTGroupId()));
		}
		else
		{
			$groupList = $this->groupRepository->GetList($this->page->GetPageNumber(), $this->page->GetPageSize());
		}

		$this->page->BindGroups($groupList->Results());
		$this->page->BindPageInfo($groupList->PageInfo());

		//$this->page->BindResources($this->resourceRepository->GetResourceList());
	}



	public function ChangePermissions()
	{
		$user = $this->userRepository->LoadById($this->page->GetUserId());
		$allowedResources = array();

		if (is_array($this->page->GetAllowedResourceIds()))
		{
			$allowedResources = $this->page->GetAllowedResourceIds();
		}
		$user->ChangePermissions($allowedResources);
		$this->userRepository->Update($user);
	}

	public function ProcessDataRequest()
	{
		$this->page->SetJsonResponse($this->GetUserResourcePermissions());
	}

	/**
	 * @return int[] all resource ids the user has permission to
	 */
	public function GetGroupResourcePermissions()
	{
		$user = $this->userRepository->LoadById($this->page->GetUserId());
		return $user->AllowedResourceIds();
	}
}

?>
