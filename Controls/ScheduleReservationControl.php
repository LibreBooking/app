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
		$slot = $this->Get('Slot');
		$accessAllowed = $this->Get('AccessAllowed');

		if ($slot->IsReserved())
		{
			$this->smarty->display('Controls/ReservedSlot.tpl');
		}
		else if (!$accessAllowed)
		{
			$this->smarty->display('Controls/RestrictedSlot.tpl');
		}
		else if ($slot->IsReservable())
		{
			$this->smarty->display('Controls/ReservableSlot.tpl');
		}
		else
		{
			$this->smarty->display('Controls/UnreservableSlot.tpl');
		}
	}
}
?>