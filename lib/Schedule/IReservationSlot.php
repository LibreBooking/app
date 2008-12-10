<?php

interface IReservationSlot
{
	public function Begin();
	public function End();
	public function PeriodSpan();	
}

?>