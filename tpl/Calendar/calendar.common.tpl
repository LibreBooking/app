{*
Copyright 2011-2014 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*}

{if $IsAccessible}
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

{else}
<div class="error">{translate key=NoResourcePermission}</div>
{/if}

{jsfile src="js/jquery.qtip.min.js"}
{jsfile src="reservationPopup.js"}
{jsfile src="calendar.js"}
{jsfile src="js/fullcalendar.min.js"}

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
			allDay: false,
			color: '{$reservation->Color}',
			textColor: '{$reservation->TextColor}',
			className: '{$reservation->Class}'
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
					firstDay: {$FirstDay},
					reservationUrl: '{Pages::RESERVATION}?sid={$ScheduleId}&rid={$ResourceId}',
					reservable: true
				};

	var calendar = new Calendar(options, reservations);
	calendar.init();
});
</script>