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

	public function AddAccessory()
	{
		$name = $this->page->GetAccessoryName();
		$quantity = $this->page->GetQuantityAvailable();
		
		Log::Debug('Adding new accessory with name %s and quantity %s', $name, $quantity);

		$this->accessoryRepository->Add(Accessory::Create($name, $quantity));
	}

	public function ChangeAccessory()
	{
		$id = $this->page->GetAccessoryId();
		$name = $this->page->GetAccessoryName();
		$quantity = $this->page->GetQuantityAvailable();
		
		Log::Debug('Changing accessory with id %s to name %s and quantity %s', $id, $name, $quantity);

		$accessory = $this->accessoryRepository->LoadById($id);
		$accessory->SetName($name);
		$accessory->SetQuantityAvailable($quantity);
		
		$this->accessoryRepository->Update($accessory);
	}
	
	public function DeleteAccessory()
	{
		$id = $this->page->GetAccessoryId();
		
		Log::Debug('Deleting accessory with id %s', $id);

		$this->accessoryRepository->Delete($id);
	}
}
?>