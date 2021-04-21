<p><strong>Reservation Details:</strong></p>

<p>
	<strong>User:</strong> {$UserName}<br/>
    {if !empty($CreatedBy)}
		<strong>Created by:</strong>
        {$CreatedBy}
		<br/>
    {/if}
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
		<strong>Resources:</strong>
		<br/>
        {foreach from=$ResourceNames item=resourceName}
            {$resourceName}
			<br/>
        {/foreach}
    {else}
		<strong>Resource:</strong>
        {$ResourceName}
    {/if}
</p>

{if $ResourceImage}
	<div class="resource-image"><img alt="{$ResourceName}" src="{$ScriptUrl}/{$ResourceImage}"/></div>
{/if}


{if $RequiresApproval}
	<p>* At least one of the resources reserved requires approval before usage. Please ensure that this reservation request is approved or rejected. *</p>
{/if}

{if $CheckInEnabled}
	<p>
		At least one of the resources reserved requires that the user check in and out of the reservation.
        {if $AutoReleaseMinutes != null}
			This reservation will be cancelled unless the user checks in within {$AutoReleaseMinutes} minutes after the scheduled start time.
        {/if}
	</p>
{/if}

{if count($RepeatRanges) gt 0}
	<p>
		The reservation occurs on the following dates ({$RepeatRanges|count}):
		<br/>
        {foreach from=$RepeatRanges item=date name=dates}
            {formatdate date=$date->GetBegin()}
            {if !$date->IsSameDate()} - {formatdate date=$date->GetEnd()}{/if}
			<br/>
        {/foreach}
	</p>
{/if}

{if $Participants|count >0}
	<br/>
	<strong>Participants ({$Participants|count + $ParticipatingGuests|count}):</strong>
	<br/>
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
	<br/>
	<strong>Invitees ({$Invitees|count + $InvitedGuests|count}):</strong>
	<br/>
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
	<br/>
	<strong>Accessories ({$Accessories|count}):</strong>
	<br/>
    {foreach from=$Accessories item=accessory}
		({$accessory->QuantityReserved}) {$accessory->Name}
		<br/>
    {/foreach}
{/if}

<p><strong>Reference Number:</strong> {$ReferenceNumber}</p>

<p>
	<a href="{$ScriptUrl}/{$ReservationUrl}">View this reservation</a> | <a href="{$ScriptUrl}">Log in to {$AppTitle}</a>
</p>
