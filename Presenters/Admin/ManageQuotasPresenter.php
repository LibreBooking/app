<?php
require_once(ROOT_DIR . 'Domain/Access/namespace.php');
require_once(ROOT_DIR . 'Presenters/ActionPresenter.php');
require_once(ROOT_DIR . 'lib/Application/Authentication/namespace.php');

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
	 * @param IScheduleRepository $scheduleRepository
	 * @param IQuotaViewRepository|IQuotaRepository $quotaRepository
	 */
	public function __construct(IManageQuotasPage $page,
		IResourceRepository $resourceRepository,
		IGroupViewRepository $groupRepository,
		IScheduleRepository $scheduleRepository,
		IQuotaViewRepository $quotaRepository)
	{
		parent::__construct($page);

		$this->page = $page;
		$this->resourceRepository = $resourceRepository;
		$this->groupRepository = $groupRepository;
		$this->scheduleRepository = $scheduleRepository;
		$this->quotaRepository = $quotaRepository;

		$this->AddAction(ManageQuotasActions::AddQuota, 'AddQuota');
		$this->AddAction(ManageQuotasActions::DeleteQuota, 'DeleteQuota');
	}

	public function PageLoad()
	{
		$resources = $this->resourceRepository->GetResourceList();
		$groups = $this->groupRepository->GetList()->Results();
		$schedules = $this->scheduleRepository->GetAll();
		
		$this->page->BindResources($resources);
		$this->page->BindGroups($groups);
		$this->page->BindSchedules($schedules);

		$quotas = $this->quotaRepository->GetAll();
		$this->page->BindQuotas($quotas);
	}

	public function AddQuota()
	{
		Log::Debug('Adding new quota');
		
		$quota = Quota::Create($this->page->GetDuration(),
							   $this->page->GetLimit(),
							   $this->page->GetUnit(),
							   $this->page->GetResourceId(),
							   $this->page->GetGroupId(),
							   $this->page->GetScheduleId());
		$this->quotaRepository->Add($quota);
	}

	public function DeleteQuota()
	{
		$quotaId = $this->page->GetQuotaId();
		Log::Debug('Deleting quota %s', $quotaId);

		$this->quotaRepository->DeleteById($quotaId);
	}

}

?>