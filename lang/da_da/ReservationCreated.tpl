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
	Velkommen til 10 minuter før den bestille tid.<br/>

	Reservationen slutter: {formatdate date=$EndDate key=reservation_email}<br/>
	<br/>
	Reservationen: {$ResourceName}<br/>

	{if $ResourceImage}
		<div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
	{/if}

	<br/>
	Titel: {$Title}<br/>
	<br/>
	Beskrivelse: {$Description|nl2br}<br/>

	{if count($RepeatDates) gt 0}
		<br/>
		Du har reserveret følgende tidspunkt(er):
		<br/>
	{/if}

	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $RequiresApproval}
		<br/>
		Før en reservation bliver registreret skal den først godkendes.
	{/if}

	<br/>
	<a href="{$ScriptUrl}/{$ReservationUrl}">Vis reservation</a> |
	<a href="{$ScriptUrl}/{$ICalUrl}">Tilføj til Outlook</a> |
	<a href="{$ScriptUrl}">Log ind på Reservationsystemet</a>

