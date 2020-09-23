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

{function name=displayPastTime}
    <td ref="{$SlotRef}"
        class="pasttime slot"
        data-href="{$Href}"
        data-start="{$Slot->BeginDate()->Format('Y-m-d H:i:s')|escape:url}"
        data-end="{$Slot->EndDate()->Format('Y-m-d H:i:s')|escape:url}"
        data-min="{$Slot->BeginDate()->Timestamp()}"
        data-max="{$Slot->EndDate()->Timestamp()}"
        data-resourceId="{$ResourceId}">&nbsp;
    </td>
{/function}

{function name=displayReservable}
    <td class="reservable clickres slot"
        ref="{$SlotRef}"
        data-href="{$Href}"
        data-start="{$Slot->BeginDate()->Format('Y-m-d H:i:s')|escape:url}"
        data-end="{$Slot->EndDate()->Format('Y-m-d H:i:s')|escape:url}"
        data-min="{$Slot->BeginDate()->Timestamp()}"
        data-max="{$Slot->EndDate()->Timestamp()}"
        data-resourceId="{$ResourceId}">&nbsp;
    </td>
{/function}

{function name=displayRestricted}
    <td ref="{$SlotRef}"
        class="restricted slot"
        data-href="{$Href}"
        data-start="{$Slot->BeginDate()->Format('Y-m-d H:i:s')|escape:url}"
        data-end="{$Slot->EndDate()->Format('Y-m-d H:i:s')|escape:url}"
        data-min="{$Slot->BeginDate()->Timestamp()}"
        data-max="{$Slot->EndDate()->Timestamp()}"
        data-resourceId="{$ResourceId}">&nbsp;
    </td>
{/function}

{function name=displayUnreservable}
    <td ref="{$SlotRef}"
        class="unreservable slot"
        data-href="{$Href}"
        data-start="{$Slot->BeginDate()->Format('Y-m-d H:i:s')|escape:url}"
        data-end="{$Slot->EndDate()->Format('Y-m-d H:i:s')|escape:url}"
        data-min="{$Slot->BeginDate()->Timestamp()}"
        data-max="{$Slot->EndDate()->Timestamp()}"
        data-resourceId="{$ResourceId}">&nbsp;
    </td>
{/function}

{function name=displaySlot}
    {call name=$DisplaySlotFactory->GetFunction($Slot, $AccessAllowed) Slot=$Slot Href=$Href SlotRef=$SlotRef ResourceId=$ResourceId}
{/function}

{* End slot display formatting *}

{block name="header"}
    {include file='globalheader.tpl' Qtip=true Select2=true Owl=true cssFiles='scripts/css/jqtree.css' printCssFiles='css/schedule.print.css'}
{/block}

