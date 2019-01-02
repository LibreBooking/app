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
Reservation Details:
<br/>
<br/>

User: {$UserName}<br/>
{if !empty($CreatedBy)}
	Created by: {$CreatedBy}
	<br/>
{/if}
Starting: {formatdate date=$StartDate key=reservation_email}<br/>
Ending: {formatdate date=$EndDate key=reservation_email}<br/>
{if $ResourceNames|count > 1}
	Resources:
	<br/>
	{foreach from=$ResourceNames item=resourceName}
		{$resourceName}
		<br/>
	{/foreach}
{else}
	Resource: {$ResourceName}
	<br/>
{/if}

{if $ResourceImage}
	<div class="resource-image"><img src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}

Title: {$Title}<br/>
Description: {$Description|nl2br}

{if count($RepeatRanges) gt 0}
    <br/>
    The reservation occurs on the following dates:
    <br/>
{/if}

{foreach from=$RepeatRanges item=date name=dates}
    {formatdate date=$date->GetBegin()}
    {if !$date->IsSameDate()} - {formatdate date=$date->GetEnd()}{/if}
    <br/>
{/foreach}

{if $Accessories|count > 0}
	<br/>
	Accessories:
	<br/>
	{foreach from=$Accessories item=accessory}
		({$accessory->QuantityReserved}) {$accessory->Name}
		<br/>
	{/foreach}
{/if}

{if $Attributes|count > 0}
	<br/>
	{foreach from=$Attributes item=attribute}
		<div>{control type="AttributeControl" attribute=$attribute readonly=true}</div>
	{/foreach}
{/if}

{if $RequiresApproval}
	<br/>
	At least one of the resources reserved requires approval before usage. Please ensure that this reservation request is approved or rejected.
{/if}

{if $CheckInEnabled}
	<br/>
	At least one of the resources reserved requires that the user check in and out of the reservation.
	{if $AutoReleaseMinutes != null}
		This reservation will be cancelled unless the user checks in within {$AutoReleaseMinutes} minutes after the scheduled start time.
	{/if}
{/if}

<br/>
Reference Number: {$ReferenceNumber}

<br/>
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">View this reservation</a> | <a href="{$ScriptUrl}">Log in to Booked Scheduler</a>