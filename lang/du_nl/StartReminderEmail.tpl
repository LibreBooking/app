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

Je reservering start binnenkort.<br/>
Reserverings Details:
	<br/>
	<br/>
	Start: {formatdate date=$StartDate key=reservation_email}<br/>
	Eindigd: {formatdate date=$EndDate key=reservation_email}<br/>
	Bron: {$ResourceName}<br/>
	Titel: {$Title}<br/>
	Beschrijving: {$Description|nl2br}<br/>
<br/>
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">Bekijk deze reservering</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">Voeg toe aan agenda</a> |
<a href="{$ScriptUrl}">Login in Booked Scheduler</a>

