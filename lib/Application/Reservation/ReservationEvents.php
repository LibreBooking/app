<?php
/**
Copyright 2011-2020 Nick Korbel

This file is part of Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*/

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
