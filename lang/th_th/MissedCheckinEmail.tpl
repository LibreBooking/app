You missed your check in.<br/>
Reservation Details:
	<br/>
	<br/>
	Start: {formatdate date=$StartDate key=reservation_email}<br/>
	End: {formatdate date=$EndDate key=reservation_email}<br/>
	Resource: {$ResourceName}<br/>
	Title: {$Title}<br/>
	Description: {$Description|nl2br}
    {if $IsAutoRelease}
        <br/>
        If you do not check in, this reservation will be automatically cancelled at {formatdate date=$AutoReleaseTime key=reservation_email}
    {/if}
<br/>
<br/>
<a href="{$ScriptUrl}/{$ReservationUrl}">View this reservation</a> |
<a href="{$ScriptUrl}">Log in to Booked Scheduler</a>
