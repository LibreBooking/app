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

{* All of the slot display formatting *}

{function name=displayGeneralReserved}
	{if $Slot->IsPending()}
		{assign var=class value='pending'}
	{/if}
	{if $Slot->HasCustomColor()}
		{assign var=color value='style="background-color:'|cat:$Slot->Color()|cat:';color:'|cat:$Slot->TextColor()|cat:';"'}
	{/if}
	<td {$spantype|default:'col'}span="{$Slot->PeriodSpan()}" class="reserved {$class} {$OwnershipClass} clickres slot"
		resid="{$Slot->Id()}" {$color}
		id="{$Slot->Id()}|{$Slot->Date()->Format('Ymd')}">{$Slot->Label($SlotLabelFactory)|escapequotes}</td>
{/function}

{function name=displayMyReserved}
	{call name=displayGeneralReserved Slot=$Slot Href=$Href SlotRef=$SlotRef OwnershipClass='mine'}
{/function}

{function name=displayMyParticipating}
	{call name=displayGeneralReserved Slot=$Slot Href=$Href SlotRef=$SlotRef OwnershipClass='participating'}
{/function}

{function name=displayReserved}
	{call name=displayGeneralReserved Slot=$Slot Href=$Href SlotRef=$SlotRef OwnershipClass=''}
{/function}

{function name=displayPastTime}
	<td {$spantype|default:'col'}span="{$Slot->PeriodSpan()}" ref="{$SlotRef}"
		class="pasttime slot">{$Slot->Label($SlotLabelFactory)|escapequotes}</td>
{/function}

{function name=displayReservable}
	<td {$spantype|default:'col'}span="{$Slot->PeriodSpan()}" ref="{$SlotRef}" class="reservable clickres slot" data-href="{$Href}"
		data-start="{$Slot->BeginDate()->Format('Y-m-d H:i:s')|escape:url}" data-end="{$Slot->EndDate()->Format('Y-m-d H:i:s')|escape:url}">&nbsp;</td>
{/function}

{function name=displayRestricted}
	<td {$spantype|default:'col'}span="{$Slot->PeriodSpan()}" class="restricted slot">&nbsp;</td>
{/function}

{function name=displayUnreservable}
	<td {$spantype|default:'col'}span="{$Slot->PeriodSpan()}"
		class="unreservable slot">{$Slot->Label($SlotLabelFactory)|escape}</td>
{/function}

{function name=displaySlot}
	{call name=$DisplaySlotFactory->GetFunction($Slot, $AccessAllowed) Slot=$Slot Href=$Href SlotRef=$SlotRef}
{/function}

{* End slot display formatting *}

{block name="header"}
	{include file='globalheader.tpl' Qtip=true cssFiles='scripts/css/jqtree.css'}
{/block}

