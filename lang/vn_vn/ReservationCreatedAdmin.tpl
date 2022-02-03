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
{if $ResourceNames|default:array()|count > 1}
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

{if count($RepeatDates) gt 0}
	<br/>
	The reservation occurs on the following dates:
	<br/>
{/if}

{foreach from=$RepeatDates item=date name=dates}
	{formatdate date=$date}
	<br/>
{/foreach}

{if $Accessories|default:array()|count > 0}
	<br/>
	Accessories:
	<br/>
	{foreach from=$Accessories item=accessory}
		({$accessory->QuantityReserved}) {$accessory->Name}
		<br/>
	{/foreach}
{/if}

{if $Attributes|default:array()|count > 0}
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
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">View this reservation</a> | <a href="{$ScriptUrl}">Log in to LibreBooking</a>
