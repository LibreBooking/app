<?php
class EventCategory
{
	const Reservation = 'reservation'; 
}

class ReservationEvent
{
	const Created = 'created';
	const Modified = 'modified';
}

class ReservationCreatedEvent implements IDomainEvent
{
	public function EventType()
	{
		return ReservationEvent::Created;
	}
	
	public function EventCategory()
	{
		return EventCategory::Reservation;
	}
}

interface IDomainEvent
{
	function EventType();
	function EventCategory();
}
?>