<div id="page-schedule">

	{if $ShowResourceWarning}
		<div class="alert alert-warning no-resource-warning"><span class="fa fa-warning"></span> {translate key=NoResources} <a href="admin/manage_resources.php">{translate key=AddResource}</a></div>
	{/if}

	{if $IsAccessible}

	<div id="defaultSetMessage" class="alert alert-success hidden">
		{translate key=DefaultScheduleSet}
	</div>

	{block name="schedule_control"}
		<div class="row-fluid">
			<div id="schedule-actions" class="col-md-3 visible-md visible-lg">
				{block name="actions"}
					<a href="#" id="make_default" style="display:none;">{html_image src="star_boxed_full.png" altKey="MakeDefaultSchedule"}</a>
					<a href="#" class="schedule-style" id="schedule_standard"
					   schedule-display="{ScheduleStyle::Standard}">{html_image src="table.png" altKey="StandardScheduleDisplay"}</a>
					<a href="#" class="schedule-style" id="schedule_tall"
					   schedule-display="{ScheduleStyle::Tall}">{html_image src="table-tall.png" altKey="TallScheduleDisplay"}</a>
					<a href="#" class="schedule-style" id="schedule_wide"
					   schedule-display="{ScheduleStyle::Wide}">{html_image src="table-wide.png" altKey="WideScheduleDisplay"}</a>
					<a href="#" class="schedule-style" id="schedule_week"
					   schedule-display="{ScheduleStyle::CondensedWeek}">{html_image src="table-week.png" altKey="CondensedWeekScheduleDisplay"}</a>
					<div>
						{if $SubscriptionUrl != null}
							{html_image src="feed.png"}
							<a target="_blank" href="{$SubscriptionUrl->GetAtomUrl()}">Atom</a>
							|
							<a target="_blank" href="{$SubscriptionUrl->GetWebcalUrl()}">iCalendar</a>
						{/if}
					</div>
				{/block}
			</div>

			<div id="schedule-title" class="schedule_title col-md-6">
				<span>{$ScheduleName}</span>
				{if $Schedules|@count gt 1}
					<div class="dropdown btn-group">
						<a class="btn dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret dropdown-toggle"></span></a>
						<ul class="dropdown-menu" role="menu">
							{foreach from=$Schedules item=schedule}
								<li><a href="#" class="schedule-id" data-scheduleid="{$schedule->GetId()}">{$schedule->GetName()}</a></li>
							{/foreach}
						</ul>
					</div>
				{/if}
				<a href="#" id="calendar_toggle" title="{translate key=ShowHideNavigation}"><span class="glyphicon glyphicon-calendar"></span></a>
			</div>

			{capture name="date_navigation"}
				<div class="schedule-dates col-md-3">
					{assign var=FirstDate value=$DisplayDates->GetBegin()}
					{assign var=LastDate value=$DisplayDates->GetEnd()->AddDays(-1)}
					<a href="#" class="change-date" data-year="{$PreviousDate->Year()}" data-month="{$PreviousDate->Month()}"
					   data-day="{$PreviousDate->Day()}">{html_image src="arrow_large_left.png" alt="Back"}</a>
					{formatdate date=$FirstDate} - {formatdate date=$LastDate}
					<a href="#" class="change-date" data-year="{$NextDate->Year()}" data-month="{$NextDate->Month()}"
					   data-day="{$NextDate->Day()}">{html_image src="arrow_large_right.png" alt="Forward"}</a>

					{if $ShowFullWeekLink}
						<a href="{add_querystring key=SHOW_FULL_WEEK value=1}"
						   id="showFullWeek">({translate key=ShowFullWeek})</a>
					{/if}
				</div>
			{/capture}

			{$smarty.capture.date_navigation}
		</div>
		<div type="text" id="datepicker" style="display:none;"></div>
	{/block}

	{block name="legend"}
		<div class="hidden-xs row-fluid col-sm-12">
			<div class="center">
				<div class="legend reservable">{translate key=Reservable}</div>
				<div class="legend unreservable">{translate key=Unreservable}</div>
				<div class="legend reserved">{translate key=Reserved}</div>
				<div class="legend reserved mine">{translate key=MyReservation}</div>
				<div class="legend reserved participating">{translate key=Participant}</div>
				<div class="legend reserved pending">{translate key=Pending}</div>
				<div class="legend pasttime">{translate key=Past}</div>
				<div class="legend restricted">{translate key=Restricted}</div>
			</div>
		</div>
		<div style="height:10px" class="hidden-xs row">&nbsp;</div>
	{/block}

	<div class="row-fluid">
		{if $IsDesktop}
			<div id="reservations-left" class="col-md-2 default-box">
				<div class="reservations-left-header">{translate key=ResourceFilter} <a href="#" class="pull-right toggle-sidebar"
																						title="Hide Reservation Filter"><i
								class="glyphicon glyphicon-remove"></i></a></div>

				<div class="reservations-left-content">
					<div class="form-group">
						<label for="resourceIdFilter">Resource Type</label>
						<select {formname key=RESOURCE_ID} id="resourceIdFilter" class="form-control input-sm">
							<option value="">- {translate key=All} -</option>
							{object_html_options options=$Resources label='Name' key='Id' usemethod=false selected=$ResourceIdFilter}
						</select>
					</div>

					<div>
						<div id="resourceGroups"></div>
					</div>

					<form method="POST" role="form" id="advancedFilter">
						<hr/>

						<div>
							<div class="form-group">
								<label for="maxCapactiy">{translate key=MinimumCapacity}</label>
								<input type='text' id='maxCapactiy' size='5' maxlength='5' class="form-control input-sm" {formname key=MAX_PARTICIPANTS}
									   value="{$MaxParticipantsFilter}"/>
							</div>

							<div class="form-group">
								<label for="resourceType">{translate key=ResourceType}</label>
								<select id="resourceType" {formname key=RESOURCE_TYPE_ID} {formname key=RESOURCE_TYPE_ID} class="form-control input-sm">
									<option value="">- {translate key=All} -</option>
									{object_html_options options=$ResourceTypes label='Name' key='Id' selected=$ResourceTypeIdFilter}
								</select>
							</div>

							{foreach from=$ResourceAttributes item=attribute}
								<div class="form-group">
									{control type="AttributeControl" attribute=$attribute align='vertical' searchmode=true namePrefix='r' class="input-sm"}
								</div>
							{/foreach}

							{foreach from=$ResourceTypeAttributes item=attribute}
								<div class="form-group">{control type="AttributeControl" attribute=$attribute align='vertical' searchmode=true namePrefix='rt' class="input-sm"}</div>
							{/foreach}

							<div class="btn-submit">
								<button type="submit" class="btn btn-success btn-sm" value="submit" {formname key=SUBMIT}>{translate key=Filter}</button>
							</div>
							<div class="btn-clear">
								<button id="show_all_resources" type="button" class="btn btn-default btn-xs">{translate key=ClearFilter}</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		{/if}

		<div id="reservations" class="col-md-10 col-sm-12">
			<div ><a href="#" id="restore-sidebar" title="Show Reservation Filter" class="hidden toggle-sidebar">{translate key=ResourceFilter}  <i class="glyphicon glyphicon-filter"></i> <i
									class="glyphicon glyphicon-chevron-right"></i></a>
			</div>
			{block name="reservations"}
				{assign var=TodaysDate value=Date::Now()}
				{foreach from=$BoundDates item=date}
					<div style="position:relative;">
						<table class="reservations" border="1" cellpadding="0" width="100%">
							{if $date->DateEquals($TodaysDate)}
							<tr class="today">
								{else}
							<tr>
								{/if}
								<td class="resdate">{formatdate date=$date key="schedule_daily"}</td>
								{foreach from=$DailyLayout->GetPeriods($date, true) item=period}
									<td class="reslabel" colspan="{$period->Span()}">{$period->Label($date)}</td>
								{/foreach}
							</tr>
							{foreach from=$Resources item=resource name=resource_loop}
								{assign var=resourceId value=$resource->Id}
								{assign var=slots value=$DailyLayout->GetLayout($date, $resourceId)}
								{assign var=href value="{Pages::RESERVATION}?rid={$resource->Id}&sid={$ScheduleId}&rd={formatdate date=$date key=url}"}
								<tr class="slots">
									<td class="resourcename">
										{if $resource->CanAccess && $DailyLayout->IsDateReservable($date)}
											<a href="{$href}" resourceId="{$resource->Id}"
											   class="resourceNameSelector">{$resource->Name}</a>
										{else}
											{$resource->Name}
										{/if}
									</td>
									{foreach from=$slots item=slot}
										{assign var=slotRef value="{$slot->BeginDate()->Format('YmdHis')}{$resourceId}"}
										{displaySlot Slot=$slot Href="$href" AccessAllowed=$resource->CanAccess SlotRef=$slotRef}
									{/foreach}
								</tr>
							{/foreach}
						</table>
					</div>
					{flush}
				{/foreach}
			{/block}
			{else}
			<div class="error">{translate key=NoResourcePermission}</div>
			{/if}
		</div>
	</div>

	<div class="clearfix">&nbsp;</div>
	<input type="hidden" value="{$ScheduleId}" id="scheduleId"/>

	<div class="row">
		<div class="col-xs-9 visible-md visible-lg">&nbsp;</div>
		{$smarty.capture.date_navigation}
	</div>
</div>

{block name="scripts-before"}

{/block}

{block name="scripts-common"}
	{jsfile src="js/moment.min.js"}
	{jsfile src="schedule.js"}
	{jsfile src="resourcePopup.js"}
	{jsfile src="js/tree.jquery.js"}
	{jsfile src="js/jquery.cookie.js"}
	<script type="text/javascript">

		$(document).ready(function ()
		{
			var scheduleOpts = {
				reservationUrlTemplate: "{$Path}{Pages::RESERVATION}?{QueryStringKeys::REFERENCE_NUMBER}=[referenceNumber]",
				summaryPopupUrl: "{$Path}ajax/respopup.php",
				setDefaultScheduleUrl: "{$Path}{Pages::PROFILE}?action=changeDefaultSchedule&{QueryStringKeys::SCHEDULE_ID}=[scheduleId]",
				cookieName: "{$CookieName}",
				scheduleId: "{$ScheduleId}"
			};

			var schedule = new Schedule(scheduleOpts, {$ResourceGroupsAsJson});
			schedule.init();


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
