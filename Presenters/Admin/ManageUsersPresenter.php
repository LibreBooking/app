<?php
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');

class ManageUsersActions
{
	const Activate = 'activate';
	const Deactivate = 'deactivate';
	const Permissions = 'permissions';
}

class ManageUsersPresenter extends ActionPresenter
{
	/**
	 * @var \IManageUsersPage
	 */
	private $page;

	/**
	 * @var \UserRepository
	 */
	private $userRepository;

	/**
	 * @var ResourceRepository
	 */
	private $resourceRepository;

	/**
	 * @param IManageUsersPage $page
	 * @param UserRepository $userRepository
	 */
	public function __construct(IManageUsersPage $page, UserRepository $userRepository, IResourceRepository $resourceRepository)
	{
		parent::__construct($page);
		
		$this->page = $page;
		$this->userRepository = $userRepository;
		$this->resourceRepository = $resourceRepository;

		$this->AddAction(ManageUsersActions::Activate, 'Activate');
		$this->AddAction(ManageUsersActions::Deactivate, 'Deactivate');
		$this->AddAction(ManageUsersActions::Permissions, 'ChangePermissions');
	}

	public function PageLoad()
	{
		$userList = $this->userRepository->GetList($this->page->GetPageNumber(), $this->page->GetPageSize());
		$this->page->BindUsers($userList->Results());
		$this->page->BindPageInfo($userList->PageInfo());

		$this->page->BindResources($this->resourceRepository->GetResourceList());
	}

	public function Deactivate()
	{
		$user = $this->userRepository->LoadById($this->page->GetUserId());
		$user->Deactivate();
		$this->userRepository->Update($user);
	}

	public function Activate()
	{
		$user = $this->userRepository->LoadById($this->page->GetUserId());
		$user->Activate();
		$this->userRepository->Update($user);
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
		$this->page->SetJson($this->GetUserResourcePermissions());
	}

	/**
	 * @return int[] all resource ids the user has permission to
	 */
	public function GetUserResourcePermissions()
	{
		$user = $this->userRepository->LoadById($this->page->GetUserId());
		return $user->AllowedResourceIds();
	}
}

?>
