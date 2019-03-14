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

{include file='globalheader.tpl' Timepicker=true}
<div id="page-manage-blackouts" class="admin-page">
	<h1>{translate key=ManageBlackouts}</h1>

	<form id="addBlackoutForm" class="form-inline" role="form" method="post">
		<div class="panel panel-default" id="add-blackout-panel">
			<div class="panel-heading">{translate key="AddBlackout"} {showhide_icon}</div>
			<div class="panel-body add-contents">

				<div class="form-group col-xs-6">
					<label for="addStartDate">{translate key=BeginDate}</label>
					<input type="text" id="addStartDate" class="form-control dateinput inline-block "
						   value="{formatdate date=$AddStartDate}"/>
					<input {formname key=BEGIN_DATE} id="formattedAddStartDate" type="hidden"
													 value="{formatdate date=$AddStartDate key=system}"/>
					<input {formname key=BEGIN_TIME} type="text" id="addStartTime"
													 class="form-control dateinput inline-block timepicker"
													 value="{format_date format='h:00 A' date=now}" title="{translate key=StartTime}"/>
                    <label for="addStartTime" class="no-show">{translate key=StartTime}</label>
				</div>
				<div class="form-group col-xs-6">
					<label for="addEndDate">{translate key=EndDate}</label>
					<input type="text" id="addEndDate" class="form-control dateinput inline-block " size="10"
						   value="{formatdate date=$AddEndDate}"/>
					<input {formname key=END_DATE} type="hidden" id="formattedAddEndDate"
												   value="{formatdate date=$AddEndDate key=system}"/>
					<input {formname key=END_TIME} type="text" id="addEndTime"
												   class="form-control dateinput inline-block timepicker"
												   value="{format_date format='h:00 A' date=Date::Now()->AddHours(1)}"
												   title="{translate key=EndTime}"/>
                    <label for="addEndTime" class="no-show">{translate key=EndTime}</label>
                </div>
				<div class="form-group col-xs-12">
					<label for="addResourceId">{translate key=Resource}</label>
					<select {formname key=RESOURCE_ID} class="form-control" id="addResourceId">
						{object_html_options options=$Resources key='GetId' label="GetName" selected=$ResourceId}
					</select>
					{if $Schedules|count > 0}
						|
						<div class="checkbox">
							<input {formname key=BLACKOUT_APPLY_TO_SCHEDULE} type="checkbox" id="allResources"/>
							<label for="allResources" style="">{translate key=AllResourcesOn} </label>
						</div>
                        <label for="addScheduleId" class="no-show">{translate key=Schedule} </label>
                        <select {formname key=SCHEDULE_ID} id="addScheduleId" class="form-control" disabled="disabled"
														   title="{translate key=Schedule}">
							{object_html_options options=$Schedules key='GetId' label="GetName" selected=$ScheduleId}
						</select>
					{/if}
				</div>
				<div class="col-xs-12">
					<div class="form-group has-feedback">
						<label for="blackoutReason">{translate key=Reason}</label>
						<input {formname key=SUMMARY} type="text" id="blackoutReason" required
													  class="form-control required"/>
						<i class="glyphicon glyphicon-asterisk form-control-feedback" data-bv-icon-for="blackoutReason"></i>
					</div>
				</div>
				<div class="form-group col-xs-12">
					{control type="RecurrenceControl" RepeatTerminationDate=$RepeatTerminationDate}
				</div>
				<div class="form-group col-xs-12">
					<div class="radio">
						<input {formname key=CONFLICT_ACTION} type="radio" id="bookAround"
															  name="existingReservations"
															  checked="checked"
															  value="{ReservationConflictResolution::BookAround}"/>
						<label for="bookAround">{translate key=BlackoutAroundConflicts}</label>
					</div>
					<div class="radio">
						<input {formname key=CONFLICT_ACTION} type="radio" id="notifyExisting"
															  name="existingReservations"
															  value="{ReservationConflictResolution::Notify}"/>
						<label for="notifyExisting">{translate key=BlackoutShowMe}</label>
					</div>
					<div class="radio">
						<input {formname key=CONFLICT_ACTION} type="radio" id="deleteExisting"
															  name="existingReservations"
															  value="{ReservationConflictResolution::Delete}"/>
						<label for="deleteExisting">{translate key=BlackoutDeleteConflicts}</label>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				{add_button class="btn-sm"}
				{reset_button class="btn-sm"}
			</div>
		</div>
	</form>

	<form class="form" role="form">
		<div class="panel panel-default">
			<div class="panel-heading"><span class="glyphicon glyphicon-filter"></span>
				{translate key="Filter"}
			</div>
			<div class="panel-body">
				<div class="form-group col-xs-4">
					<input id="startDate" type="text" class="form-control dateinput inline-block"
						   value="{formatdate date=$StartDate}"
						   title="Between start date" placeholder="{translate key=BeginDate}"/>
					<input id="formattedStartDate" type="hidden" value="{formatdate date=$StartDate key=system}"/>
					-
					<input id="endDate" type="text" class="form-control dateinput inline-block"
						   value="{formatdate date=$EndDate}" placeholder="{translate key=EndDate}"/>
					<input id="formattedEndDate" type="hidden" value="{formatdate date=$EndDate key=system}"/>
                    <label for="startDate" class="no-show">{translate key=StartDate}</label>
                    <label for="endDate" class="no-show">{translate key=EndDate}</label>

                </div>
				<div class="form-group col-xs-4">
                    <label for="scheduleId" class="no-show">{translate key=Schedule} </label>

                    <select id="scheduleId" class="form-control col-xs-12">
						<option value="">{translate key=AllSchedules}</option>
						{object_html_options options=$Schedules key='GetId' label="GetName" selected=$ScheduleId}
					</select>
				</div>
				<div class="form-group col-xs-4">
                    <label for="resourceId" class="no-show">{translate key=Resource} </label>

                    <select id="resourceId" class="form-control col-xs-12">
						<option value="">{translate key=AllResources}</option>
						{object_html_options options=$Resources key='GetId' label="GetName" selected=$ResourceId}
					</select>
				</div>
			</div>
			<div class="panel-footer">
				{filter_button class="btn-sm" id="filter"}
				<button id="showAll" class="btn btn-link btn-sm">{translate key=ViewAll}</button>
			</div>
		</div>
	</form>

	<table class="table" id="blackoutTable">
		<thead>
		<tr>
			<th>{sort_column key=Resource field=ColumnNames::RESOURCE_NAME}</th>
			<th>{sort_column key=BeginDate field=ColumnNames::BLACKOUT_START}</th>
			<th>{sort_column key=EndDate field=ColumnNames::BLACKOUT_END}</th>
			<th>{sort_column key=Reason field=ColumnNames::BLACKOUT_TITLE}</th>
			<th>{translate key=CreatedBy}</th>
			<th>{translate key=Update}</th>
			<th>{translate key=Delete}</th>
			<th class="action-delete">
				<div class="checkbox checkbox-single">
					<input type="checkbox" id="delete-all" aria-label="{translate key=All}"/>
					<label for="delete-all" class="no-show">All</label>
				</div>
			</th>
		</tr>
		</thead>
		<tbody>
		{foreach from=$blackouts item=blackout}
			{cycle values='row0,row1' assign=rowCss}
			{assign var=id value=$blackout->InstanceId}
			<tr class="{$rowCss} editable" data-blackout-id="{$id}">
				<td>{$blackout->ResourceName}</td>
				<td class="date">{formatdate date=$blackout->StartDate timezone=$Timezone key=res_popup}</td>
				<td class="date">{formatdate date=$blackout->EndDate timezone=$Timezone key=res_popup}</td>
				<td>{$blackout->Title}</td>
				<td style="max-width:150px;">{fullname first=$blackout->FirstName last=$blackout->LastName}</td>
				<td class="update edit"><a href="#"><span class="fa fa-edit"></span></a></td>
				{if $blackout->IsRecurring}
					<td class="update">
						<a href="#" class="update delete-recurring"><span class="fa fa-trash icon remove"></span></a>
					</td>
				{else}
					<td class="update">
						<a href="#" class="update delete"><span class="fa fa-trash icon remove"></span></a>
					</td>
				{/if}
				<td class="action-delete">
					<div class="checkbox checkbox-single">
						<input {formname key=BLACKOUT_INSTANCE_ID multi=true} class="delete-multiple" type="checkbox" id="delete{$id}"
						value="{$id}"
						aria-label="{translate key=Delete}"/>
						<label for="delete{$id}" class="no-show">Delete</label>
					</div>
				</td>
			</tr>
		{/foreach}
		</tbody>
		<tfoot>
		<tr>
			<td colspan="7"></td>
			<td class="action-delete"><a href="#" id="delete-selected" class="no-show" title="{translate key=Delete}">{translate key=Delete}<span class="fa fa-trash icon remove"></span></a></td>
		</tr>
		</tfoot>
	</table>

	{pagination pageInfo=$PageInfo}

	<div class="modal fade" id="deleteDialog" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="deleteModalLabel">{translate key=Delete}</h4>
				</div>
				<div class="modal-body">
					<div class="alert alert-warning">
						{translate key=DeleteWarning}
					</div>
				</div>
				<div class="modal-footer">
					<form id="deleteForm" method="post">
						{cancel_button}
						{delete_button class="btnUpdateAllInstances"}
					</form>

				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="deleteRecurringDialog" tabindex="-1" role="dialog" aria-labelledby="deleteRecurringModalLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="deleteRecurringModalLabel">{translate key=Delete}</h4>
				</div>
				<div class="modal-body">
					<div class="alert alert-warning">
						{translate key=DeleteWarning}
					</div>
				</div>
				<div class="modal-footer">
					<form id="deleteRecurringForm" method="post">
						<button type="button" class="btn btn-default cancel"
								data-dismiss="modal">{translate key='Cancel'}</button>

						<button type="button" class="btn btn-danger save btnUpdateThisInstance">
							<span class="fa fa-remove"></span> {translate key='ThisInstance'}</button>

						<button type="button" class="btn btn-danger save btnUpdateAllInstances">
							<span class="fa fa-remove"></span> {translate key='AllInstances'}</button>

						<input type="hidden" {formname key=SERIES_UPDATE_SCOPE} class="hdnSeriesUpdateScope"
							   value="{SeriesUpdateScope::FullSeries}"/>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div id="deleteMultipleDialog" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="deleteMultipleModalLabel"
		 aria-hidden="true">
		<form id="deleteMultipleForm" method="post" action="{$smarty.server.SCRIPT_NAME}?action={ManageBlackoutsActions::DELETE_MULTIPLE}">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="deleteMultipleModalLabel">{translate key=Delete} (<span id="deleteMultipleCount"></span>)</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-warning">
							<div>{translate key=DeleteWarning}</div>
						</div>

					</div>
					<div class="modal-footer">
						{cancel_button}
						{delete_button}
						{indicator}
					</div>
					<div id="deleteMultiplePlaceHolder" class="no-show"></div>
				</div>
			</div>
		</form>
	</div>

	{csrf_token}
    {include file="javascript-includes.tpl" Timepicker=true}

	{jsfile src="reservationPopup.js"}
	{jsfile src="ajax-helpers.js"}
	{jsfile src="admin/blackouts.js"}
	{jsfile src="date-helper.js"}
	{jsfile src="recurrence.js"}

	<script type="text/javascript">

		$(document).ready(function () {
			var updateScope = {};
			updateScope.instance = '{SeriesUpdateScope::ThisInstance}';
			updateScope.full = '{SeriesUpdateScope::FullSeries}';
			updateScope.future = '{SeriesUpdateScope::FutureInstances}';

			var actions = {};

			var blackoutOpts = {
				scopeOpts: updateScope,
				actions: actions,
				deleteUrl: '{$smarty.server.SCRIPT_NAME}?action={ManageBlackoutsActions::DELETE}&{QueryStringKeys::BLACKOUT_ID}=',
				addUrl: '{$smarty.server.SCRIPT_NAME}?action={ManageBlackoutsActions::ADD}',
				editUrl: '{$smarty.server.SCRIPT_NAME}?action={ManageBlackoutsActions::LOAD}&{QueryStringKeys::BLACKOUT_ID}=',
				updateUrl: '{$smarty.server.SCRIPT_NAME}?action={ManageBlackoutsActions::UPDATE}',
				reservationUrlTemplate: "{$Path}reservation.php?{QueryStringKeys::REFERENCE_NUMBER}=[refnum]",
				popupUrl: "{$Path}ajax/respopup.php",
				timeFormat: '{$TimeFormat}'
			};

			var recurOpts = {
				repeatType: '{$RepeatType}',
				repeatInterval: '{$RepeatInterval}',
				repeatMonthlyType: '{$RepeatMonthlyType}',
				repeatWeekdays: [{foreach from=$RepeatWeekdays item=day}{$day}, {/foreach}]
			};

			var recurElements = {
				beginDate: $('#formattedAddStartDate'), endDate: $('#formattedAddEndDate'), beginTime: $('#addStartTime'), endTime: $('#addEndTime')
			};

			var recurrence = new Recurrence(recurOpts, recurElements);
			recurrence.init();

			var blackoutManagement = new BlackoutManagement(blackoutOpts);
			blackoutManagement.init();

			$('#add-blackout-panel').showHidePanel();
		});

		$.blockUI.defaults.css.width = '60%';
		$.blockUI.defaults.css.left = '20%';
	</script>

	{control type="DatePickerSetupControl" ControlId="startDate" AltId="formattedStartDate"}
	{control type="DatePickerSetupControl" ControlId="endDate" AltId="formattedEndDate"}
	{control type="DatePickerSetupControl" ControlId="addStartDate" AltId="formattedAddStartDate"}
	{control type="DatePickerSetupControl" ControlId="addEndDate" AltId="formattedAddEndDate"}
	{control type="DatePickerSetupControl" ControlId="EndRepeat" AltId="formattedEndRepeat"}

	<div id="wait-box" class="wait-box">
		<div id="creatingNotification">
			<h3>
				{block name="ajaxMessage"}
					{translate key=Working}...
				{/block}
			</h3>
			{html_image src="reservation_submitting.gif"}
		</div>
		<div id="result"></div>
	</div>

	<div id="update-box" class="no-show">
		{indicator id="update-spinner"}
		<div id="update-contents"></div>
	</div>

</div>
{include file='globalfooter.tpl'}
