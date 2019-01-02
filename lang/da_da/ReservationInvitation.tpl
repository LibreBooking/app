{*
Copyright 2011-2019 Nick Korbel

This file is part of Booked SchedulerBooked SchedulereIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later versBooked SchedulerduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
alBooked SchedulercheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*}

	Reservationsdetaljer:
	<br/>
	<br/>

	Reservationen starter: {formatdate date=$StartDate key=reservation_email}<br/>
	Reservationen slutter: {formatdate date=$EndDate key=reservation_email}<br/>
	Reservation: {$ResourceName}<br/>

	{if $ResourceImage}
		<div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
	{/if}

	Titel: {$Title}<br/>
	Beskrivelse: {$Description|nl2br}<br/>

	{if count($RepeatDates) gt 0}
		<br/>
		Reservationer foretaget på følgende datoer:
		<br/>
	{/if}

	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $RequiresApproval}
		<br/>
		Denne booking skal godkendes, før den træder i kraft. Denne reservation er reserveret når den er godkendt.
	{/if}

	<br/>
	Deltager? <a href="{$ScriptUrl}/{$AcceptUrl}">Ja</a> <a href="{$ScriptUrl}/{$DeclineUrl}">Nej</a>
	<br/>

	<a href="{$ScriptUrl}/{$ReservationUrl}">Vis denne reservationer</a> |
	<a href="{$ScriptUrl}/{$ICalUrl}">Føj til Outlook</a> |
	<a href="{$ScriptUrl}">Log ind i Bookning</a>
å
