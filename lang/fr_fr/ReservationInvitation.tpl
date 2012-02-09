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
	Details de la réservation:
	<br/>
	<br/>
	
	Début: {formatdate date=$StartDate key=reservation_email}<br/>
	Fin: {formatdate date=$EndDate key=reservation_email}<br/>
	Libellé: {$Title}<br/>
	Description: {$Description|nl2br}<br/>
	
	{if count($RepeatDates) gt 0}
		<br/>
		La réservation se répète aux dates suivantes:
		<br/>
	{/if}
	
	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $RequiresApproval}
		<br/>
		Une ou plusieurs ressources réservées nécessitent une approbation. Cette réservation sera donc provisoirement mise en attente puis un administrateur la validera (ou non)
	{/if}
	
	<br/>
	Confirmer votre présence? <a href="{$ScriptUrl}/{$AcceptUrl}">Oui</a> <a href="{$ScriptUrl}/{$DeclineUrl}">Non</a>
	<br/>

	<a href="{$ScriptUrl}/{$ReservationUrl}">Voir cette réservation</a> |
	<a href="{$ScriptUrl}/{$ICalUrl}">Ajouter à Outlook</a> |
	<a href="{$ScriptUrl}">Connexion à phpScheduleIt</a>
	
{include file='..\..\tpl\Email\emailfooter.tpl'}
