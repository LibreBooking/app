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
			if ($this->IsMyReservation($slot))
			{
				$this->smarty->display('Controls/MyReservedSlot.tpl');
			}
			else
			{
				$this->smarty->display('Controls/ReservedSlot.tpl');
			}
		}
		else if (!$accessAllowed)
		{
			$this->smarty->display('Controls/RestrictedSlot.tpl');
		}
		else if ($slot->IsPastDate(Date::Now()) && !$this->UserHasAdminRights())
		{
			$this->smarty->display('Controls/PastTimeSlot.tpl');
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
	
	private function UserHasAdminRights()
	{
		return ServiceLocator::GetServer()->GetUserSession()->IsAdmin;
	}
	
	private function IsMyReservation(ReservationSlot $slot)
	{
		$mySession = ServiceLocator::GetServer()->GetUserSession();
		return $slot->IsOwnedBy($mySession);
	}
}
?>