<div id="page-schedule">
    {assign var=startTime value=microtime(true)}

    {if $ShowResourceWarning}
        <div class="alert alert-warning no-resource-warning"><span
                    class="fa fa-warning"></span> {translate key=NoResources} <a
                    href="admin/manage_resources.php">{translate key=AddResource}</a></div>
    {/if}

    {if $CanViewAdmin}
        <div id="slow-schedule-warning" class="alert alert-warning no-show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>

            We noticed this page is taking a long time to load. To speed ths page up, try
            reducing the number of <a class="alert-link" href="admin/manage_resources.php">resources</a> on this
            schedule or
            reducing the number of <a class="alert-link" href="admin/manage_schedules.php">days</a> being shown.
            <br/><br/>
            This page is taking <span id="warning-time"></span> seconds to load
            <span id="warning-resources"></span> resources for <span id="warning-days"></span> days.

            <button type="button" class="close close-forever" aria-label="Do not show again">
                <span aria-hidden="true">Do not show again</span>
            </button>
        </div>
    {/if}

    {if $IsAccessible}
        <div id="defaultSetMessage" class="alert alert-success hidden">
            {translate key=DefaultScheduleSet}
        </div>
        {block name="schedule_control"}
            <div class="row">
                {assign var=titleWidth value="col-sm-12 col-xs-12"}
                {if !$HideSchedule}
                    {assign var=titleWidth value="col-sm-6 col-xs-12"}
                    <div id="schedule-actions" class="col-sm-3 col-xs-12">
                        {block name="actions"}
                            <a href="#" id="print_schedule" title="{translate key=Print}"><span
                                        class="fa fa-print"></span></a>
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

                <div id="schedule-title" class="schedule_title {$titleWidth} col-xs-12">
                    <label for="schedules" class="no-show">Schedule</label>
                    <select id="schedules" class="form-control" style="width:auto;">
                        {foreach from=$Schedules item=schedule}
                            <option value="{$schedule->GetId()}"
                                    {if $schedule->GetId() == $ScheduleId}selected="selected"{/if}>{$schedule->GetName()}</option>
                        {/foreach}
                    </select>
                    <a href="#" id="calendar_toggle" title="{translate key=ShowHideNavigation}">
                        <span class="glyphicon glyphicon-calendar"></span>
                        <span class="no-show">{translate key=ShowHideNavigation}</span>
                    </a>
                    <div id="individualDates">
                        <div class="checkbox inline">
                            <input type='checkbox' id='multidateselect'/>
                            <label for='multidateselect'>{translate key=SpecificDates}</label>
                        </div>
                        <a class="btn btn-default btn-sm" href="#" id="individualDatesGo"><i
                                    class="fa fa-angle-double-right"></i>
                            <span class="no-show">{translate key=SpecificDates}</span>
                        </a>
                    </div>
                    <div id="individualDatesList"></div>
                </div>

                {capture name="date_navigation"}
                    {if !$HideSchedule}
                        <div class="schedule-dates col-sm-3 col-xs-12">
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
                               data-day="{$PreviousDate->Day()}">{html_image src="arrow_large_left.png" alt="{translate key=Back}"}</a>
                            {formatdate date=$FirstDate}
                            {if $ShowWeekNumbers}({$FirstDate->WeekNumber()}){/if}
                            -
                            {formatdate date=$LastDate}
                            {if $ShowWeekNumbers}({$LastDate->WeekNumber()}){/if}
                            <a href="#" class="change-date" data-year="{$NextDate->Year()}"
                               data-month="{$NextDate->Month()}"
                               data-day="{$NextDate->Day()}">{html_image src="arrow_large_right.png" alt="{translate key=Forward}"}</a>

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
            <div class="alert alert-warning center">
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
        {/if}

        {if $ScheduleAvailabilityLate}
            <div class="alert alert-warning center">
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
        {/if}

        {if !$HideSchedule}
            {block name="legend"}
                <div class="hidden-xs row col-sm-12 schedule-legend">
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
                <div id="reservations-left" class="col-md-2 col-sm-12 default-box">
                    <div class="reservations-left-header">{translate key=Filter}
                        <a href="#" class="pull-right toggle-sidebar" title="Hide Reservation Filter"><i
                                    class="glyphicon glyphicon-remove"></i>
                            <span class="no-show">Hide Reservation Filter</span>
                        </a>
                    </div>

                    <div class="reservations-left-content">
                        <form method="get" role="form" id="advancedFilter">

                            {if count($ResourceAttributes) + count($ResourceTypeAttributes) > 5}
                                <div>
                                    <input type="submit" value="{translate key=Filter}"
                                           class="btn btn-success btn-sm" {formname key=SUBMIT}/>
                                </div>
                            {/if}

                            <div>
                                {*<label>{translate key=Resource}</label>*}
                                <div id="resourceGroups"></div>
                            </div>

                            <div id="resettable">
                                {if $CanViewUsers}
                                    <div class="form-group col-xs-12">
                                        <label for="ownerFilter">{translate key=Owner}</label>
                                        <input type='search' id='ownerFilter'
                                               class="form-control input-sm search" {formname key=OWNER_TEXT} value="{$OwnerText}" />
                                        <input {formname key=USER_ID} id="ownerId" type="hidden" value="{$OwnerId}"/>
                                        <span class="searchclear searchclear-label glyphicon glyphicon-remove-circle" ref="ownerFilter,ownerId"></span>
                                    </div>
                                    {if $AllowParticipation}
                                        <div class="form-group col-xs-12">
                                            <label for="participantFilter">{translate key=Participant}</label>
                                            <input type='search' id='participantFilter'
                                                   class="form-control input-sm search" {formname key=PARTICIPANT_TEXT} value="{$ParticipantText}" />
                                            <input {formname key=PARTICIPANT_ID} id="participantId" type="hidden" value="{$ParticipantId}"/>
                                            <span class="searchclear searchclear-label glyphicon glyphicon-remove-circle" ref="participantFilter,participantId"></span>
                                        </div>
                                    {/if}
                                {/if}
                                <div class="form-group col-xs-12">
                                    <label for="maxCapactiy">{translate key=MinimumCapacity}</label>
                                    <input type='number' min='0' id='maxCapactiy' size='5' maxlength='5'
                                           class="form-control input-sm" {formname key=MAX_PARTICIPANTS}
                                           value="{$MaxParticipantsFilter}"/>
                                </div>

                                <div class="form-group col-xs-12">
                                    <label for="resourceType">{translate key=ResourceType}</label>
                                    <select id="resourceType" {formname key=RESOURCE_TYPE_ID} {formname key=RESOURCE_TYPE_ID}
                                            class="form-control input-sm">
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
                                    <button type="submit" class="btn btn-success btn-sm"
                                            value="submit">{translate key=Filter}</button>
                                </div>
                                <div class="btn-clear">
                                    <button id="show_all_resources" type="button"
                                            class="btn btn-default btn-xs">{translate key=ClearFilter}</button>
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

                <div id="reservations" class="col-md-10 col-sm-12">
                    <div>
                        <a href="#" id="restore-sidebar" title="Show Reservation Filter"
                           class="hidden toggle-sidebar">{translate key=ResourceFilter} <i
                                    class="glyphicon glyphicon-filter"></i> <i
                                    class="glyphicon glyphicon-chevron-right"></i></a>
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
        <div class="col-sm-9 visible-md visible-lg">&nbsp;</div>
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
    <input type="hidden" {formname key=RESOURCE_TYPE_ID} value="{$ResourceTypeIdFilter}"/>
    {foreach from=$ResourceAttributes item=attribute}
        <input type="hidden" name="RESOURCE_ATTRIBUTE_ID[{$attribute->Id()}]" value="{$attribute->Value()}"/>
    {/foreach}
    {foreach from=$ResourceTypeAttributes item=attribute}
        <input type="hidden" name="RESOURCE_TYPE_ATTRIBUTE_ID[{$attribute->Id()}]" value="{$attribute->Value()}"/>
    {/foreach}
    {foreach from=$ResourceIds item=id}
        <input type="hidden" {formname key=RESOURCE_ID multi=true} value="{$id}"/>
    {/foreach}
    <input type="hidden" {formname key=USER_ID} value="{$UserIdFilter}"/>
    <input type="hidden" {formname key=PARTICIPANT_ID} value="{$ParticipantIdFilter}"/>
    {csrf_token}
