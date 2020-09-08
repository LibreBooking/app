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
<p><strong>Reservation Details:</strong></p>

<p>
	<strong>Start:</strong> {formatdate date=$StartDate key=reservation_email}<br/>
	<strong>End:</strong> {formatdate date=$EndDate key=reservation_email}<br/>
	<strong>Title:</strong> {$Title}<br/>
	<strong>Description:</strong> {$Description|nl2br}
	{if $Attributes|count > 0}
		<br/>
	    {foreach from=$Attributes item=attribute}
			<div>{control type="AttributeControl" attribute=$attribute readonly=true}</div>
	    {/foreach}
	{/if}
</p>

<p>
{if $ResourceNames|count > 1}
    <strong>Resources ({$ResourceNames|count}):</strong> <br />
    {foreach from=$ResourceNames item=resourceName}
        {$resourceName}<br/>
    {/foreach}
{else}
    <strong>Resource:</strong> {$ResourceName}<br/>
{/if}
</p>

{if $ResourceImage}
    <div class="resource-image"><img alt="{$ResourceName|escape}" src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}

{if $RequiresApproval}
	<p>* At least one of the resources reserved requires approval before usage. This reservation will be pending until it is approved. *</p>
{/if}

{if $CheckInEnabled}
	<p>
	At least one of the resources reserved requires you to check in and out of your reservation.
    {if $AutoReleaseMinutes != null}
		This reservation will be cancelled unless you check in within {$AutoReleaseMinutes} minutes after the scheduled start time.
    {/if}
	</p>
{/if}

{if count($RepeatRanges) gt 0}
    <br/>
    <strong>The reservation occurs on the following dates ({$RepeatRanges|count}):</strong>
    <br/>
	{foreach from=$RepeatRanges item=date name=dates}
	    {formatdate date=$date->GetBegin()}
	    {if !$date->IsSameDate()} - {formatdate date=$date->GetEnd()}{/if}
	    <br/>
	{/foreach}
{/if}

{if $Participants|count >0}
    <br />
    <strong>Participants ({$Participants|count + $ParticipatingGuests|count}):</strong>
    <br />
    {foreach from=$Participants item=user}
        {$user->FullName()}
        <br/>
    {/foreach}
{/if}

{if $ParticipatingGuests|count >0}
    {foreach from=$ParticipatingGuests item=email}
        {$email}
        <br/>
    {/foreach}
{/if}

{if $Invitees|count >0}
    <br />
    <strong>Invitees ({$Invitees|count + $InvitedGuests|count}):</strong>
    <br />
    {foreach from=$Invitees item=user}
        {$user->FullName()}
        <br/>
    {/foreach}
{/if}

{if $InvitedGuests|count >0}
    {foreach from=$InvitedGuests item=email}
        {$email}
        <br/>
    {/foreach}
{/if}

{if $Accessories|count > 0}
    <br />
       <strong>Accessories ({$Accessories|count}):</strong>
       <br />
    {foreach from=$Accessories item=accessory}
        ({$accessory->QuantityReserved}) {$accessory->Name}
        <br/>
    {/foreach}
{/if}

{if $CreditsCurrent > 0}
	<br/>
	This reservation costs {$CreditsCurrent} credits.
    {if $CreditsCurrent != $CreditsTotal}
		This entire reservation series costs {$CreditsTotal} credits.
    {/if}
{/if}


{if !empty($CreatedBy)}
	<p><strong>Created by:</strong> {$CreatedBy}</p>
{/if}

{if !empty($ApprovedBy)}
	<p><strong>Approved by:</strong> {$ApprovedBy}</p>
{/if}

<p><strong>Reference Number:</strong> {$ReferenceNumber}</p>

{if !$Deleted}
	<a href="{$ScriptUrl}/{$ReservationUrl}">View this reservation</a>
	|
	<a href="{$ScriptUrl}/{$ICalUrl}">Add to Calendar</a>
	|
	<a href="{$GoogleCalendarUrl}" target="_blank" rel="nofollow">Add to Google Calendar</a>
	|
{/if}
<a href="{$ScriptUrl}">Log in to {$AppTitle}</a>

