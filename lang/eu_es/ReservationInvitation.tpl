{*
Copyright 2011-2019 Nick Korbel

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
	Erreserbaren xehetasunak:
	<br/>
	<br/>

	Hasiera: {formatdate date=$StartDate key=reservation_email}<br/>
	Amaiera: {formatdate date=$EndDate key=reservation_email}<br/>
	{if $ResourceNames|count > 1}
		Baliabideak:<br/>
		{foreach from=$ResourceNames item=resourceName}
			{$resourceName}<br/>
		{/foreach}
		{else}
		Baliabidea: {$ResourceName}<br/>
	{/if}

	{if $ResourceImage}
		<div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
	{/if}

	Izenburua: {$Title}<br/>
	Deskripzioa: {$Description|nl2br}<br/>

	{if count($RepeatDates) gt 0}
		<br/>
		Erreserba data hauetarako da:
		<br/>
	{/if}

	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $Accessories|count > 0}
		<br/>Osagarriak:<br/>
		{foreach from=$Accessories item=accessory}
			({$accessory->QuantityReserved}) {$accessory->Name}<br/>
		{/foreach}
	{/if}

	{if $RequiresApproval}
		<br/>
		Erreserbatutako baliabideetako bat onartua izan behar du erabilia izan baino lehen. Erreserba hau zain geratuko da onartu arte.
	{/if}

	<br/>
	Bertaratuko? <a href="{$ScriptUrl}/{$AcceptUrl}">Bai</a> <a href="{$ScriptUrl}/{$DeclineUrl}">Ez</a>
	<br/>
	<br/>

	<a href="{$ScriptUrl}/{$ReservationUrl}">Erreserba hau ikusi</a> |
	<a href="{$ScriptUrl}/{$ICalUrl}">Egutegi batera gehitu</a> |
	<a href="{$ScriptUrl}">Saioa hasi Booked Scheduler-en</a>
