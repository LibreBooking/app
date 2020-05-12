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

{include file='globalheader.tpl' Timepicker=true}
<div id="page-manage-blackouts" class="admin-page row">

	<div>
		<div class="right">
			<button class="add-blackout-prompt btn admin-action-button waves-effect waves-light" id="add-blackout-prompt">
                {translate key="AddBlackout"}
				<span class="fas fa-plus-circle icon"></span>
			</button>
		</div>
		<h1 class="page-title underline">{translate key=ManageBlackouts}</h1>
	</div>

	<form class="form" role="form">
		<div class="card" id="filter-blackout-panel">
			<div class="card-content">
				<div class="card-title">{translate key="FindBlackouts"} {showhide_icon}</div>
				<div class="panel-body">
					<div class="col s4">
						<div class="input-field inline">
							<label for="startDate">{translate key=BeginDate}</label>

							<input id="startDate" type="search" class="dateinput"
								   value="{formatdate date=$StartDate}"/>
							<input id="formattedStartDate" type="hidden"
								   value="{formatdate date=$StartDate key=system}"/>
						</div>
						-
						<div class="input-field inline">
							<label for="endDate">{translate key=EndDate}</label>
							<input id="endDate" type="search" class="dateinput"
								   value="{formatdate date=$EndDate}"/>
							<input id="formattedEndDate" type="hidden" value="{formatdate date=$EndDate key=system}"/>

						</div>
					</div>
					<div class="input-field col s4">
						<label for="scheduleId" class="active">{translate key=Schedule} </label>

						<select id="scheduleId" class="form-control col-xs-12">
							<option value="">{translate key=AllSchedules}</option>
                            {object_html_options options=$Schedules key='GetId' label="GetName" selected=$ScheduleId}
						</select>
					</div>
					<div class="input-field col s4">
						<label for="resourceId" class="active">{translate key=Resource} </label>

						<select id="resourceId" class="form-control col-xs-12">
							<option value="">{translate key=AllResources}</option>
                            {object_html_options options=$Resources key='GetId' label="GetName" selected=$ResourceId}
						</select>
					</div>
				</div>
				<div class="clearfix">&nbsp;</div>
			</div>
			<div class="card-action align-right">
                {reset_button id="showAll" class="btn-small btn-flat"}
                {filter_button id="filter" class="btn-small"}
				<div class="clearfix"></div>
			</div>
		</div>
	</form>

    {pagination pageInfo=$PageInfo}

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
				<label for="delete-all" class="">
					<input type="checkbox" id="delete-all" aria-label="{translate key=All}"/>
					<span>&nbsp;</span>
				</label>
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
				<td class="update"><a href="#" data-blackout-id="{$id}" class="edit"><span class="fa fa-edit icon"></span></a></td>
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
					<label for="delete{$id}-{$blackout->ResourceId}" class="">
						<input {formname key=BLACKOUT_INSTANCE_ID multi=true} class="delete-multiple" type="checkbox"
																			  id="delete{$id}-{$blackout->ResourceId}"
																			  value="{$id}"
																			  aria-label="{translate key=Delete}"/>
						<span>&nbsp;</span>
					</label>
				</td>
			</tr>
        {/foreach}
		</tbody>
		<tfoot>
		<tr>
			<td colspan="7"></td>
			<td class="action-delete">
				<a href="#" id="delete-selected" class="no-show" title="{translate key=Delete}">
					<span class="fa fa-trash icon remove"></span>
				</a>
			</td>
		</tr>
		</tfoot>
	</table>

    {pagination pageInfo=$PageInfo}

	<div id="add-blackout-dialog" class="modal modal-large modal-fixed-header modal-fixed-footer" tabindex="-1" role="dialog"
		 aria-labelledby="imageModalLabel"
		 aria-hidden="true">
		<form id="addBlackoutForm" role="form" method="post">
			<div class="modal-header">
				<h4 class="modal-title left" id="imageModalLabel">{translate key=AddBlackout}</h4>
				<a href="#" class="modal-close right black-text"><i class="fas fa-times"></i></a>
			</div>
			<div class="modal-content">
				<div class="col s6">
					<div class="input-field inline">
						<label for="addStartDate">{translate key=BeginDate}</label>
						<input type="text" id="addStartDate" class="dateinput inline"
							   value="{formatdate date=$AddStartDate}"/>
						<input {formname key=BEGIN_DATE} id="formattedAddStartDate" type="hidden"
														 value="{formatdate date=$AddStartDate key=system}"/>
					</div>
					<div class="input-field inline">
						<input {formname key=BEGIN_TIME} type="text" id="addStartTime"
														 class="dateinput inline timepicker"
														 value="{format_date format='h:00 A' date=now}"
														 title="Start time"/>
						<label for="addStartTime" class="no-show">Start Time</label>
					</div>
				</div>
				<div class="col s6">
					<div class="input-field inline">
						<label for="addEndDate">{translate key=EndDate}</label>
						<input type="text" id="addEndDate" class="dateinput"
							   value="{formatdate date=$AddEndDate}"/>
						<input {formname key=END_DATE} type="hidden" id="formattedAddEndDate"
													   value="{formatdate date=$AddEndDate key=system}"/>
					</div>
					<div class="input-field inline">
						<input {formname key=END_TIME} type="text" id="addEndTime"
													   class="dateinput timepicker"
													   value="{format_date format='h:00 A' date=Date::Now()->AddHours(1)}"
													   title="{translate key=EndTime}"/>
						<label for="addEndTime" class="no-show">{translate key=EndTime}</label>
					</div>
				</div>

				<div class="col s12">
					<div class="input-field inline">
						<label for="addResourceId" class="active">{translate key=Resource}</label>
						<select {formname key=RESOURCE_ID} id="addResourceId">
                            {object_html_options options=$Resources key='GetId' label="GetName" selected=$ResourceId}
						</select>
					</div>
                    {if $Schedules|count > 0}

						|
						<label for="allResources" style="margin-left:15px;">
							<input {formname key=BLACKOUT_APPLY_TO_SCHEDULE} type="checkbox" id="allResources"/>
							<span>{translate key=AllResourcesOn}</span>
						</label>
						<div class="input-field inline">
							<label for="addScheduleId" class="active">{translate key=Schedule} </label>
							<select {formname key=SCHEDULE_ID} id="addScheduleId" class=""
															   disabled="disabled"
															   title="{translate key=Schedule}">
                                {object_html_options options=$Schedules key='GetId' label="GetName" selected=$ScheduleId}
							</select>
						</div>
                    {/if}
				</div>

				<div class="col s12">
					<div class="input-field">
						<label for="blackoutReason">{translate key=Reason} *</label>
						<input {formname key=SUMMARY} type="text" id="blackoutReason" required
													  class="required"/>
					</div>
				</div>
				<div class="col s12">
                    {control type="RecurrenceControl" RepeatTerminationDate=$RepeatTerminationDate}
				</div>
				<div class="col s12">
					<label for="bookAround">
						<input {formname key=CONFLICT_ACTION} type="radio" id="bookAround"
															  name="existingReservations"
															  checked="checked"
															  value="{ReservationConflictResolution::BookAround}"/>
						<span>{translate key=BlackoutAroundConflicts}</span>
					</label>
					<label for="notifyExisting"><input {formname key=CONFLICT_ACTION} type="radio"
																					  id="notifyExisting"
																					  name="existingReservations"
																					  value="{ReservationConflictResolution::Notify}"/>
						<span>{translate key=BlackoutShowMe}</span>
					</label>
					<label for="deleteExisting"><input {formname key=CONFLICT_ACTION} type="radio"
																					  id="deleteExisting"
																					  name="existingReservations"
																					  value="{ReservationConflictResolution::Delete}"/>
						<span>{translate key=BlackoutDeleteConflicts}</span>
					</label>
				</div>
			</div>
			<div class="modal-footer">
                {indicator}
                {cancel_button}
                {add_button submit=true}
			</div>
		</form>
	</div>

	<div class="modal modal-fixed-header modal-fixed-footer" id="deleteDialog" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
		 aria-hidden="true">
		<div class="modal-header">
			<h4 class="modal-title left" id="deleteModalLabel">{translate key=Delete}</h4>
			<a href="#" class="modal-close right black-text"><i class="fas fa-times"></i></a>
		</div>
		<div class="modal-content">
			<div class="modal-body">
				<div class="card warning">
					<div class="card-content">
                        {translate key=DeleteWarning}
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<form id="deleteForm" method="post">
                {indicator}
                {cancel_button}
                {delete_button class="btnUpdateAllInstances" submit=true}
			</form>
		</div>
	</div>

	<div class="modal modal-fixed-header modal-fixed-footer" id="deleteDialog" id="deleteRecurringDialog" tabindex="-1" role="dialog"
		 aria-labelledby="deleteRecurringModalLabel"
		 aria-hidden="true">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title left" id="deleteRecurringModalLabel">{translate key=Delete}</h4>
				<a href="#" class="modal-close right black-text"><i class="fas fa-times"></i></a>
			</div>
			<div class="modal-body">
				<div class="card warning">
					<div class="card-content">
                        {translate key=DeleteWarning}
					</div>
				</div>
			</div>

		</div>
		<div class="modal-footer">
			<form id="deleteRecurringForm" method="post">
                {cancel_button}

				<button type="button"
						class="btn btn-danger save btnUpdateThisInstance waves-effect waves-light">
					<span class="fa fa-remove"></span> {translate key='ThisInstance'}</button>

				<button type="button"
						class="btn btn-danger save btnUpdateAllInstances waves-effect waves-light">
					<span class="fa fa-remove"></span> {translate key='AllInstances'}</button>

				<input type="hidden" {formname key=SERIES_UPDATE_SCOPE} class="hdnSeriesUpdateScope"
					   value="{SeriesUpdateScope::FullSeries}"/>
                {indicator}
			</form>
		</div>
	</div>

	<div id="deleteMultipleDialog" class="modal modal-fixed-header modal-fixed-footer" tabindex="-1" role="dialog"
		 aria-labelledby="deleteMultipleModalLabel"
		 aria-hidden="true">
		<form id="deleteMultipleForm" method="post"
			  action="{$smarty.server.SCRIPT_NAME}?action={ManageBlackoutsActions::DELETE_MULTIPLE}">
			<div class="modal-header">
				<h4 class="modal-title left" id="deleteMultipleModalLabel">{translate key=Delete} (<span id="deleteMultipleCount"></span>)</h4>
				<a href="#" class="modal-close right black-text"><i class="fas fa-times"></i></a>
			</div>
			<div class="modal-content">
				<div class="modal-body">
					<div class="card warning">
						<div class="card-content">
                            {translate key=DeleteWarning}
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
                {cancel_button}
                {delete_button}
                {indicator}
			</div>
			<div id="deleteMultiplePlaceHolder" class="no-show"></div>
		</form>
	</div>

	<div id="editBlackoutDialog" class="modal modal-large modal-fixed-header modal-fixed-footer" tabindex="-1" role="dialog"
		 aria-labelledby="updateModalLabel"
		 aria-hidden="true">
		<div>
			<div id="update-contents"></div>
            {indicator id="update-spinner"}
		</div>
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
			$('div.modal').modal();

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

			$('#filter-blackout-panel').showHidePanel();
		});

		$.blockUI.defaults.css.width = '60%';
		$.blockUI.defaults.css.left = '20%';
	</script>

    {control type="DatePickerSetupControl" ControlId="startDate" AltId="formattedStartDate"}
    {control type="DatePickerSetupControl" ControlId="endDate" AltId="formattedEndDate"}
    {control type="DatePickerSetupControl" ControlId="addStartDate" AltId="formattedAddStartDate"}
    {control type="DatePickerSetupControl" ControlId="addEndDate" AltId="formattedAddEndDate"}
    {control type="DatePickerSetupControl" ControlId="EndRepeat" AltId="formattedEndRepeat"}
    {control type="DatePickerSetupControl" ControlId="RepeatDate" AltId="formattedRepeatDate"}


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
</div>
{include file='globalfooter.tpl'}
