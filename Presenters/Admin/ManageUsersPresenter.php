<?php

class ManageUsersActions
{
	const Activate = 'activate';
	const Deactivate = 'deactivate';
}

class ManageUsersPresenter
{
	/**
	 * @var \IManageUsersPage
	 */
	private $page;

	/**
	 * @var UserRepository
	 */
	private $userRepository;

	/**
	 * @var ResourceRepository
	 */
	private $resourceRepository;

	/**
	 * @param IManageUsersPage $page
	 * @param IUserViewRepository $userRepository
	 */
	public function __construct(IManageUsersPage $page, IUserViewRepository $userRepository, IResourceRepository $resourceRepository)
	{
		$this->page = $page;
		$this->userRepository = $userRepository;
		$this->resourceRepository = $resourceRepository;
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


	public function ProcessAction()
	{
//		$this->Deactivate();
		$this->Activate();
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
		$repo = new ScheduleUserRepository();
		$resources = $repo->GetUser($this->page->GetUserId())->GetResources();

		return array_map(function($resource) { return $resource->Id();}, $resources);

	}
}

?>
