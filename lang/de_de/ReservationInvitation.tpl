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
	Reservierungsdetails:
	<br/>
	<br/>
	
	Beginn: {formatdate date=$StartDate key=reservation_email}<br/>
	Ende: {formatdate date=$EndDate key=reservation_email}<br/>
	{if $ResourceNames|count > 1}
		Ressourcen:<br/>
		{foreach from=$ResourceNames item=resourceName}
			{$resourceName}<br/>
		{/foreach}
		{else}
		Ressource: {$ResourceName}<br/>
	{/if}
	Titel: {$Title}<br/>
	Beschreibung: {$Description|nl2br}<br/>
	
	{if count($RepeatDates) gt 0}
		<br/>
		Die Reservierung gilt für den/die folgenden Tag(e):
		<br/>
	{/if}
	
	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $Accessories|count > 0}
		<br/>Zubehör:<br/>
		{foreach from=$Accessories item=accessory}
			({$accessory->QuantityReserved}) {$accessory->Name}<br/>
		{/foreach}
	{/if}

	{if $RequiresApproval}
		<br/>
		Eine oder mehrere Ressourcen benötigen eine Genehmigung.  Diese Reservierung wird zur&uuml;ckgehalten, bis sie genehmigt ist.
	{/if}
	
	<br/>
	Teilnehmen? <a href="{$ScriptUrl}/{$AcceptUrl}">Ja</a> <a href="{$ScriptUrl}/{$DeclineUrl}">Nein</a>
	<br/>

	<a href="{$ScriptUrl}/{$ReservationUrl}">Reservierung ansehen</a> |
	<a href="{$ScriptUrl}/{$ICalUrl}">Zum Kalender hinzufügen</a> |
	<a href="{$ScriptUrl}">Anmelden bei phpScheduleIt</a>
	
{include file='..\..\tpl\Email\emailfooter.tpl'}