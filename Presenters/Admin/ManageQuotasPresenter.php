<?php
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Authorization/namespace.php');

class ManageQuotasActions
{
	const AddUser = 'addUser';
}

class ManageQuotasPresenter extends ActionPresenter
{
	/**
	 * @var IManageQuotasPage
	 */
	private $page;

	/**
	 * @var IResourceRepository
	 */
	private $resourceRepository;

	/**
	 * @var IGroupViewRepository
	 */
	private $groupRepository;

	/**
	 * @param IManageQuotasPage $page
	 * @param IResourceRepository $resourceRepository
	 * @param IGroupViewRepository $groupRepository
	 */
	public function __construct(IManageQuotasPage $page, IResourceRepository $resourceRepository, IGroupViewRepository $groupRepository)
	{
		parent::__construct($page);

		$this->page = $page;
		$this->resourceRepository = $resourceRepository;
		$this->groupRepository = $groupRepository;

		$this->AddAction(ManageQuotasActions::AddUser, 'AddUser');
	}

	public function PageLoad()
	{
		$resources = $this->resourceRepository->GetResourceList();
		$groups = $this->groupRepository->GetList()->Results();
		
		$this->page->BindResources($resources);
		$this->page->BindGroups($groups);

		$quotas = array(
			new QuotaItemView(1, 10, 'reservations', 'week', 'group2', null),
			new QuotaItemView(1, 10, 'hours', 'day', null, 'resource2')
		);
		$this->page->BindQuotas($quotas);
	}

	public function ProcessDataRequest()
	{
		$response = '';
		$this->page->SetJsonResponse($response);
	}
}

class QuotaItemView
{
	public $Id;
	public $Amount;
	public $Unit;
	public $Duration;
	public $GroupName;
	public $ResourceName;

	/**
	 * @param int $quotaId
	 * @param decimal $amount
	 * @param string $unit
	 * @param string $duration
	 * @param string $groupName
	 * @param string $resourceName
	 */
	public function __construct($quotaId, $amount, $unit, $duration, $groupName, $resourceName)
	{
		$this->Id = $quotaId;
		$this->Amount = $amount;
		$this->Unit = $unit;
		$this->Duration = $duration;
		$this->GroupName = $groupName;
		$this->ResourceName = $resourceName;
	}
}

?>