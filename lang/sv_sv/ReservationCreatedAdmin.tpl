{*
Copyright 2011-2020 Nick Korbel

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


	Bokningsdetaljer:
	<br/>
	<br/>

	Användare: {$UserName}
	Er bokning startar: {formatdate date=$StartDate key=reservation_email}<br/>
	Er Bokning slutar: {formatdate date=$EndDate key=reservation_email}<br/>
	Bokning av: {$ResourceName}<br/>

	{if $ResourceImage}
		<div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
	{/if}

	Rubrik: {$Title}<br/>
	Beskrivning: {$Description}<br/>

	{if count($RepeatDates) gt 0}
		<br/>
		Bokning har gjorts följande tid / er:
		<br/>
	{/if}

	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $RequiresApproval}
		<br/>
		Er bokningen behöver godkännas innan den börjar gälla.  Vi ber er därför att kontrollera om denna bokning är godkänd eller inte.
	{/if}

	<br/>
	<a href="{$ScriptUrl}{$ReservationUrl}">Visa Bokning</a> | <a href="{$ScriptUrl}">Logga in i Bokningsprogrammet</a>

