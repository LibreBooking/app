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
	<td ref="{$slotRef}"
		class="pasttime slot"
		data-href="{$href}"
		data-start="{$Slot->BeginDate()->Format('Y-m-d H:i:s')|escape:url}"
		data-end="{$Slot->EndDate()->Format('Y-m-d H:i:s')|escape:url}"
		data-min="{$Slot->BeginDate()->Timestamp()}"
		data-max="{$Slot->EndDate()->Timestamp()}"
		data-resourceId="{$resourceId}">&nbsp;
	</td>
{/function}

{function name=displayReservable}
	<td class="reservable clickres slot"
		ref="{$slotRef}"
		data-href="{$href}"
		data-start="{$Slot->BeginDate()->Format('Y-m-d H:i:s')|escape:url}"
		data-end="{$Slot->EndDate()->Format('Y-m-d H:i:s')|escape:url}"
		data-min="{$Slot->BeginDate()->Timestamp()}"
		data-max="{$Slot->EndDate()->Timestamp()}"
		data-resourceId="{$resourceId}">&nbsp;
	</td>
{/function}

{function name=displayRestricted}
	<td ref="{$slotRef}"
		class="restricted slot"
		data-href="{$href}"
		data-start="{$Slot->BeginDate()->Format('Y-m-d H:i:s')|escape:url}"
		data-end="{$Slot->EndDate()->Format('Y-m-d H:i:s')|escape:url}"
		data-min="{$Slot->BeginDate()->Timestamp()}"
		data-max="{$Slot->EndDate()->Timestamp()}"
		data-resourceId="{$resourceId}">&nbsp;
	</td>
{/function}

{function name=displayUnreservable}
	<td ref="{$slotRef}"
		class="unreservable slot"
		data-href="{$href}"
		data-start="{$Slot->BeginDate()->Format('Y-m-d H:i:s')|escape:url}"
		data-end="{$Slot->EndDate()->Format('Y-m-d H:i:s')|escape:url}"
		data-min="{$Slot->BeginDate()->Timestamp()}"
		data-max="{$Slot->EndDate()->Timestamp()}"
		data-resourceId="{$resourceId}">&nbsp;
	</td>
{/function}

{function name=displaySlot}
    {call name=$DisplaySlotFactory->GetFunction($Slot, $AccessAllowed) Slot=$Slot Href=$Href SlotRef=$SlotRef ResourceId=$ResourceId}
{/function}

{* End slot display formatting *}

{block name="header"}
    {include file='globalheader.tpl' Qtip=true FloatThead=true Select2=true cssFiles='scripts/css/jqtree.css' Owl=true printCssFiles='css/schedule.print.css' FullWidth=true}
{/block}

