{*
Copyright 2011-2015 Nick Korbel

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
{include file='globalheader.tpl' Select2=true Qtip=true Fullcalendar=true}

<div class="page-calendar">
    {include file='Calendar/calendar.filter.tpl'}

    <div id="subscriptionContainer">
        {include file="Calendar/calendar.subscription.tpl" IsSubscriptionAllowed=$IsSubscriptionAllowed IsSubscriptionEnabled=$IsSubscriptionEnabled SubscriptionUrl=$SubscriptionUrl}
    </div>

    <div id="calendar"></div>

    {csrf_token}

    {jsfile src="reservationPopup.js"}
    {jsfile src="calendar.js"}
    {jsfile src="ajax-helpers.js"}

    <script type="text/javascript">
        $(document).ready(function () {

            var options = {
                view: '{$CalendarType}',
                defaultDate: moment('{$DisplayDate->Format('Y-m-d')}', 'YYYY-MM-DD'),
                todayText: '{translate key=Today}',
                dayText: '{translate key=Day}',
                monthText: '{translate key=Month}',
                weekText: '{translate key=Week}',
                dayClickUrl: '{Pages::CALENDAR}?ct={CalendarTypes::Day}&sid={$ScheduleId}&rid={$ResourceId}',
                dayNames: {js_array array=$DayNames},
                dayNamesShort: {js_array array=$DayNamesShort},
                monthNames: {js_array array=$MonthNames},
                monthNamesShort: {js_array array=$MonthNamesShort},
                timeFormat: '{$TimeFormat}',
                dayMonth: '{$DateFormat}',
                firstDay: {$FirstDay},
                reservationUrl: '{Pages::RESERVATION}?sid={$ScheduleId}&rid={$ResourceId}',
                reservable: true,
                eventsUrl: '{Pages::CALENDAR}',
                eventsData: {
                    dr: 'events',
                    sid: '',
                    rid: ''
                },
                getSubscriptionUrl: '{Pages::CALENDAR}?dr=subscription',
            };

            var calendar = new Calendar(options);
            calendar.init();

            calendar.bindResourceGroups({$ResourceGroupsAsJson}, {$SelectedGroupNode|default:0});

        });
    </script>
</div>
{include file='globalfooter.tpl'}