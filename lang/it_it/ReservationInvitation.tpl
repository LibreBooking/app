{*
Copyright 2011-2012 Nick Korbel

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
	Dettagli Prenotazione:
	<br/>
	<br/>
	
	Inizio: {formatdate date=$StartDate key=reservation_email}<br/>
	Fine: {formatdate date=$EndDate key=reservation_email}<br/>
	Titolo: {$Title}<br/>
	Descrizione: {$Description|nl2br}<br/>
	
	{if count($RepeatDates) gt 0}
		<br/>
		La prenotazione si ripete nelle seguenti date:
		<br/>
	{/if}
	
	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $RequiresApproval}
		<br/>
		Una o più risorse prenotate richiedono approvazione prima dell\'utilizzo.  Questa prenotazione rimarrà pendente fino all\'approvazione.
	{/if}
	
	<br/>
	Partecipare? <a href="{$ScriptUrl}/{$AcceptUrl}">Yes</a> <a href="{$ScriptUrl}/{$DeclineUrl}">No</a>
	<br/>

	<a href="{$ScriptUrl}/{$ReservationUrl}">Vedi questa prenotazione</a> |
	<a href="{$ScriptUrl}/{$ICalUrl}">Aggiungi ad Outlook</a> |
	<a href="{$ScriptUrl}">Loggati in phpScheduleIt</a>
	
{include file='..\..\tpl\Email\emailfooter.tpl'}