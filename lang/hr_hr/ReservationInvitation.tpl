{*
Copyright 2011-2015 Nick Korbel

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

	Detalji o rezervaciji:
	<br/>
	<br/>

	Pocetak: {formatdate date=$StartDate key=reservation_email}<br/>
	Kraj: {formatdate date=$EndDate key=reservation_email}<br/>
	{if $ResourceNames|count > 1}
		Tereni:<br/>
		{foreach from=$ResourceNames item=resourceName}
			{$resourceName}<br/>
		{/foreach}
		{else}
		Tereni: {$ResourceName}<br/>
	{/if}

	{if $ResourceImage}
		<div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
	{/if}

	Naziv: {$Title}<br/>
	Opis: {$Description|nl2br}<br/>

	{if count($RepeatDates) gt 0}
		<br/>
		Rezervacija va�i za navedeni datum:
		<br/>
	{/if}

	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $Accessories|count > 0}
		<br/>Dodatno:<br/>
		{foreach from=$Accessories item=accessory}
			({$accessory->QuantityReserved}) {$accessory->Name}<br/>
		{/foreach}
	{/if}

	{if $RequiresApproval}
		<br/>
		Jedan ili vi�e terena zahtijevaju odobrenje prije upotrebe. Ova rezervacija ce biti zadr�ana do dozvole.
	{/if}

	<br/>
	Attending? <a href="{$ScriptUrl}/{$AcceptUrl}">Da</a> <a href="{$ScriptUrl}/{$DeclineUrl}">Ne</a>
	<br/>
	<br/>

	<a href="{$ScriptUrl}/{$ReservationUrl}">Pregledaj rezervaciju</a> |
	<a href="{$ScriptUrl}/{$ICalUrl}">Dodaj u kalendar</a> |
	<a href="{$ScriptUrl}">Ulogiraj se</a>

