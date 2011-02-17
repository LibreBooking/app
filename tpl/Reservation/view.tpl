{include file='globalheader.tpl' DisplayWelcome='false' TitleKey='ViewReservation'}
<style type="text/css">
	@import url({$Path}css/reservation.css);
</style>
<a href="{$ReturnUrl}">&lt; {translate key="BackToCalendar"}</a><br/>

User: {$UserName} <br/>

Resources: {$ResourceName} <br/>
{foreach from=$AvailableResources item=resource}
	{if is_array($AdditionalResourceIds) && in_array($resource->Id(), $AdditionalResourceIds)}
		{$resource->Name()}<br/>
	{/if}
{/foreach}

Start:{formatdate date=$StartDate}
{foreach from=$Periods item=period}
	{if $period->Begin()->Equals($StartTime)}
		{$period->Label()} <br/>
	{/if}
{/foreach}

End: {formatdate date=$EndDate}
{foreach from=$Periods item=period}
	{if $period->Begin()->Equals($EndTime)}
		{$period->Label()} <br/>
	{/if}
{/foreach}

Repeats: repeatType: '{$RepeatType}',
		repeatInterval: '{$RepeatInterval}',
		repeatMonthlyType: '{$RepeatMonthlyType}',
		repeatWeekdays: [{foreach from=$RepeatWeekdays item=day}$day,{/foreach}],

<br/>			
Title: {$ReservationTitle}<br/>

Description: {$Description|nl2br}<br/>

Participants:
{foreach from=$ParticipantListOutput item=participant}
	{$participant}<br/>
{/foreach}
<br/>

Invitees: 
{foreach from=$InvitationListOutput item=invitee}
	{$invitee}<br/>
{/foreach}
<br/>

<input type="button" value="{translate key='Close'}" class="button" onclick="window.location='{$ReturnUrl}'"></input>
{include file='globalfooter.tpl'}