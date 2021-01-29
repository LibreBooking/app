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
<p>Η κράτησή σας πλησιάζει σύντομα στο τέλος της.</p>
<p><strong>Πληροφορίες κράτησης:</strong></p>

<p>
	<strong>Έναρξη:</strong> {formatdate date=$StartDate key=reservation_email}<br/>
	<strong>Λήξη:</strong> {formatdate date=$EndDate key=reservation_email}<br/>
	<strong>Πόρος:</strong> {$ResourceName}<br/>
	<strong>Τίτλος:</strong> {$Title}<br/>
	<strong>Περιγραφή:</strong> {$Description|nl2br}
</p>

<p>

	<a href="{$ScriptUrl}/{$ReservationUrl}">Δείτε την κράτηση</a> |
	<a href="{$ScriptUrl}/{$ICalUrl}">Προσθήκη στο Ημερολόγιο</a> |
	<a href="{$ScriptUrl}">Κάντε είσοδο στο {$AppTitle}</a>
</p>
