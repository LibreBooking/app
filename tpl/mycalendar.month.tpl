{include file='globalheader.tpl' cssFiles='css/calendar.css'}

<div class="calendarHeading">

	<div style="float:left;">
		<a href="{$PrevLink}"><img src="img/arrow_large_left.png" alt="Back" /></a>
		{$MonthName} {$DisplayDate->Year()}
		<a href="{$NextLink}"><img src="img/arrow_large_right.png" alt="Forward" /></a>
	</div>

	<div style="float:right;">
		<a href="{CalendarUrl::Create($Today, CalendarTypes::Month)}" alt="Today" title="Today">{html_image src="calendar-day.png"}</a>
	</div>

	<div class="clear">&nbsp;</div>

</div>

<table class="monthCalendar">
	<tr class="dayName">
		<th style="width:5px;">&nbsp;</th>
		{foreach from=$HeaderLabels item=label}
			<th>{$label}</th>
		{/foreach}
	</tr>
{foreach from=$Calendar->Weeks() item=week}
	<tr>
		<td class="week" url="{CalendarUrl::Create($week->FirstDay(), CalendarTypes::Week)}"></td>
		{foreach from=$week->Days() item=day}
			{assign var=class value='day'}

			{if $day->IsHighlighted()}
				{assign var=class value='today'}
			{/if}

			{if $day->IsUnimportant()}
				{assign var=class value='unimportant'}
			{/if}

			<td class="{$class}" url="{CalendarUrl::Create($day->Date(), CalendarTypes::Day)}">
				<h3>{$day->DayOfMonth()}</h3>

				{foreach from=$day->Reservations() item=reservation}
					<div>
						<a href="{Pages::RESERVATION}?{QueryStringKeys::REFERENCE_NUMBER}={$reservation->ReferenceNumber}">
							{formatdate key='period_time' date=$day->GetAdjustedStartDate($reservation)} {$reservation->ResourceName}
						</a>
					</div>
				{/foreach}
			</td>
		{/foreach}
	</tr>
{/foreach}
</table>

<script type="text/javascript" src="scripts/calendar.js"></script>
<script type="text/javascript">
$(document).ready(function() {

	var calendar = new Calendar();
	calendar.init();

});
</script>

{include file='globalfooter.tpl'}