<div id="calendar"></div>

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
			title: '{$reservation->OwnerName} - {$reservation->ResourceName} {$reservation->Title}',
			start: '{$reservation->StartDate->Timestamp()}',
			end: '{$reservation->EndDate->Timestamp()}',
			url: '{Pages::RESERVATION}?rn={$reservation->ReferenceNumber}',
			allDay: false
		});
	{/foreach}

	var options = {
					view: '{$view}',
					year: {$DisplayDate->Year()},
					month: {$DisplayDate->Month()},
					date: {$DisplayDate->Day()},
					dayClickUrl: '{Pages::CALENDAR}?ct={CalendarTypes::Day}&sid={$ScheduleId}&rid={$ResourceId}',
					dayNames: {js_array array=$DayNames},
					dayNamesShort: {js_array array=$DayNamesShort},
					monthNames: {js_array array=$MonthNames},
					monthNamesShort: {js_array array=$MonthNamesShort}
				};
		
	var calendar = new Calendar(options, reservations);
	calendar.init();
});
</script>