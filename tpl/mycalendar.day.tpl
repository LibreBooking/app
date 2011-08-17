{include file='globalheader.tpl' cssFiles='css/calendar.css,css/jquery.qtip.css,scripts/css/fullcalendar.css'}

<div class="calendarHeading">

	<div style="float:left;">
		<a href="{$PrevLink}"><img src="img/arrow_large_left.png" alt="Back" /></a>
		{$DayName}, {$MonthName} {$DisplayDate->Day()}, {$DisplayDate->Year()}
		<a href="{$NextLink}"><img src="img/arrow_large_right.png" alt="Forward" /></a>
	</div>

	<div style="float:right;">
		<a href="{CalendarUrl::Create($Today, CalendarTypes::Day)}" alt="Today" title="Today">{html_image src="calendar-day.png"}</a>
		<a href="{CalendarUrl::Create($DisplayDate, CalendarTypes::Week)}" alt="Week" title="Week">{html_image src="calendar-select-week.png"}</a>
		<a href="{CalendarUrl::Create($DisplayDate, CalendarTypes::Month)}" alt="View Month" title="View Month">{html_image src="calendar-select-month.png"}</a>
	</div>

	<div class="clear">&nbsp;</div>
</div>

<div id="calendar">
	
</div>

<script type="text/javascript" src="scripts/js/jquery.qtip.min.js"></script>
<script type="text/javascript" src="scripts/reservationPopup.js"></script>
<script type="text/javascript" src="scripts/calendar.js"></script>
<script type="text/javascript" src="scripts/js/fullcalendar.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {

	var reservations = [];
	{foreach from=$Calendar->Reservations() item=reservation}
		reservations.push({
			id: '{$reservation->ReferenceNumber}',
			title: '{$reservation->ResourceName} {$reservation->Title}',
			start: '{$reservation->StartDate->Timestamp()}',
			end: '{$reservation->EndDate->Timestamp()}',
			url: 'reservation.php?rn={$reservation->ReferenceNumber}',
			allDay: false
		});
	{/foreach}

	$('#calendar').fullCalendar({
		header: '',
		editable: false,
		defaultView: 'agendaDay',
		year: {$DisplayDate->Year()},
		month: {$DisplayDate->Month()}-1,
		date: {$DisplayDate->Day()},
		events: reservations,
		eventMouseover: function(e) { $(this).attachReservationPopup(e.id); }
	});
		
	var calendar = new Calendar();
	calendar.init();

});
</script>

{include file='globalfooter.tpl'}