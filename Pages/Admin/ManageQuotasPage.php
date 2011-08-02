<?php 
require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageQuotasPresenter.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

interface IManageQuotasPage extends IActionPage
{
	/**
	 * @abstract
	 * @param array|BookableResource[] $resources
	 * @return void
	 */
	public function BindResources($resources);

	/**
	 * @abstract
	 * @param array|GroupItemView[] $groups
	 * @return void
	 */
	public function BindGroups($groups);

	/**
	 * @abstract
	 * @param array|QuotaItemView[] $quotas
	 * @return void
	 */
	public function BindQuotas($quotas);
}

class ManageQuotasPage extends AdminPage implements IManageQuotasPage
{
	/**
	 * @var \ManageQuotasPresenter
	 */
	private $presenter;
	
	public function __construct()
	{
		parent::__construct('ManageQuotas');
		$this->presenter = new ManageQuotasPresenter($this, new ResourceRepository(), new GroupRepository());
	}
	
	public function PageLoad()
	{
		$this->presenter->PageLoad();

		$this->Display('manage_quotas.tpl');
	}

	public function ProcessAction()
	{
		$this->presenter->ProcessAction();
	}

	public function FulfilDataRequest()
	{
		$this->presenter->ProcessDataRequest();
	}

	public function SetJsonResponse($response)
	{
		parent::SetJson($response);
	}

	/**
	 * @param array|BookableResource[] $resources
	 * @return void
	 */
	public function BindResources($resources)
	{
		$this->Set('Resources', $resources);
	}

	/**
	 * @param array|GroupItemView[] $groups
	 * @return void
	 */
	public function BindGroups($groups)
	{
		$this->Set('Groups', $groups);
	}

	/**
	 * @param array|QuotaItemView[] $quotas
	 * @return void
	 */
	public function BindQuotas($quotas)
	{
		$this->Set('Quotas', $quotas);
	}
}
?>