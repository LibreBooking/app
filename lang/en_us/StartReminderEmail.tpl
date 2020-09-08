{*
Copyright 2013-2020 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*}
<p>Your reservation is starting soon.</p>
<p><strong>Reservation Details:</strong></p>
<p>
	<strong>Start:</strong> {formatdate date=$StartDate key=reservation_email}<br/>
	<strong>End:</strong> {formatdate date=$EndDate key=reservation_email}<br/>
	<strong>Resource:</strong> {$ResourceName}<br/>
	<strong>Title:</strong> {$Title}<br/>
	<strong>Description:</strong> {$Description|nl2br}
</p>

<p>
	<a href="{$ScriptUrl}/{$ReservationUrl}">View this reservation</a> |
	<a href="{$ScriptUrl}/{$ICalUrl}">Add to Calendar</a> |
	<a href="{$ScriptUrl}">Log in to {$AppTitle}</a>
</p>