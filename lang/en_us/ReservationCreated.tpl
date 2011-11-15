{include file='..\tpl\Email\emailheader.tpl'}
	
	Reservation Details:
	<br/>
	<br/>
	
	Starting: {formatdate date=$StartDate key=reservation_email}<br/>
	Ending: {formatdate date=$EndDate key=reservation_email}<br/>
	Title: {$Title}<br/>
	Description: {$Description|nl2br}<br/>
	
	{if count($RepeatDates) gt 0}
		<br/>
		The reservation repeats on the following dates:
		<br/>
	{/if}
	
	{foreach from=$RepeatDates item=date name=dates}
		{formatdate date=$date}<br/>
	{/foreach}

	{if $RequiresApproval}
		<br/>
		One or more of the resources reserved require approval before usage.  This reservation will be pending until it is approved.
	{/if}
	
	<br/>
	<a href="{$ScriptUrl}{$ReservationUrl}">View this reservation</a> |
	<a href="{$ScriptUrl}{$ICalUrl}">Add to Outlook</a> |
	<a href="{$ScriptUrl}">Log in to phpScheduleIt</a>
	
{include file='..\tpl\Email\emailfooter.tpl'}