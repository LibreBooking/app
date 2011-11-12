<?php
require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageAccessoriesPresenter.php');

interface IManageAccessoriesPage extends IActionPage
{
	/**
	 * @abstract
	 * @return int
	 */
	public function GetAccessoryId();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetAccessoryName();

	/**
	 * @abstract
	 * @param $accessories AccessoryDto[]
	 * @return void
	 */
	public function BindAccessories($accessories);
}

class ManageAccessoriesPage extends AdminPage implements IManageAccessoriesPage
{
	/**
	 * @var ManageAccessoriesPresenter
	 */
	private $presenter;

	public function __construct()
	{
		parent::__construct('ManageAccessories');
		$this->presenter = new ManageAccessoriesPresenter($this, new ResourceRepository(), new AccessoryRepository());
	}

	public function PageLoad()
	{
		$this->presenter->PageLoad();

		$this->Display('manage_accessories.tpl');
	}

	public function BindAccessories($accessories)
	{
		$this->Set('accessories', $accessories);
	}

	public function ProcessAction()
	{
		$this->presenter->ProcessAction();
	}

	/**
	 * @return int
	 */
	public function GetAccessoryId()
	{
		return $this->GetQuerystring(QueryStringKeys::ACCESSORY_ID);
	}

	/**
	 * @return string
	 */
	public function GetAccessoryName()
	{
		$this->GetForm(FormKeys::ACCESSORY_NAME);
	}

	/**
	 * @return string
	 */
	public function GetQuantityAvailable()
	{
		$this->GetForm(FormKeys::ACCESSORY_QUANTITY_AVAILABLE);
	}
}

?>