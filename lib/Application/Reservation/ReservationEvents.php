<?php
require_once(ROOT_DIR . 'Domain/Events/IDomainEvent.php');

class EventCategory
{
	const Reservation = 'reservation'; 
}

class ReservationEvent
{
	const Approved = 'approved';
	const Created = 'created';
	const Updated = 'updated';
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

class ReservationUpdatedEvent implements IDomainEvent
{
	public function EventType()
	{
		return ReservationEvent::Updated;
	}
	
	public function EventCategory()
	{
		return EventCategory::Reservation;
	}
}

class ReservationApprovedEvent implements IDomainEvent
{
	public function EventType()
	{
		return ReservationEvent::Approved;
	}

	public function EventCategory()
	{
		return EventCategory::Reservation;
	}
}


?>