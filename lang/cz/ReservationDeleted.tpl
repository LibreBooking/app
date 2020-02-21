{*
Copyright 2011-2020 Nick Korbel

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
	Administrátorem byly smazány tyto rezervace:
	<br/>
	<br/>
	
	Uživatel: {$UserName}<br/>
	Začátek: {formatdate date=$StartDate key=reservation_email}<br/>
	Konec: {formatdate date=$EndDate key=reservation_email}<br/>
	{if $ResourceNames|count > 1}
	Zdroje:<br/>
		{foreach from=$ResourceNames item=resourceName}
			{$resourceName}<br/>
		{/foreach}
		{else}
    Zdroj: {$ResourceName}<br/>
	{/if}

	{if $ResourceImage}
		<div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
	{/if}

	Nadpis: {$Title}<br/>
	Popis: {$Description|nl2br}<br/>
{$DeleteReason|nl2br}<br/>

	
	
	{if count($RepeatDates) gt 0}
		<br/>
		Došlo ke smazání všech těchto rezervovaných termínů:
		<br/>
	{/if}
	
	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $Accessories|count > 0}
		<br/>Příslušenství:<br/>
		{foreach from=$Accessories item=accessory}
			({$accessory->QuantityReserved}) {$accessory->Name}<br/>
		{/foreach}
	{/if}

	<br/>
        <br/>
	<a href="{$ScriptUrl}">Přihlásit se do rezervačního systému</a>