<div id="page-schedule" class="row">

    {assign var=startTime value=microtime(true)}

    {if $ShowResourceWarning}
		<div class="col s12 m8 offset-m2 card error no-resource-warning">
			<div class="card-content center">
				<span class="fas fa-exclamation-triangle"></span> {translate key=NoResources}
				<div class="margin-top-25"><a href="admin/manage_resources.php"
											  class="btn waves-effect waves-light grey lighten-3 black-text">{translate key=AddResource}</a>
				</div>
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
							<a class="dropdown-trigger btn btn-flat black-text" href="#" data-target="change-display-dropdown">{translate key=ChangeDisplayStyle} <span class="fas fa-caret-down"></span></a>
							<ul id="change-display-dropdown" class="dropdown-content">
							    <li><a href="#" class="schedule-style" id="schedule_standard" data-schedule-display="{ScheduleStyle::Standard}"><span class="fas fa-table"></span> Standard</a></li>
							    <li><a href="#" class="schedule-style" id="schedule_tall" data-schedule-display="{ScheduleStyle::Tall}"><span class="fas fa-arrows-alt-v"></span> Tall</a></li>
							    <li><a href="#" class="schedule-style" id="schedule_wide" data-schedule-display="{ScheduleStyle::Wide}"><span class="fas fa-arrows-alt-h"></span> Wide</a></li>
							    <li><a href="#" class="schedule-style" id="schedule_week" data-schedule-display="{ScheduleStyle::CondensedWeek}"><span class="fas fa-calendar-week"></span> Condensed</a></li>
							  </ul>
							<div>
                                {if $SubscriptionUrl != null && $ShowSubscription}
									<i class="material-icons">rss_feed</i>
									<a target="_blank" href="{$SubscriptionUrl->GetAtomUrl()}">Atom</a>
									|
									<a target="_blank" href="{$SubscriptionUrl->GetWebcalUrl()}">iCalendar</a>
                                {/if}
							</div>
                        {/block}
					</div>
                {/if}

				<div id="schedule-title" class="schedule_title col {$titleWidth} s12">
					<div class="inline-block">
						<label for="schedules" class="no-show">Schedule</label>
						<select id="schedules" style="width:auto;">
                            {foreach from=$Schedules item=schedule}
								<option value="{$schedule->GetId()}"
                                        {if $schedule->GetId() == $ScheduleId}selected="selected"{/if}>{$schedule->GetName()}</option>
                            {/foreach}
						</select>
					</div>
					<a href="#" id="calendar_toggle" title="{translate key=ShowHideNavigation}" class="inline-block">
						<i class="material-icons">date_range</i>
						<span class="no-show">{translate key=ShowHideNavigation}</span>
					</a>
					<a href="#" id="make_default" title="{translate key=MakeDefaultSchedule}" style="display:none;"><i class="material-icons">star</i></a>
					<div id="individualDates">
						<div class="inline">
							<label for='multidateselect'>
								<input type="checkbox" id="multidateselect"/>
								<span>{translate key=SpecificDates}</span>
							</label>
						</div>
						<a class="" href="#" id="individualDatesGo">
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
							<a href="#" class="change-date" data-year="{$TodaysDate->Year()}"
							   data-month="{$TodaysDate->Month()}" data-day="{$TodaysDate->Day()}"
							   title="{translate key=Today}"><span class="fas fa-home"></span>
								<span class="no-show">{translate key=Today}</span>
							</a>
                            {assign var=FirstDate value=$DisplayDates->GetBegin()}
                            {assign var=LastDate value=$DisplayDates->GetEnd()->AddDays(-1)}
							<a href="#" class="change-date" data-year="{$PreviousDate->Year()}"
							   data-month="{$PreviousDate->Month()}"
							   data-day="{$PreviousDate->Day()}" title="{translate key=Back}"><span class="fas fa-arrow-circle-left"></span></a>
                            {formatdate date=$FirstDate} - {formatdate date=$LastDate}
							<a href="#" class="change-date" data-year="{$NextDate->Year()}"
							   data-month="{$NextDate->Month()}"
							   data-day="{$NextDate->Day()}" title="{translate key=Next}"><span class="fas fa-arrow-circle-right"></span></a>

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
								<label>{translate key=Resources}</label>
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
    {csrf_token}
</form>

<div id="loading-schedule" class="no-show">Loading reservations...</div>

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
			lockTableHead: "{$LockTableHead}",
			disableSelectable: "{$IsMobile}",
			reservationLoadUrl: "{$Path}{Pages::SCHEDULE}?{QueryStringKeys::DATA_REQUEST}=reservations",
			scheduleStyle: "{$ScheduleStyle}",
			midnightLabel: "{formatdate date=Date::Now()->GetDate() key=period_time}",
			isMobileView: "{$IsMobile && !$IsTablet}",
			newLabel: "{translate key=New}",
			updatedLabel: "{translate key=Updated}"
		};

        {if $LoadViewOnly}
		$(document).ready(function () {
			scheduleOpts.reservationUrlTemplate = "view-reservation.php?{QueryStringKeys::REFERENCE_NUMBER}=[referenceNumber]";
			scheduleOpts.reservationLoadUrl = "{$Path}{Pages::VIEW_SCHEDULE}?{QueryStringKeys::DATA_REQUEST}=reservations";

			var schedule = new Schedule(scheduleOpts, {$ResourceGroupsAsJson});
            {if $AllowGuestBooking}
			schedule.init();
			schedule.initUserDefaultSchedule(true);
            {else}
			schedule.initNavigation();
			schedule.initRotateSchedule();
			schedule.initReservable();
			schedule.initResourceFilter();
			schedule.initResources();
			schedule.initUserDefaultSchedule(true);
            {/if}
		});
        {else}
		$(document).ready(function () {
			var schedule = new Schedule(scheduleOpts, {$ResourceGroupsAsJson});
			schedule.init();
		});
        {/if}

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