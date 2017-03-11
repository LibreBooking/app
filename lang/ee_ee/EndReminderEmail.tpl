{*
Copyright 2013-2016 Nick Korbel

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
Sinu broneering lõpeb varsti.<br/>
Broneeringu detailid:
	<br/>
	<br/>
	Algus: {formatdate date=$StartDate key=reservation_email}<br/>
	Lõpp: {formatdate date=$EndDate key=reservation_email}<br/>
	Väljak: {$ResourceName}<br/>
	Pealkiri: {$Title}<br/>
	Kirjeldus: {$Description|nl2br}
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">Vaata seda broneeringut</a> |
<a href="{$ScriptUrl}/{$ICalUrl}">Lisa kalendrisse</a> |
<a href="{$ScriptUrl}">Logi sisse Rannahalli kalendrisse</a>