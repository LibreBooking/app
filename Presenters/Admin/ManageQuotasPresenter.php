<?php
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Authorization/namespace.php');

class ManageQuotasActions
{
	const AddQuota = 'addQuota';
	const DeleteQuota = 'deleteQuota';
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
	 * @var \IQuotaViewRepository
	 */
	private $quotaRepository;

	/**
	 * @param IManageQuotasPage $page
	 * @param IResourceRepository $resourceRepository
	 * @param IGroupViewRepository $groupRepository
	 * @param IQuotaViewRepository|IQuotaRepository $quotaRepository
	 */
	public function __construct(IManageQuotasPage $page, IResourceRepository $resourceRepository, IGroupViewRepository $groupRepository, IQuotaViewRepository $quotaRepository)
	{
		parent::__construct($page);

		$this->page = $page;
		$this->resourceRepository = $resourceRepository;
		$this->groupRepository = $groupRepository;
		$this->quotaRepository = $quotaRepository;

		$this->AddAction(ManageQuotasActions::AddQuota, 'AddQuota');
		$this->AddAction(ManageQuotasActions::DeleteQuota, 'DeleteQuota');
	}

	public function PageLoad()
	{
		$resources = $this->resourceRepository->GetResourceList();
		$groups = $this->groupRepository->GetList()->Results();
		
		$this->page->BindResources($resources);
		$this->page->BindGroups($groups);

		$quotas = $this->quotaRepository->GetAll();
		$this->page->BindQuotas($quotas);
	}

	public function AddQuota()
	{
		$quota = Quota::Create($this->page->GetDuration(), $this->page->GetLimit(), $this->page->GetUnit(), $this->page->GetResourceId(), $this->page->GetGroupId());
		$this->quotaRepository->Add($quota);
	}

}

?>