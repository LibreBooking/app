{include file='globalheader.tpl' cssFiles='css/calendar.css'}

<div class="calendarHeading">

	<div style="float:left;">
		<a href="{$PrevLink}"><img src="img/arrow_large_left.png" alt="Back" /></a>
		{$DayName}, {$MonthName} {$DisplayDate->Day()}, {$DisplayDate->Year()}
		<a href="{$NextLink}"><img src="img/arrow_large_right.png" alt="Forward" /></a>
	</div>

	<div style="float:right;">
		<a href="{CalendarUrl::Create($Today, CalendarTypes::Day)}" alt="Today" title="Today">{html_image src="calendar-day.png"}</a>
		<a href="{CalendarUrl::Create($DisplayDate, CalendarTypes::Month)}" alt="View Month" title="View Month">{html_image src="calendar-select-month.png"}</a>
	</div>

	<div class="clear">&nbsp;</div>
</div>

<div>
	{foreach from=$Calendar->Reservations() item=reservation}
		<div>
			<a href="{Pages::RESERVATION}?{QueryStringKeys::REFERENCE_NUMBER}={$reservation->ReferenceNumber}">
				{formatdate key='period_time' date=$Calendar->GetAdjustedStartDate($reservation)} {$reservation->ResourceName}
			</a>
		</div>
	{foreachelse}
		<div class="noresults">No reservations</div>
	{/foreach}
</div>

<script type="text/javascript" src="scripts/calendar.js"></script>
<script type="text/javascript">
$(document).ready(function() {

	var calendar = new Calendar();
	calendar.init();

});
</script>

{include file='globalfooter.tpl'}