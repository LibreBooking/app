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
<div class="calendar-subscription">
{if $IsSubscriptionAllowed}
	<a href="#" id="turnOffSubscription">{html_image src="switch-minus.png"} {translate key=TurnOffSubscription}</a>
	{if $IsSubscriptionEnabled}
		<a id="subscribeTocalendar" href="{$SubscriptionUrl}">{html_image src="calendar-share.png"} {translate key=SubscribeToCalendar}</a>
		<br/>URL: <span class="note">{$SubscriptionUrl}</span>
	{else}
		<span class="note">{translate key=SubscriptionsAreDisabled}</span>
	{/if}
{else}
	<a href="#" id="turnOnSubscription">{html_image src="switch-plus.png"} {translate key=TurnOnSubscription}</a>
{/if}
</div>

<div id="calendar"></div>

{jsfile src="js/jquery.qtip.min.js"}
{jsfile src="reservationPopup.js"}
{jsfile src="calendar.js"}
{jsfile src="js/fullcalendar.min.js"}
{jsfile src="admin/edit.js"}

<script type="text/javascript">
$(document).ready(function() {

	var reservations = [];
	{foreach from=$Calendar->Reservations() item=reservation}
		reservations.push({
			id: '{$reservation->ReferenceNumber}',
			title: '{$reservation->ResourceName|escape:javascript} {$reservation->Title|escape:javascript}',
			start: '{format_date date=$reservation->StartDate key=fullcalendar}',
			end: '{format_date date=$reservation->EndDate key=fullcalendar}',
			url: 'reservation.php?rn={$reservation->ReferenceNumber}',
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
					dayClickUrl: '{Pages::MY_CALENDAR}?ct={CalendarTypes::Day}',
					dayNames: {js_array array=$DayNames},
					dayNamesShort: {js_array array=$DayNamesShort},
					monthNames: {js_array array=$MonthNames},
					monthNamesShort: {js_array array=$MonthNamesShort},
					timeFormat: '{$TimeFormat}',
					dayMonth: '{$DateFormat}',
					firstDay: 0,
					subscriptionEnableUrl: '{Pages::MY_CALENDAR}?{QueryStringKeys::ACTION}={PersonalCalendarActions::ActionEnableSubscription}',
					subscriptionDisableUrl: '{Pages::MY_CALENDAR}?{QueryStringKeys::ACTION}={PersonalCalendarActions::ActionDisableSubscription}'
				};

	var calendar = new Calendar(options, reservations);
	calendar.init();
});
</script>