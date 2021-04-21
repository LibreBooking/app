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
	const Deleted = 'deleted';
    const SeriesEnding = 'series_ending';
    const ParticipationChanged = 'participation_changed';

    /**
	 * @static
	 * @return array|IDomainEvent[]
	 */
	public static function AllEvents()
	{
		return array(
			new ReservationApprovedEvent(),
			new ReservationCreatedEvent(),
			new ReservationUpdatedEvent(),
			new ReservationDeletedEvent(),
            new ReservationSeriesEndingEvent(),
            new ParticipationChangedEvent(),
		);
	}
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

class ReservationDeletedEvent implements IDomainEvent
{
	public function EventType()
	{
		return ReservationEvent::Deleted;
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

class ReservationSeriesEndingEvent implements IDomainEvent
{
	public function EventType()
	{
		return ReservationEvent::SeriesEnding;
	}

	public function EventCategory()
	{
		return EventCategory::Reservation;
	}
}

class ParticipationChangedEvent implements IDomainEvent
{
    public function EventType()
    {
        return ReservationEvent::ParticipationChanged;
    }

    public function EventCategory()
    {
        return EventCategory::Reservation;
    }
}
