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
	Резервационна информация:
	<br/>
	<br/>

	Потребител: {$UserName}
	Начало: {formatdate date=$StartDate key=reservation_email}<br/>
	Край: {formatdate date=$EndDate key=reservation_email}<br/>
	{if $ResourceNames|count > 1}
		Ресурси:<br/>
		{foreach from=$ResourceNames item=resourceName}
			{$resourceName}<br/>
		{/foreach}
		{else}
		Ресурс: {$ResourceName}<br/>
	{/if}

	{if $ResourceImage}
		<div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
	{/if}

	Заглавие: {$Title}<br/>
	Описание: {$Description}<br/>

	{if count($RepeatDates) gt 0}
		<br/>
		Резервацията се отнася за следните дати::
		<br/>
	{/if}

	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $Accessories|count > 0}
		<br/>Аксесоари:<br/>
		{foreach from=$Accessories item=accessory}
			({$accessory->QuantityReserved}) {$accessory->Name}<br/>
		{/foreach}
	{/if}

	{if $RequiresApproval}
		<br/>
		Един или повече от ресурсите изискват одобрение преди употреба.  Моля, убедете се, че тази заявка за резервация е одобрена или отхвърлена.
	{/if}

	<br/>
	<a href="{$ScriptUrl}/{$ReservationUrl}">Разгледай тази резервация</a> | <a href="{$ScriptUrl}">Влизане в Booked Scheduler</a>