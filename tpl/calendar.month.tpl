{include file='globalheader.tpl' cssFiles='css/calendar.css,css/jquery.qtip.css,scripts/css/fullcalendar.css'}

{include file='calendar.filter.tpl'}

<div class="calendarHeading">

	<div style="float:left;">
		<a href="{$PrevLink}"><img src="img/arrow_large_left.png" alt="Back" /></a>
		{$MonthName} {$DisplayDate->Year()}
		<a href="{$NextLink}"><img src="img/arrow_large_right.png" alt="Forward" /></a>
	</div>

	<div style="float:right;">
		<a href="{CalendarUrl::Create($Today, CalendarTypes::Month)}" alt="Today" title="Today">{html_image src="calendar-day.png"}</a>
		<a href="{CalendarUrl::Create($DisplayDate, CalendarTypes::Week)}" alt="Week" title="Week">{html_image src="calendar-select-week.png"}</a>
	</div>

	<div class="clear">&nbsp;</div>

</div>

{include file='calendar.common.tpl' view='month'}

{include file='globalfooter.tpl'}