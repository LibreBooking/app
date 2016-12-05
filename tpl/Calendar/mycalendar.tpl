{*
Copyright 2011-2016 Nick Korbel

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
{include file='globalheader.tpl' Select2=true Qtip=true Fullcalendar=true cssFiles='scripts/css/jqtree.css'}

<div class="page-my-calendar">

    {include file='Calendar/calendar.filter.tpl'}

    <div id="subscriptionContainer">
        {include file="Calendar/mycalendar.subscription.tpl" IsSubscriptionAllowed=$IsSubscriptionAllowed SubscriptionUrl=$SubscriptionUrl}
    </div>

    <div id="calendar"></div>

    <div id="dayDialog" class="default-box-shadow">
        <a href="#" id="dayDialogCreate">{html_image src="tick.png"}{translate key=CreateReservation}</a>
        <a href="#" id="dayDialogView">{html_image src="search.png"}{translate key=ViewDay}</a>
        <a href="#" id="dayDialogCancel">{html_image src="slash.png"}{translate key=Cancel}</a>
    </div>

    {csrf_token}

    {jsfile src="reservationPopup.js"}
    {jsfile src="calendar.js"}
    {jsfile src="ajax-helpers.js"}
    {jsfile src="js/tree.jquery.js"}

    <script type="text/javascript">
        $(document).ready(function () {

            var options = {
                view: '{$CalendarType}',
                defaultDate: moment('{$DisplayDate->Format('Y-m-d')}', 'YYYY-MM-DD'),
                todayText: '{{translate key=Today}|escape:'javascript'}',
                dayText: '{{translate key=Day}|escape:'javascript'}',
                monthText: '{{translate key=Month}|escape:'javascript'}',
                weekText: '{{translate key=Week}|escape:'javascript'}',
                dayClickUrl: '{Pages::MY_CALENDAR}?ct={CalendarTypes::Day}&sid={$ScheduleId|escape:'javascript'}&rid={$ResourceId|escape:'javascript'}',
                dayClickUrlTemplate: '{Pages::MY_CALENDAR}?ct={CalendarTypes::Day}&sid=[sid]&rid=[rid]',
                dayNames: {js_array array=$DayNames},
                dayNamesShort: {js_array array=$DayNamesShort},
                monthNames: {js_array array=$MonthNames},
                monthNamesShort: {js_array array=$MonthNamesShort},
                timeFormat: '{$TimeFormat}',
                dayMonth: '{$DateFormat}',
                firstDay: {$FirstDay},
                reservationUrl: '{Pages::RESERVATION}?sid={$ScheduleId|escape:'javascript'}&rid={$ResourceId|escape:'javascript'}',
                reservationUrlTemplate: '{Pages::RESERVATION}?sid=[sid]&rid=[rid]',
                subscriptionEnableUrl: '{Pages::MY_CALENDAR}?{QueryStringKeys::ACTION}={PersonalCalendarActions::ActionEnableSubscription}',
                subscriptionDisableUrl: '{Pages::MY_CALENDAR}?{QueryStringKeys::ACTION}={PersonalCalendarActions::ActionDisableSubscription}',
                eventsUrl: '{Pages::MY_CALENDAR}',
                reservable: true,
                eventsData: {
                    dr: 'events',
                    sid: '',
                    rid: ''
                },
                getSubscriptionUrl: '{Pages::MY_CALENDAR}?dr=subscription'
            };

            var calendar = new Calendar(options);
            calendar.init();
            calendar.bindResourceGroups({$ResourceGroupsAsJson}, {$SelectedGroupNode|default:0});
        });
    </script>

</div>

{include file='globalfooter.tpl'}