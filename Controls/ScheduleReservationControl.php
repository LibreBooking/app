<?php 
require_once(ROOT_DIR . 'Controls/Control.php');

class ScheduleReservationControl extends Control
{
	public function __construct(SmartyPage $smarty)
	{
		parent::__construct($smarty);
	}
	
	public function PageLoad()
	{
		/**
		 * @var IReservationSlot
		 */
		$slot = $this->Get('Slot');
		
		if ($slot->IsReservable())
		{
			$this->smarty->display('Controls/ReservableSlot.tpl');
		}
		else if($slot->IsReserved())
		{
			$this->smarty->display('Controls/ReservedSlot.tpl');
		}
		else
		{
			$this->smarty->display('Controls/UnreservableSlot.tpl');
		}
	}
}
?>