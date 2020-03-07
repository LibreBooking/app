{*
Copyright 2011-2020 Nick Korbel

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

{* All of the slot display formatting *}

{function name=displayGeneralReserved}
    {if $Slot->IsPending()}
        {assign var=class value='pending'}
    {elseif $Slot->HasCustomColor()}
        {assign var=color value='style="background-color:'|cat:$Slot->Color()|cat:' !important;color:'|cat:$Slot->TextColor()|cat:' !important;"'}
    {/if}
    {assign var=badge value=''}
    {if $Slot->IsNew()}{assign var=badge value='<span class="reservation-new">'|cat:{translate key="New"}|cat:'</span>'}{/if}
    {if $Slot->IsUpdated()}{assign var=badge value='<span class="reservation-updated">'|cat:{translate key="Updated"}|cat:'</span>'}{/if}
    <td {$spantype|default:'col'}span="{$Slot->PeriodSpan()}" class="reserved {$class} {$OwnershipClass} clickres slot"
        resid="{$Slot->Id()}" {$color} {if $Draggable}draggable="true"{/if} data-resourceId="{$ResourceId}"
        id="{$Slot->Id()}|{$Slot->Date()->Format('Ymd')}">{$badge}{$Slot->Label($SlotLabelFactory)|escapequotes}</td>
{/function}

{function name=displayMyReserved}
    {call name=displayGeneralReserved Slot=$Slot Href=$Href SlotRef=$SlotRef OwnershipClass='mine' Draggable=true ResourceId=$ResourceId}
{/function}

{function name=displayAdminReserved}
    {call name=displayGeneralReserved Slot=$Slot Href=$Href SlotRef=$SlotRef OwnershipClass='admin' Draggable=true ResourceId=$ResourceId}
{/function}

{function name=displayMyParticipating}
    {call name=displayGeneralReserved Slot=$Slot Href=$Href SlotRef=$SlotRef OwnershipClass='participating' ResourceId=$ResourceId}
{/function}

{function name=displayReserved}
    {call name=displayGeneralReserved Slot=$Slot Href=$Href SlotRef=$SlotRef OwnershipClass='' Draggable=$CanViewAdmin ResourceId=$ResourceId}
{/function}

{function name=displayPastTime}
    <td {$spantype|default:'col'}span="{$Slot->PeriodSpan()}"
        ref="{$SlotRef}"
        class="pasttime slot"
        draggable="{$CanViewAdmin}"
        resid="{$Slot->Id()}"
        data-resourceId="{$ResourceId}"
        data-min="{$Slot->BeginDate()->Timestamp()}"
        data-max="{$Slot->EndDate()->Timestamp()}">{$Slot->Label($SlotLabelFactory)|escapequotes}</td>
{/function}

{function name=displayReservable}
    <td {$spantype|default:'col'}span="{$Slot->PeriodSpan()}" ref="{$SlotRef}" class="reservable clickres slot"
        data-href="{$Href}"
        data-start="{$Slot->BeginDate()->Format('Y-m-d H:i:s')|escape:url}"
        data-end="{$Slot->EndDate()->Format('Y-m-d H:i:s')|escape:url}"
        data-min="{$Slot->BeginDate()->Timestamp()}"
        data-max="{$Slot->EndDate()->Timestamp()}"
        data-resourceId="{$ResourceId}">&nbsp;
    </td>
{/function}

{function name=displayRestricted}
    <td {$spantype|default:'col'}span="{$Slot->PeriodSpan()}"
        data-min="{$Slot->BeginDate()->Timestamp()}"
        data-max="{$Slot->EndDate()->Timestamp()}"
        class="restricted slot">&nbsp;
    </td>
{/function}

{function name=displayUnreservable}
    <td {$spantype|default:'col'}span="{$Slot->PeriodSpan()}"
        class="unreservable slot">{$Slot->Label($SlotLabelFactory)|escape}</td>
{/function}

{function name=displaySlot}
    {call name=$DisplaySlotFactory->GetFunction($Slot, $AccessAllowed) Slot=$Slot Href=$Href SlotRef=$SlotRef ResourceId=$ResourceId}
{/function}

{* End slot display formatting *}

{block name="header"}
    {include file='globalheader.tpl' Qtip=true FloatThead=true Select2=true cssFiles='scripts/css/jqtree.css' Owl=true printCssFiles='css/schedule.print.css'}
{/block}

<div id="page-schedule" class="row">

    {assign var=startTime value=microtime(true)}

    {if $ShowResourceWarning}
        <div class="col s12 m8 offset-m2 card error no-resource-warning">
            <div class="card-content">
                <span class="fa fa-warning"></span> {translate key=NoResources}
                <a href="admin/manage_resources.php">{translate key=AddResource}</a>
            </div>
        </div>
    {/if}

    {if $CanViewAdmin}
        <div id="slow-schedule-warning" class="col s12 m8 offset-m2 card error no-show">
            <div class="card-content">
                We noticed this page is taking a long time to load. To speed ths page up, try
                reducing the number of <a class="alert-link" href="admin/manage_resources.php">resources</a> on this
                schedule or
                reducing the number of <a class="alert-link" href="admin/manage_schedules.php">days</a> being shown.
                <br/><br/>
                This page is taking <span id="warning-time"></span> seconds to load
                <span id="warning-resources"></span> resources for <span id="warning-days"></span> days.
            </div>
            <div class="card-action">
                <a href="#" class="close">Close</a>
                <a href="#" class="close-forever">Do not show again</a>
            </div>
        </div>
    {/if}

    {if $IsAccessible}
        <div id="defaultSetMessage" class="col s12 m8 offset-m2 card success hidden">
            <div class="card-content">
                {translate key=DefaultScheduleSet}
            </div>
        </div>
        {block name="schedule_control"}
            <div class="row">
                {assign var=titleWidth value="s12"}
                {if !$HideSchedule}
                    {assign var=titleWidth value="m5"}
                    <div id="schedule-actions" class="col s12 m3">
                        {block name="actions"}
                            <a href="#" id="make_default"
                               style="display:none;">{html_image src="star_boxed_full.png" altKey="MakeDefaultSchedule"}</a>
                            <a href="#" class="schedule-style" id="schedule_standard"
                               schedule-display="{ScheduleStyle::Standard}">{html_image src="table.png" altKey="StandardScheduleDisplay"}</a>
                            <a href="#" class="schedule-style" id="schedule_tall"
                               schedule-display="{ScheduleStyle::Tall}">{html_image src="table-tall.png" altKey="TallScheduleDisplay"}</a>
                            <a href="#" class="schedule-style hidden-sm hidden-xs" id="schedule_wide"
                               schedule-display="{ScheduleStyle::Wide}">{html_image src="table-wide.png" altKey="WideScheduleDisplay"}</a>
                            <a href="#" class="schedule-style hidden-sm hidden-xs" id="schedule_week"
                               schedule-display="{ScheduleStyle::CondensedWeek}">{html_image src="table-week.png" altKey="CondensedWeekScheduleDisplay"}</a>
                            <div>
                                {if $SubscriptionUrl != null && $ShowSubscription}
                                    {html_image src="feed.png"}
                                    <a target="_blank" href="{$SubscriptionUrl->GetAtomUrl()}">Atom</a>
                                    |
                                    <a target="_blank" href="{$SubscriptionUrl->GetWebcalUrl()}">iCalendar</a>
                                {/if}
                            </div>
                        {/block}
                    </div>
                {/if}

                <div id="schedule-title" class="schedule_title col {$titleWidth} s12">
                    <div class="input-field inline-block">
                        <label for="schedules" class="no-show">Schedule</label>
                        <select id="schedules" class="form-control" style="width:auto;">
                            {foreach from=$Schedules item=schedule}
                                <option value="{$schedule->GetId()}"
                                        {if $schedule->GetId() == $ScheduleId}selected="selected"{/if}>{$schedule->GetName()}</option>
                            {/foreach}
                        </select>
                    </div>
                    <a href="#" id="calendar_toggle" title="{translate key=ShowHideNavigation}" class="inline-block">
                        <span class="fa fa-calendar"></span>
                        <span class="no-show">{translate key=ShowHideNavigation}</span>
                    </a>
                    <div id="individualDates">
                        <div class="inline">
                            <label for='multidateselect'>
                                <input type="checkbox" id="multidateselect"/>
                                <span>{translate key=SpecificDates}</span>
                            </label>
                        </div>
                        <a class="btn btn-flat btn-sm" href="#" id="individualDatesGo">
                            <i class="fa fa-angle-double-right"></i>
                            <span class="no-show">{translate key=SpecificDates}</span>
                        </a>
                    </div>
                    <div id="individualDatesList"></div>
                </div>

                {capture name="date_navigation"}
                    {if !$HideSchedule}
                        <div class="schedule-dates col s12 m4">
                            {assign var=TodaysDate value=Date::Now()}
                            <a href="#" class="change-date btn-link btn-success" data-year="{$TodaysDate->Year()}"
                               data-month="{$TodaysDate->Month()}" data-day="{$TodaysDate->Day()}"
                               alt="{translate key=Today}"><i class="fa fa-home"></i>
                                <span class="no-show">{translate key=Today}</span>
                            </a>
                            {assign var=FirstDate value=$DisplayDates->GetBegin()}
                            {assign var=LastDate value=$DisplayDates->GetEnd()->AddDays(-1)}
                            <a href="#" class="change-date" data-year="{$PreviousDate->Year()}"
                               data-month="{$PreviousDate->Month()}"
                               data-day="{$PreviousDate->Day()}">{html_image src="arrow_large_left.png" alt='{translate key=Back}'}</a>
                            {formatdate date=$FirstDate} - {formatdate date=$LastDate}
                            <a href="#" class="change-date" data-year="{$NextDate->Year()}"
                               data-month="{$NextDate->Month()}"
                               data-day="{$NextDate->Day()}">{html_image src="arrow_large_right.png" alt='{translate key=Forward}'}</a>

                            {if $ShowFullWeekLink}
                                <a href="{add_querystring key=SHOW_FULL_WEEK value=1}"
                                   id="showFullWeek">({translate key=ShowFullWeek})</a>
                            {/if}
                        </div>
                    {/if}
                {/capture}

                {$smarty.capture.date_navigation}
            </div>
            <div type="text" id="datepicker" style="display:none;"></div>
        {/block}

        {if $ScheduleAvailabilityEarly}
            <div class="col s12 m8 offset-m2 card warning">
                <div class="card-content">
                    <strong>
                        {translate key=ScheduleAvailabilityEarly}
                        <a href="#" class="change-date" data-year="{$ScheduleAvailabilityStart->Year()}"
                           data-month="{$ScheduleAvailabilityStart->Month()}"
                           data-day="{$ScheduleAvailabilityStart->Day()}">
                            {format_date date=$ScheduleAvailabilityStart timezone=$timezone}
                        </a> -
                        <a href="#" class="change-date" data-year="{$ScheduleAvailabilityEnd->Year()}"
                           data-month="{$ScheduleAvailabilityEnd->Month()}"
                           data-day="{$ScheduleAvailabilityEnd->Day()}">
                            {format_date date=$ScheduleAvailabilityEnd timezone=$timezone}
                        </a>
                    </strong>
                </div>
            </div>
        {/if}

        {if $ScheduleAvailabilityLate}
            <div class="col s12 m8 offset-m2 card warning">
                <div class="card-content">
                    <strong>
                        {translate key=ScheduleAvailabilityLate}
                        <a href="#" class="change-date" data-year="{$ScheduleAvailabilityStart->Year()}"
                           data-month="{$ScheduleAvailabilityStart->Month()}"
                           data-day="{$ScheduleAvailabilityStart->Day()}">
                            {format_date date=$ScheduleAvailabilityStart timezone=$timezone}
                        </a> -
                        <a href="#" class="change-date" data-year="{$ScheduleAvailabilityEnd->Year()}"
                           data-month="{$ScheduleAvailabilityEnd->Month()}"
                           data-day="{$ScheduleAvailabilityEnd->Day()}">
                            {format_date date=$ScheduleAvailabilityEnd timezone=$timezone}
                        </a>
                    </strong>
                </div>
            </div>
        {/if}

        {if $AllowConcurrentReservations}
            <div class="col s12 m8 offset-m2 card warning">
                <div class="card-content">
                    <strong>
                        <a href="{Pages::CALENDAR}?sid={$ScheduleId}">{format_date date=$ScheduleAvailabilityStart timezone=$timezone}{translate key=OnlyViewedCalendar}</a>
                    </strong>
                </div>
            </div>
        {/if}

        {if !$HideSchedule}
            {block name="legend"}
                <div class="hide-on-small-only row col m12 schedule-legend">
                    <div class="center">
                        <div class="legend reservable">{translate key=Reservable}</div>
                        <div class="legend unreservable">{translate key=Unreservable}</div>
                        <div class="legend reserved">{translate key=Reserved}</div>
                        {if $LoggedIn}
                            <div class="legend reserved mine">{translate key=MyReservation}</div>
                            <div class="legend reserved participating">{translate key=Participant}</div>
                        {/if}
                        <div class="legend reserved pending">{translate key=Pending}</div>
                        <div class="legend pasttime">{translate key=Past}</div>
                        <div class="legend restricted">{translate key=Restricted}</div>
                    </div>
                </div>
            {/block}
            <div class="row">
                <div id="reservations-left" class="col s12 m2 default-box">
                    <div class="reservations-left-header">{translate key=ResourceFilter}
                        <a href="#" class="pull-right toggle-sidebar" title="Hide Reservation Filter"><i
                                    class="fa fa-remove"></i>
                            <span class="no-show">Hide Reservation Filter</span>
                        </a>
                    </div>

                    <div class="reservations-left-content">
                        <form method="get" role="form" id="advancedFilter">

                            {if count($ResourceAttributes) + count($ResourceTypeAttributes) > 5}
                                <div>
                                    <input type="submit" value="{translate key=Filter}"
                                           class="btn btn-default btn-sm" {formname key=SUBMIT}/>
                                </div>
                            {/if}

                            <div>
                                {*<label>{translate key=Resource}</label>*}
                                <div id="resourceGroups"></div>
                            </div>
                            <div id="resettable">
                                <div class="input-field">
                                    <label for="minCapacity">{translate key=MinimumCapacity}</label>
                                    <input type='number' min='0' id='minCapacity' size='5' maxlength='5'
                                           class="input-sm" {formname key=MIN_CAPACITY}
                                           value="{$MinCapacityFilter}"/>
                                </div>

                                <div class="input-field">
                                    <label for="resourceType" class="active">{translate key=ResourceType}</label>
                                    <select id="resourceType" {formname key=RESOURCE_TYPE_ID} {formname key=RESOURCE_TYPE_ID}
                                            class="input-sm">
                                        <option value="">- {translate key=All} -</option>
                                        {object_html_options options=$ResourceTypes label='Name' key='Id' selected=$ResourceTypeIdFilter}
                                    </select>
                                </div>

                                {foreach from=$ResourceAttributes item=attribute}
                                    {control type="AttributeControl" attribute=$attribute align='vertical' searchmode=true namePrefix='r' inputClass="input-sm" class="customAttribute col-xs-12"}
                                {/foreach}

                                {foreach from=$ResourceTypeAttributes item=attribute}
                                    {control type="AttributeControl" attribute=$attribute align='vertical' searchmode=true namePrefix='rt' inputClass="input-sm" class="customAttribute col-xs-12"}
                                {/foreach}

                                <div class="btn-submit">
                                    <button type="submit" class="btn btn-primary btn-sm"
                                            value="submit">{translate key=Filter}</button>
                                </div>
                                <div class="btn-clear">
                                    <button id="show_all_resources" type="button"
                                            class="btn btn-flat btn-xs">{translate key=ClearFilter}</button>
                                </div>

                            </div>

                            <input type="hidden" name="sid" value="{$ScheduleId}"/>
                            <input type="hidden" name="sds"
                                   value="{foreach from=$SpecificDates item=d}{$d->Format('Y-m-d')},{/foreach}"/>
                            <input type="hidden" name="sd" value="{$DisplayDates->GetBegin()->Format('Y-m-d')}"/>
                            <input type="hidden" {formname key=SUBMIT} value="true"/>
                            <input type="hidden" name="clearFilter" id="clearFilter" value="0"/>
                        </form>
                    </div>
                </div>

                <div id="reservations" class="col s12 m10">
                    <div>
                        <a href="#" id="restore-sidebar" title="Show Reservation Filter"
                           class="hidden toggle-sidebar">{translate key=ResourceFilter} <i
                                    class="fa fa-filter"></i> <i
                                    class="fa fa-chevron-right"></i></a>
                    </div>
                    {block name="reservations"}
                        {include file="Schedule/schedule-reservations-grid.tpl" }
                    {/block}
                </div>
            </div>
        {/if}
    {else}
        <div class="error">{translate key=NoResourcePermission}</div>
    {/if}
    <div class="clearfix">&nbsp;</div>
    <input type="hidden" value="{$ScheduleId}" id="scheduleId"/>

    <div class="row no-margin">
        <div class="col m8 show-on-medium-and-up">&nbsp;</div>
        {$smarty.capture.date_navigation}
    </div>
    {assign var=endTime value=microtime(true)}

</div>

<form id="moveReservationForm">
    <input id="moveReferenceNumber" type="hidden" {formname key=REFERENCE_NUMBER} />
    <input id="moveStartDate" type="hidden" {formname key=BEGIN_DATE} />
    <input id="moveResourceId" type="hidden" {formname key=RESOURCE_ID} />
    <input id="moveSourceResourceId" type="hidden" {formname key=ORIGINAL_RESOURCE_ID} />
    {csrf_token}
</form>

<form id="fetchReservationsForm">
    <input type="hidden" {formname key=BEGIN_DATE} value="{formatdate date=$FirstDate key=system}"/>
    <input type="hidden" {formname key=END_DATE} value="{formatdate date=$LastDate key=system}"/>
    <input type="hidden" {formname key=SCHEDULE_ID} value="{$ScheduleId}"/>
    {foreach from=$SpecificDates item=d}
        <input type="hidden" {formname key=SPECIFIC_DATES multi=true} value="{formatdate date=$d key=system}"/>
    {/foreach}
    <input type="hidden" {formname key=MIN_CAPACITY} value="{$MinCapacityFilter}"/>
    <input type="hidden" {formname key=RESOURCE_TYPE_ID} value="{$ResourceTypeIdFilter}" />
    {foreach from=$ResourceAttributes item=attribute}
        <input type="hidden" name="RESOURCE_ATTRIBUTE_ID[{$attribute->Id()}]" value="{$attribute->Value()}" />
        {/foreach}
    {foreach from=$ResourceTypeAttributes item=attribute}
        <input type="hidden" name="RESOURCE_TYPE_ATTRIBUTE_ID[{$attribute->Id()}]" value="{$attribute->Value()}" />
        {/foreach}
    {foreach from=$ResourceIds item=id}
        <input type="hidden" {formname key=RESOURCE_ID multi=true} value="{$id}" />
    {/foreach}
    {csrf_token}
</form>

{include file="javascript-includes.tpl" Qtip=true FloatThead=true Select2=true Owl=true}

{block name="scripts-before"}

{/block}

{block name="scripts-common"}

    {jsfile src="js/moment.min.js"}
    {jsfile src="schedule.js"}
    {jsfile src="resourcePopup.js"}
    {jsfile src="js/tree.jquery.js"}
    {jsfile src="js/jquery.cookie.js"}
    {jsfile src="ajax-helpers.js"}
    <script type="text/javascript">

        {if $LoadViewOnly}
        $(document).ready(function () {
            var scheduleOptions = {
                reservationUrlTemplate: "view-reservation.php?{QueryStringKeys::REFERENCE_NUMBER}=[referenceNumber]",
                summaryPopupUrl: "ajax/respopup.php",
                cookieName: "{$CookieName}",
                scheduleId: "{$ScheduleId}",
                scriptUrl: '{$ScriptUrl}',
                selectedResources: [{','|implode:$ResourceIds}],
                specificDates: [{foreach from=$SpecificDates item=d}'{$d->Format('Y-m-d')}',{/foreach}],
                disableSelectable: '{$IsMobile}',
                reservationLoadUrl: "{$Path}{Pages::SCHEDULE}?{QueryStringKeys::DATA_REQUEST}=reservations",
                scheduleStyle: "{$ScheduleStyle}",
                midnightLabel: "{formatdate date=Date::Now()->GetDate() key=period_time}",
                isMobileView: "{$IsMobile}"
            };
            var schedule = new Schedule(scheduleOptions, {$ResourceGroupsAsJson});
            {if $AllowGuestBooking}
            schedule.init();
            schedule.initUserDefaultSchedule(true);
            {else}
            schedule.initNavigation();
            schedule.initRotateSchedule();
            schedule.initReservations();
            schedule.initResourceFilter();
            schedule.initResources();
            schedule.initUserDefaultSchedule(true);
            {/if}
        });
        {else}
        $(document).ready(function () {
            var scheduleOpts = {
                reservationUrlTemplate: "{$Path}{Pages::RESERVATION}?{QueryStringKeys::REFERENCE_NUMBER}=[referenceNumber]",
                summaryPopupUrl: "{$Path}ajax/respopup.php",
                setDefaultScheduleUrl: "{$Path}{Pages::PROFILE}?action=changeDefaultSchedule&{QueryStringKeys::SCHEDULE_ID}=[scheduleId]",
                cookieName: "{$CookieName}",
                scheduleId: "{$ScheduleId|escape:'javascript'}",
                scriptUrl: '{$ScriptUrl}',
                selectedResources: [{','|implode:$ResourceIds}],
                specificDates: [{foreach from=$SpecificDates item=d}'{$d->Format('Y-m-d')}',{/foreach}],
                updateReservationUrl: "{$Path}ajax/reservation_move.php",
                lockTableHead: {$LockTableHead},
                disableSelectable: '{$IsMobile}',
                reservationLoadUrl: "{$Path}{Pages::SCHEDULE}?{QueryStringKeys::DATA_REQUEST}=reservations",
                scheduleStyle: "{$ScheduleStyle}",
                midnightLabel: "{formatdate date=Date::Now()->GetDate() key=period_time}",
                isMobileView: "{$IsMobile}"
            };

            var schedule = new Schedule(scheduleOpts, {$ResourceGroupsAsJson});
            schedule.init();
        });
        {/if}

        // $('#schedules').select2({
        //     width: 'resolve'
        // });

        var pageLoadTime = {round($endTime-$startTime)};
        var resourceCount = {$Resources|count};
        var dayCount = {$BoundDates|count};

        if (pageLoadTime > 10 && !cookies.isDismissed('slow-schedule-warning')) {
            $('#slow-schedule-warning').removeClass('no-show');
            $('#warning-time').text(pageLoadTime);
            $('#warning-resources').text(resourceCount);
            $('#warning-days').text(dayCount);
        }

        $('#slow-schedule-warning').find('.close-forever').on('click', function (e) {
            e.preventDefault();
            cookies.dismiss('slow-schedule-warning', '{$ScriptUrl}');
            $('#slow-schedule-warning').addClass('no-show');
        });

        $('#slow-schedule-warning').find('.close').on('click', function (e) {
            e.preventDefault();
            $('#slow-schedule-warning').addClass('no-show');
        });

    </script>
{/block}

{block name="scripts-after"}

{/block}


{control type="DatePickerSetupControl"
ControlId='datepicker'
DefaultDate=$FirstDate
NumberOfMonths=$PopupMonths
ShowButtonPanel='true'
OnSelect='dpDateChanged'
FirstDay=$FirstWeekday}

{include file='globalfooter.tpl'}