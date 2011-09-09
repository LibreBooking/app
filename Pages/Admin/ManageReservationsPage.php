<?php

class ManageReservationsPage extends AdminPage
{
	/**
	 * @var \ManageReservationsPresenter
	 */
	private $presenter;

	public function __construct()
	{
	    parent::__construct('ManageReservations');

		$this->presenter = new ManageReservationsPresenter();
	}
	
	public function ProcessAction()
	{
		// TODO: Implement ProcessAction() method.
	}

	public function PageLoad()
	{
		$this->presenter->PageLoad();

		$this->Display('manage_reservations.tpl');
	}
}
?>
