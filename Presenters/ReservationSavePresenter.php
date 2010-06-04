<?php 
require_once(ROOT_DIR . 'lib/Config/namespace.php');
require_once(ROOT_DIR . 'lib/Server/namespace.php');
require_once(ROOT_DIR . 'lib/Common/namespace.php');
require_once(ROOT_DIR . 'lib/Domain/namespace.php');
require_once(ROOT_DIR . 'lib/Domain/Access/namespace.php');

class ReservationSavePresenter
{
	/**
	 * @var IReservationSavePage
	 */
	private $_page;
	
	public function __construct(IReservationSavePage $page)
	{
		$this->_page = $page;
	}
	
	public function PageLoad()
	{
		$this->_page->SetSaveSuccessfulMessage(true);
	}
}

interface IReservationValidationResult
{
	/**
	 * @return bool
	 */
	public function CanBeSaved();
	
	public function GetErrors();
	
	public function GetWarnings(); 
}

class ReservationValidResult implements IReservationValidationResult
{
	public function CanBeSaved()
	{
		return true;
	}
	
	public function GetErrors()
	{
		throw new Exception("Not implemented");
	}
	
	public function GetWarnings()
	{
		throw new Exception("Not implemented");
	}
}
?>