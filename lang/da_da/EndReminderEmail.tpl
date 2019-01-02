{*
Copyright 2013-2019 Nick Korbel

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
Din reservation slutter snart.<br/>
Reservationsdetaljer:
	<br/>
	<br/>
	Starter: {formatdate date=$StartDate key=reservation_email}<br/>
	Slutter: {formatdate date=$EndDate key=reservation_email}<br/>
	Resource: {$ResourceName}<br/>
	Title: {$Title}<br/>
	Beskrivelse: {$Description|nl2br}
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">Vis reservationer</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">F�j til kalender</a> |
<a href="{$ScriptUrl}">Log ind p� Booked</a>