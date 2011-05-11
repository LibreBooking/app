<?php
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Authorization/namespace.php');

class ManageUsersActions
{
	const Activate = 'activate';
	const Deactivate = 'deactivate';
	const Password = 'password';
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
	 * @var \PasswordEncryption
	 */
	private $passwordEncryption;

	/**
	 * @param IManageUsersPage $page
	 * @param UserRepository $userRepository
	 */
	public function __construct(IManageUsersPage $page, UserRepository $userRepository, IResourceRepository $resourceRepository, PasswordEncryption $passwordEncryption)
	{
		parent::__construct($page);
		
		$this->page = $page;
		$this->userRepository = $userRepository;
		$this->resourceRepository = $resourceRepository;
		$this->passwordEncryption = $passwordEncryption;

		$this->AddAction(ManageUsersActions::Activate, 'Activate');
		$this->AddAction(ManageUsersActions::Deactivate, 'Deactivate');
		$this->AddAction(ManageUsersActions::Password, 'ResetPassword');
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

	public function ResetPassword()
	{
		$salt = $this->passwordEncryption->Salt();
		$encryptedPassword = $this->passwordEncryption->Encrypt($this->page->GetPassword(), $salt);

		$user = $this->userRepository->LoadById($this->page->GetUserId());
		$user->ChangePassword($encryptedPassword, $salt);
		$this->userRepository->Update($user);
	}


	public function ProcessDataRequest()
	{
		$this->page->SetJsonResponse($this->GetUserResourcePermissions());
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
