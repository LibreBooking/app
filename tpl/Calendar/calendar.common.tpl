{*
Copyright 2011-2013 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*}
<div class="calendar-subscription">
{if $IsSubscriptionAllowed && $IsSubscriptionEnabled}
	<a id="subscribeTocalendar" href="{$SubscriptionUrl}">{html_image src="calendar-share.png"} {translate key=SubscribeToCalendar}</a>
	<br/>URL: <span class="note">{$SubscriptionUrl}</span>
{else}
	<span class="note">{translate key=SubscriptionsAreDisabled}</span>
{/if}
</div>

<div id="calendar"></div>

<div id="dayDialog" class="dialog">
	<a href="#" id="dayDialogCreate">{html_image src="tick.png"}{translate key=CreateReservation}</a>
	<a href="#" id="dayDialogView">{html_image src="search.png"}{translate key=ViewDay}</a>
	<a href="#" id="dayDialogCancel">{html_image src="slash.png"}{translate key=Cancel}</a>
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
			title: '{$reservation->DisplayTitle|escape:javascript}',
			start: '{format_date date=$reservation->StartDate key=fullcalendar}',
			end: '{format_date date=$reservation->EndDate key=fullcalendar}',
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
					monthNamesShort: {js_array array=$MonthNamesShort},
					timeFormat: '{$TimeFormat}',
					dayMonth: '{$DateFormat}',
					firstDay: 0,
					reservationUrl: '{Pages::RESERVATION}?sid={$ScheduleId}&rid={$ResourceId}',
					reservable: true
				};
		
	var calendar = new Calendar(options, reservations);
	calendar.init();
});
</script>