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
		/** @var $slot IReservationSlot */
		$slot = $this->Get('Slot');
		$accessAllowed = $this->Get('AccessAllowed');

		$slot->IsPending();
		if ($slot->IsReserved())
		{
			if ($this->IsMyReservation($slot))
			{
				$this->Display('Controls/MyReservedSlot.tpl');
			}
			else
			{
				$this->Display('Controls/ReservedSlot.tpl');
			}
		}
		else if (!$accessAllowed)
		{
			$this->Display('Controls/RestrictedSlot.tpl');
		}
		else if ($slot->IsPastDate(Date::Now()) && !$this->UserHasAdminRights())
		{
			$this->Display('Controls/PastTimeSlot.tpl');
		}
		else if ($slot->IsReservable())
		{
			$this->Display('Controls/ReservableSlot.tpl');
		}
		else
		{
			$this->Display('Controls/UnreservableSlot.tpl');
		}
	}
	
	private function UserHasAdminRights()
	{
		return ServiceLocator::GetServer()->GetUserSession()->IsAdmin;
	}
	
	private function IsMyReservation(IReservationSlot $slot)
	{
		$mySession = ServiceLocator::GetServer()->GetUserSession();
		return $slot->IsOwnedBy($mySession);
	}
}
?>