</form>

<div id="loading-schedule" class="no-show">Loading reservations...</div>

<button id="reservationsToTop" title="Go to top"><i class="fa fa-2x fa-arrow-circle-o-up"></i></button>

{include file="javascript-includes.tpl" Qtip=true Select2=true Owl=true Clear=true}

{block name="scripts-before"}

{/block}

{jsfile src="js/html2canvas.min.js"}
{jsfile src="js/moment.min.js"}
{jsfile src="schedule.js"}
{jsfile src="resourcePopup.js"}
{jsfile src="js/tree.jquery.js"}
{jsfile src="js/jquery.cookie.js"}
{jsfile src="autocomplete.js"}
{jsfile src="ajax-helpers.js"}
<script type="text/javascript">

    const scheduleOpts = {
        reservationUrlTemplate: "{$Path}{Pages::RESERVATION}?{QueryStringKeys::REFERENCE_NUMBER}=[referenceNumber]",
        summaryPopupUrl: "{$Path}ajax/respopup.php",
        setDefaultScheduleUrl: "{$Path}{Pages::PROFILE}?action=changeDefaultSchedule&{QueryStringKeys::SCHEDULE_ID}=[scheduleId]",
        cookieName: "{$CookieName}",
        scheduleId: "{$ScheduleId|escape:'javascript'}",
        scriptUrl: '{$ScriptUrl}',
        selectedResources: [{','|implode:$ResourceIds}],
        specificDates: [{foreach from=$SpecificDates item=d}'{$d->Format('Y-m-d')}',{/foreach}],
        updateReservationUrl: "{$Path}ajax/reservation_move.php",
        lockTableHead: "{$LockTableHead}",
        disableSelectable: "{$IsMobile}",
        reservationLoadUrl: "{$Path}{Pages::SCHEDULE}?{QueryStringKeys::DATA_REQUEST}=reservations",
        scheduleStyle: "{$ScheduleStyle}",
        midnightLabel: "{formatdate date=Date::Now()->GetDate() key=period_time}",
        isMobileView: "{$IsMobile && !$IsTablet}",
        newLabel: "{translate key=New}",
        updatedLabel: "{translate key=Updated}",
        isReservable: 1,
        autocompleteUrl: "{$Path}ajax/autocomplete.php?type={AutoCompleteType::User}",
    };

    const resourceOrder = [];
    let resourceIndex = 0;
    {foreach from=$Resources item=r}
    resourceOrder[{$r->GetId()}] = resourceIndex++;
    {/foreach}
    scheduleOpts.resourceOrder = resourceOrder;

    {if $LoadViewOnly}
    scheduleOpts.reservationUrlTemplate = "view-reservation.php?{QueryStringKeys::REFERENCE_NUMBER}=[referenceNumber]";
    scheduleOpts.reservationLoadUrl = "{$Path}{Pages::VIEW_SCHEDULE}?{QueryStringKeys::DATA_REQUEST}=reservations";
    scheduleOpts.isReservable = {if $AllowGuestBooking}1{else}0{/if};
    {/if}

    $(document).ready(function () {
        const schedule = new Schedule(scheduleOpts, {$ResourceGroupsAsJson});
        schedule.init();
    });

    $('#schedules').select2({
        width: 'resolve'
    });
</script>

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