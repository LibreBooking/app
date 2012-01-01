<?php
/**
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*/
 
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