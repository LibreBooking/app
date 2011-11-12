<?php
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');

class ManageAccessoriesActions
{
	const Add = 'addAccessory';
	const Change = 'changeAccessory';
	const Delete = 'deleteAccessory';
}

class ManageAccessoriesPresenter extends ActionPresenter
{
	/**
	 * @var IManageAccessoriesPage
	 */
	private $page;

	/**
	 * @var IAccessoryRepository
	 */
	private $accessoryRepository;

	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;

	/**
	 * @param IManageAccessoriesPage $page
	 * @param IResourceRepository $resourceRepository
	 * @param IAccessoryRepository $accessoryRepository
	 */
	public function __construct(IManageAccessoriesPage $page, IResourceRepository $resourceRepository, IAccessoryRepository $accessoryRepository)
	{
		parent::__construct($page);

		$this->page = $page;
		$this->resourceRepository = $resourceRepository;
		$this->accessoryRepository = $accessoryRepository;

		$this->AddAction(ManageAccessoriesActions::Add, 'AddAccessory');
		$this->AddAction(ManageAccessoriesActions::Change, 'ChangeAccessory');
		$this->AddAction(ManageAccessoriesActions::Delete, 'DeleteAccessory');
	}

	public function PageLoad()
	{
		$accessories = $this->resourceRepository->GetAccessoryList();

		$this->page->BindAccessories($accessories);
	}

	protected function AddAccessory()
	{
		
	}

	protected function ChangeAccessory()
	{
		
	}
	
	protected function DeleteAccessory()
	{
		
	}
}
?>