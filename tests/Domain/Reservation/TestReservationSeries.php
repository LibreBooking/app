<?php
require_once ROOT_DIR . '/Domain/namespace.php';

class TestReservationSeries extends ReservationSeries
{
	public function __construct()
	{
		parent::__construct();
		$this->_bookedBy = new FakeUserSession();
	}
	
	public function WithOwnerId($ownerId)
	{
		$this->_userId = $ownerId;
	}
	
	public function WithResource(BookableResource $resource)
	{
		$this->_resource = $resource;
	}
	
	public function WithDuration(DateRange $duration)
	{
		$this->UpdateDuration($duration);
	}
	
	public function WithRepeatOptions(IRepeatOptions $repeatOptions)
	{
		$this->Repeats($repeatOptions);
	}
	
	public function WithCurrentInstance(Reservation $currentInstance)
	{
		$this->SetCurrentInstance($currentInstance);
		$this->AddInstance($currentInstance);
	}
}
?>