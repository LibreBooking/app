<?php
require_once(ROOT_DIR . 'Pages/Admin/AdminPage.php');
require_once(ROOT_DIR . 'Pages/Ajax/AutoCompletePage.php');
require_once(ROOT_DIR . 'Presenters/Admin/ManageReservationsPresenter.php');

interface IManageReservationsPage
{
	/**
	 * @abstract
	 * @param array|ReservationItemView[] $reservations
	 * @return void
	 */
	public function BindReservations($reservations);

	/**
	 * @abstract
	 * @param PageInfo $pageInfo
	 * @return void
	 */
	public function SetPageInfo($pageInfo);

	/**
	 * @abstract
	 * @return string
	 */
	public function GetStartDate();

	/**
	 * @abstract
	 * @return string
	 */
	public function GetEndDate();
	
	/**
	 * @abstract
	 * @param Date $date|null
	 * @return void
	 */
	public function SetStartDate($date);

	/**
	 * @abstract
	 * @param Date $date|null
	 * @return void
	 */
	public function SetEndDate($date);
}

class ManageReservationsPage extends AdminPage implements IManageReservationsPage 
{
	/**
	 * @var \ManageReservationsPresenter
	 */
	private $presenter;

	public function __construct()
	{
	    parent::__construct('ManageReservations');

		$this->presenter = new ManageReservationsPresenter($this, new ReservationViewRepository());
	}
	
	public function ProcessAction()
	{
		// TODO: Implement ProcessAction() method.
	}

	public function PageLoad()
	{
		$userTimezone = $this->server->GetUserSession()->Timezone;
		$this->presenter->PageLoad($userTimezone);

		$this->Display('manage_reservations.tpl');
	}

	public function BindReservations($reservations)
	{
		$this->Set('reservations', $reservations);
	}

	/**
	 * @param PageInfo $pageInfo
	 * @return void
	 */
	public function SetPageInfo($pageInfo)
	{
		$this->Set('PageInfo', $pageInfo);
	}

	/**
	 * @return string
	 */
	public function GetStartDate()
	{
		return $this->server->GetQuerystring(QueryStringKeys::START_DATE);
	}

	/**
	 * @return string
	 */
	public function GetEndDate()
	{
		return $this->server->GetQuerystring(QueryStringKeys::END_DATE);
	}

	/**
	 * @param Date $date
	 * @return void
	 */
	public function SetStartDate($date)
	{
		$this->Set('StartDate', $date);
	}

	/**
	 * @param Date $date
	 * @return void
	 */
	public function SetEndDate($date)
	{
		$this->Set('EndDate', $date);
	}
}
?>
