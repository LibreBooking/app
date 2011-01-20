<?php 
require_once(ROOT_DIR . 'Pages/SecurePage.php');
require_once(ROOT_DIR . 'Presenters/SchedulePresenter.php');
require_once(ROOT_DIR . 'Domain/Access/namespace.php');

class ReservationPopupPage extends Page implements IReservationPopupPage
{
	/**
	 * @var ReservationPopupPresenter
	 */
	private $_presenter;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->_presenter = new ReservationPopupPresenter($this, 
		new ReservationViewRepository());
	}
	
	public function PageLoad()
	{
		if (!$this->IsAuthenticated())
		{
			$this->smarty->assign('authorized', true);
			//TODO: Update this after development
		}
		else
		{
			$this->smarty->assign('authorized', true);
			$this->_presenter->PageLoad();
		}
		
		$this->smarty->assign('ReservationId', $this->GetReservationId());
		
		$this->smarty->display('Ajax/respopup.tpl');		
	}
	
	/**
	 * @return string
	 */
	function GetReservationId()
	{
		return $this->server->GetQuerystring('id');
	}
	
	function SetName($first, $last)
	{
		$this->smarty->assign('fname', $first);
		$this->smarty->assign('lname', $last);
	}
	
	function SetSummary($summary)
	{
		$this->smarty->assign('summary', $summary);
	}
	
	function SetDates($startDate, $endDate)
	{
		$this->smarty->assign('startDate', $startDate);
		$this->smarty->assign('endDate', $endDate);
	}
}

interface IReservationPopupPage
{
	/**
	 * @return string
	 */
	function GetReservationId();
	
	/**
	 * @param $first string
	 * @param $last string
	 */
	function SetName($first, $last);
	
	/**
	 * @param $summary string
	 */
	function SetSummary($summary);
	
	/**
	 * @param $startDate Date
	 * @param $endDate Date
	 */
	function SetDates($startDate, $endDate);
}

class ReservationPopupPresenter
{
	/**
	 * @var IReservationPopupPage
	 */
	private $_page;
	
	/*
	 * @var IReservationViewRepository
	 */
	private $_reservationRepository;
	 
	public function __construct(IReservationPopupPage $page, IReservationViewRepository $reservationRepository)
	{
		$this->_page = $page;
		$this->_reservationRepository = $reservationRepository;
	}
	
	public function PageLoad()
	{
		$reservation = $this->_reservationRepository->GetReservationForEditing($this->_page->GetReservationId());
		$startDate = $reservation->StartDate->ToTimezone('America/Chicago');
		$endDate = $reservation->EndDate->ToTimezone('America/Chicago');
		
		$this->_page->SetName('first', 'last');
		$this->_page->SetSummary($reservation->Description);
		
		$this->_page->SetDates($startDate, $endDate);
		
	}
}
?>