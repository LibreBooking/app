{*
Copyright 2011-2013 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*}
{include file='..\..\tpl\Email\emailheader.tpl'}
	Pozvánka do vytvořené rezervace:
	<br/>
	<br/>

	Nadpis: {$Title}<br/>
	Popis: {$Description|nl2br}<br/><br/>
	Začátek: {formatdate date=$StartDate key=reservation_email}<br/>
	Konec: {formatdate date=$EndDate key=reservation_email}<br/>
	{if $ResourceNames|count > 1}
	Prostředky:<br/>
		{foreach from=$ResourceNames item=resourceName}
			{$resourceName}<br/>
		{/foreach}
		{else}
    Prostředek: {$ResourceName}<br/>
	{/if}
	
	{if count($RepeatDates) gt 0}
		<br/>
		Byly rezervovány všechny tyto termíny:
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
	{if $RequiresApproval}
		<br/>
		Jedna nebo více rezervací vyžaduje schválení od administrátora. Do té doby bude Vaše rezervace ve stavu schvalování.
	{/if}
	
	<br/>
	Účastnit se? <a href="{$ScriptUrl}/{$AcceptUrl}">Ano</a> <a href="{$ScriptUrl}/{$DeclineUrl}">Ne</a>
	<br/>

	<a href="{$ScriptUrl}/{$ReservationUrl}">Zobrazit tuto rezrvaci v systému</a> |
	<a href="{$ScriptUrl}/{$ICalUrl}">Přidat do Outlook</a> |
	<a href="{$ScriptUrl}">Přihlásit se do rezervačního systému</a>
	
{include file='..\..\tpl\Email\emailfooter.tpl'}