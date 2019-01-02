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

	פרטי ההזמנה:
	<br/>
	<br/>

	התחלה: {formatdate date=$StartDate key=reservation_email}<br/>
	סיום: {formatdate date=$EndDate key=reservation_email}<br/>
	{if $ResourceNames|count > 1}
		משאבים:<br/>
		{foreach from=$ResourceNames item=resourceName}
			{$resourceName}<br/>
		{/foreach}
		{else}
		משאב: {$ResourceName}<br/>
	{/if}
	כותר: {$Title}<br/>
	תאור: {$Description|nl2br}<br/>

	{if count($RepeatDates) gt 0}
		<br/>
		ההזמנה מתקיימת בתאריכים הבאים:
		<br/>
	{/if}

	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $Accessories|count > 0}
		<br/>משאבים:<br/>
		{foreach from=$Accessories item=accessory}
			({$accessory->QuantityReserved}) {$accessory->Name}<br/>
		{/foreach}
	{/if}

	{if $RequiresApproval}
		<br/>
                אחד או יותר מהמשאבים המבוקשים דורש אישור. ההזמנה במצב המתנה עד שתאושר.
	{/if}

	<br/>
	משתתף? <a href="{$ScriptUrl}/{$AcceptUrl}">כן</a> <a href="{$ScriptUrl}/{$DeclineUrl}">לא</a>
	<br/>

	<a href="{$ScriptUrl}/{$ReservationUrl}">לצפות בהזמנה זו</a> |
	<a href="{$ScriptUrl}/{$ICalUrl}">להוסיף ללוח אישי בדואר אלקרוני</a> |
	<a href="{$ScriptUrl}">להתחבר ל-Booked Scheduler</a>


