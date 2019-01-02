{*
Copyright 2011-2019 Nick Korbel

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
{include file='globalheader.tpl' Select2=true Qtip=true Fullcalendar=true cssFiles='scripts/css/jqtree.css' printCssFiles='css/calendar.print.css'}

<div id="page-{$pageIdSuffix}">
    {include file='Calendar/calendar.filter.tpl'}

    <div id="subscriptionContainer">
        {include file="Calendar/{$subscriptionTpl}" IsSubscriptionAllowed=$IsSubscriptionAllowed IsSubscriptionEnabled=$IsSubscriptionEnabled SubscriptionUrl=$SubscriptionUrl}
    </div>

    <div id="calendar"></div>

    <div id="dayDialog" class="default-box-shadow">
        {if !$HideCreate}<a href="#" id="dayDialogCreate">{html_image src="tick.png"}{translate key=CreateReservation}</a>{/if}
        <a href="#" id="dayDialogView">{html_image src="search.png"}{translate key=ViewDay}</a>
        <a href="#" id="dayDialogCancel">{html_image src="slash.png"}{translate key=Cancel}</a>
    </div>

    <div class="modal fade" id="moveErrorDialog" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="errorModalLabel">{translate key=ErrorMovingReservation}</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <ul id="moveErrorsList"></ul>
                    </div>
                </div>
                <div class="modal-footer">
                    {ok_button id="moveErrorOk"}
                </div>
            </div>
        </div>
    </div>

    <form id="moveReservationForm">
        <input id="moveReferenceNumber" type="hidden" {formname key=REFERENCE_NUMBER} />
        <input id="moveStartDate" type="hidden" {formname key=BEGIN_DATE} />
        <input id="moveResourceId" type="hidden" {formname key=RESOURCE_ID} value="0" />
        <input id="moveSourceResourceId" type="hidden" {formname key=ORIGINAL_RESOURCE_ID} value="0" />
    </form>

    {csrf_token}

    {include file="javascript-includes.tpl" Select2=true Qtip=true Fullcalendar=true}
    {jsfile src="reservationPopup.js"}
    {jsfile src="calendar.js"}
    {jsfile src="ajax-helpers.js"}
    {jsfile src="js/tree.jquery.js"}

    <script type="text/javascript">
        $(document).ready(function () {

            var options = {
                view: '{$CalendarType|escape:javascript}',
                defaultDate: moment('{$DisplayDate->Format('Y-m-d')}', 'YYYY-MM-DD'),
                todayText: '{{translate key=Today}|escape:'javascript'}',
                dayText: '{{translate key=Day}|escape:'javascript'}',
                monthText: '{{translate key=Month}|escape:'javascript'}',
                weekText: '{{translate key=Week}|escape:'javascript'}',
                dayClickUrl: '{$pageUrl}?ct={CalendarTypes::Day}&sid={$ScheduleId|escape:'javascript'}&rid={$ResourceId|escape:'javascript'}&gid={$GroupId|escape:'javascript'}',
                dayClickUrlTemplate: '{$pageUrl}?ct={CalendarTypes::Day}&sid=[sid]&rid=[rid]&gid=[gid]',
                dayNames: {js_array array=$DayNames},
                dayNamesShort: {js_array array=$DayNamesShort},
                monthNames: {js_array array=$MonthNames},
                monthNamesShort: {js_array array=$MonthNamesShort},
                timeFormat: '{$TimeFormat}',
                dayMonth: '{$DateFormat}',
                firstDay: {$FirstDay},
                reservationUrl: '{$CreateReservationPage}?sid={$ScheduleId|escape:'javascript'}&rid={$ResourceId|escape:'javascript'}',
                reservationUrlTemplate: '{$CreateReservationPage}?sid=[sid]&rid=[rid]',
                reservable: true,
                eventsUrl: '{$pageUrl}',
                eventsData: {
                    dr: 'events',
                    sid: '{$ScheduleId|escape:'javascript'}',
                    rid: '{$ResourceId|escape:'javascript'}',
                    gid: '{$GroupId|escape:'javascript'}'
                },
                getSubscriptionUrl: '{$pageUrl}?dr=subscription',
                subscriptionEnableUrl: '{$pageUrl}?{QueryStringKeys::ACTION}={CalendarActions::ActionEnableSubscription}',
                subscriptionDisableUrl: '{$pageUrl}?{QueryStringKeys::ACTION}={CalendarActions::ActionDisableSubscription}',
                moveReservationUrl: "{$Path}ajax/reservation_move.php",
                returnTo: '{$pageUrl}'
            };

            var calendar = new Calendar(options);
            calendar.init();

            calendar.bindResourceGroups({$ResourceGroupsAsJson}, {$SelectedGroupNode|default:0});

        });
    </script>
</div>
{include file='globalfooter.tpl'}