{*
Copyright 2012-2019 Nick Korbel

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

{include file='globalheader.tpl' cssFiles="scripts/js/jqplot/jquery.jqplot.min.css" Select2=true}

<div id="page-generate-report">
	<div id="customReportInput-container">
		<form role="form" id="customReportInput">
			<div class="panel panel-default" id="report-filter-panel">
				<div class="panel-heading">
					{translate key=GenerateReport} <a href="#"><span class="no-show">Collapse</span><span class="icon black show-hide glyphicon"></span></a>
				</div>
				<div class="panel-body no-padding">
					<div id="custom-report-input">
						<div class="row input-set" id="selectDiv">
							<div class="col-md-1"><span>{translate key=Select}</span></div>
							<div class="col-md-11 radio">
								<div class="col-md-1">
									<input type="radio" {formname key=REPORT_RESULTS}
										   value="{Report_ResultSelection::FULL_LIST}"
										   id="results_list" checked="checked"/>
									<label for="results_list">{translate key=List}</label>
								</div>
								<div class="col-md-1">
									<input type="radio" {formname key=REPORT_RESULTS}
										   value="{Report_ResultSelection::TIME}"
										   id="results_time"/>
									<label for="results_time">{translate key=TotalTime}</label>
								</div>
								<div class="col-md-1">
									<input type="radio" {formname key=REPORT_RESULTS}
										   value="{Report_ResultSelection::COUNT}"
										   id="results_count"/>
									<label for="results_count">{translate key=Count}</label>
								</div>
                                <div class="col-md-9">
									<input type="radio" {formname key=REPORT_RESULTS}
										   value="{Report_ResultSelection::UTILIZATION}"
										   id="results_utilization"/>
									<label for="results_utilization">{translate key=Utilization}</label>
								</div>
							</div>
						</div>

						<div class="row input-set select-toggle" id="listOfDiv">
							<div class="col-md-1"><span>{translate key=Usage}</span></div>
							<div class="col-md-11 radio">
								<div class="col-md-1">
									<input type="radio" {formname key=REPORT_USAGE} value="{Report_Usage::RESOURCES}"
										   id="usage_resources"
										   checked="checked">
									<label for="usage_resources">{translate key=Resources}</label>
								</div>
								<div class="col-md-11">
									<input type="radio" {formname key=REPORT_USAGE} value="{Report_Usage::ACCESSORIES}"
										   id="usage_accessories">
									<label for="usage_accessories">{translate key=Accessories}</label>
								</div>
							</div>
						</div>

						<div class="row input-set select-toggle" id="aggregateDiv" style="display:none;">
							<div class="col-md-1"><span class="">{translate key=AggregateBy}</span></div>
							<div class="col-md-11 radio">
								<div class="col-md-1">
									<input type="radio" {formname key=REPORT_GROUPBY} value="{Report_GroupBy::NONE}"
										   id="groupby_none" checked="checked"/>
									<label for="groupby_none">{translate key=None}</label>
								</div>
								<div class="col-md-1">
									<input type="radio" {formname key=REPORT_GROUPBY} value="{Report_GroupBy::RESOURCE}"
										   id="groupby_resource" class="utilization-eligible"/>
									<label for="groupby_resource">{translate key=Resource}</label>
								</div>
								<div class="col-md-1">
									<input type="radio" {formname key=REPORT_GROUPBY} value="{Report_GroupBy::SCHEDULE}"
										   id="groupby_schedule" class="utilization-eligible"/>
									<label for="groupby_schedule">{translate key=Schedule}</label>
								</div>
								<div class="col-md-1">
									<input type="radio" {formname key=REPORT_GROUPBY} value="{Report_GroupBy::USER}"
										   id="groupby_user"/>
									<label for="groupby_user">{translate key=User}</label>
								</div>
								<div class="col-md-8">
									<input type="radio" {formname key=REPORT_GROUPBY} value="{Report_GroupBy::GROUP}"
										   id="groupby_group"/>
									<label for="groupby_group">{translate key=Group}</label>
								</div>
							</div>
						</div>
						<div class="row input-set form-group-sm" id="rangeDiv">
							<div class="col-md-1"><span class="">{translate key=Range}</span></div>
							<div class="col-md-11 radio">
								<div class="col-md-2">
									<input type="radio" {formname key=REPORT_RANGE}
										   value="{Report_Range::CURRENT_MONTH}" id="current_month"
                                           checked="checked"/>
									<label for="current_month">{translate key=CurrentMonth}</label>
								</div>
								<div class="col-md-2">
									<input type="radio" {formname key=REPORT_RANGE} value="{Report_Range::CURRENT_WEEK}"
										   id="current_week"/>
									<label for="current_week">{translate key=CurrentWeek}</label>
								</div>
								<div class="col-md-1">
									<input type="radio" {formname key=REPORT_RANGE} value="{Report_Range::TODAY}"
										   id="today"/>
									<label for="today" style="width:auto;">{translate key=Today}</label>
								</div>
                                <div class="col-md-1">
                                    <input type="radio" {formname key=REPORT_RANGE} value="{Report_Range::ALL_TIME}"
                                           id="range_all"/>
                                    <label for="range_all">{translate key=AllTime}</label>
                                </div>
								<div class="col-md-6">
									<input type="radio" {formname key=REPORT_RANGE} value="{Report_Range::DATE_RANGE}"
										   id="range_within"/>
									<label for="range_within" style="width:auto;">{translate key=Between}</label>
                                    <label for="startDate" class="no-show">{translate key=StartDate}</label>
									<input type="input" class="form-control dateinput inline" id="startDate"/> -
									<input type="hidden" id="formattedBeginDate" {formname key=REPORT_START}/>
                                    <label for="endDate" class="no-show">{translate key=EndDate}</label>
                                    <input type="input" class="form-control dateinput inline" id="endDate"/>
									<input type="hidden" id="formattedEndDate" {formname key=REPORT_END} />
								</div>
							</div>
						</div>
						<div class="row input-set form-group-sm">
							<div class="col-md-1"><span class="">{translate key=FilterBy}</span></div>
							<div class="col-md-11">
								<div class="form-group no-margin no-padding col-md-2">
                                    <label for="resourceId" class="no-show">{translate key=Resource}</label>
                                    <select class="form-control" {formname key=RESOURCE_ID multi=true} multiple="multiple" id="resourceId">
										{foreach from=$Resources item=resource}
											<option value="{$resource->GetId()}">{$resource->GetName()}</option>
										{/foreach}
									</select>
								</div>
								<div class="form-group no-margin no-padding col-md-2">
                                    <label for="resourceTypeId" class="no-show">{translate key=ResourceType}</label>
                                    <select class="form-control" {formname key=RESOURCE_TYPE_ID multi=true} multiple="multiple" id="resourceTypeId">
										{foreach from=$ResourceTypes item=resourceType}
											<option value="{$resourceType->Id()}">{$resourceType->Name()}</option>
										{/foreach}
									</select>
								</div>
								<div class="form-group no-margin no-padding col-md-2">
                                    <label for="accessoryId" class="no-show">{translate key=Accessory}</label>
                                    <select class="form-control" {formname key=ACCESSORY_ID multi=true} multiple="multiple" id="accessoryId">
										{foreach from=$Accessories item=accessory}
											<option value="{$accessory->Id}">{$accessory->Name}</option>
										{/foreach}
									</select>
								</div>
								<div class="form-group no-margin no-padding col-md-2">
                                    <label for="scheduleId" class="no-show">{translate key=Schedule}</label>
                                    <select class="form-control" {formname key=SCHEDULE_ID multi=true} multiple="multiple" id="scheduleId">
										{foreach from=$Schedules item=schedule}
											<option value="{$schedule->GetId()}">{$schedule->GetName()}</option>
										{/foreach}
									</select>
								</div>
								<div class="form-group no-margin no-padding col-md-2">
                                    <label for="groupId" class="no-show">{translate key=Group}</label>
                                    <select class="form-control" {formname key=GROUP_ID multi=true} multiple="multiple" id="groupId">
										{foreach from=$Groups item=group}
											<option value="{$group->Id}">{$group->Name}</option>
										{/foreach}
									</select>
								</div>
							</div>
							<div class="col-md-11 col-md-offset-1">
								<div class="form-group no-margin no-padding col-md-2">
									<div id="user-filter-div">
										<div class="">
											<label class="control-label sr-only"
												   for="user-filter">{translate key=AllUsers}</label>
											<input id="user-filter" type="text" class="form-control"
												   placeholder="{translate key=AllUsers}"/>
											<input id="user_id" class="filter-id" type="hidden" {formname key=USER_ID}/>
										</div>
									</div>
								</div>
								<div class="form-group no-margin no-padding col-md-2">
									<div id="participant-filter-div">
										<div class="form-group">
											<label class="control-label sr-only"
												   for="participant-filter">{translate key=AllParticipants}</label>
											<input id="participant-filter" type="text" class="form-control"
												   placeholder="{translate key=AllParticipants}"/>
											<input id="participant_id" class="filter-id"
												   type="hidden" {formname key=PARTICIPANT_ID}/>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
                <div class="panel-footer">
                    <input type="submit" value="{translate key=GetReport}" class="btn btn-primary btn-sm"
                           id="btnCustomReport" asyncAction=""/>
                    <div class="checkbox inline-block">
                        <input type="checkbox" id="chkIncludeDeleted" {formname key=INCLUDE_DELETED}/>
                        <label for="chkIncludeDeleted">{translate key=IncludeDeleted}</label>
                    </div>
                </div>
			</div>
            {csrf_token}
        </form>
	</div>
</div>

<div id="saveMessage" class="alert alert-success" style="display:none;">
	<strong>{translate key=ReportSaved}</strong> <a
			href="{$Path}reports/{Pages::REPORTS_SAVED}">{translate key=MySavedReports}</a>
</div>

<div id="resultsDiv">
</div>

<div id="indicator" style="display:none; text-align: center;"><h3>{translate key=Working}
	</h3>{html_image src="admin-ajax-indicator.gif"}</div>

{include file="Reports/chart.tpl"}

<div class="modal fade" id="saveDialog" tabindex="-1" role="dialog" aria-labelledby="saveDialogLabel"
	 aria-hidden="true">
	<div class="modal-dialog">
		<form id="saveReportForm" method="post">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="saveDialogLabel">{translate key=SaveThisReport}</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="saveReportName">{translate key=Name}</label>
						<input type="text" id="saveReportName" {formname key=REPORT_NAME} class="form-control"
							   placeholder="{translate key=NoTitleLabel}"/>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default cancel"
							data-dismiss="modal">{translate key='Cancel'}</button>
					<button type="button" id="btnSaveReport" class="btn btn-success"><span
								class="glyphicon glyphicon-ok-circle"></span>
						{translate key='SaveThisReport'}
					</button>
					{indicator}
				</div>
			</div>
		</form>
	</div>
</div>

{include file="javascript-includes.tpl" Select2=true}
{jsfile src="autocomplete.js"}
{jsfile src="ajax-helpers.js"}
{jsfile src="reports/generate-reports.js"}
{jsfile src="reports/common.js"}
{jsfile src="reports/chart.js"}

<script type="text/javascript">
	$(document).ready(function () {
		var reportOptions = {
			userAutocompleteUrl: "{$Path}ajax/autocomplete.php?type={AutoCompleteType::User}",
			groupAutocompleteUrl: "{$Path}ajax/autocomplete.php?type={AutoCompleteType::Group}",
			customReportUrl: "{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::Generate}",
			printUrl: "{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::PrintReport}&",
			csvUrl: "{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::Csv}&",
			saveUrl: "{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::Save}"
		};

		var reports = new GenerateReports(reportOptions);
		reports.init();

		var common = new ReportsCommon({
			scriptUrl: '{$ScriptUrl}',
            chartOpts: {
                dateAxisFormat: '{$DateAxisFormat}'
            }
		});
		common.init();

        $('#resourceId').select2({
            placeholder: '{translate key=AllResources}'
        });
        $('#resourceTypeId').select2({
            placeholder: '{translate key=AllResourceTypes}'
        });
        $('#accessoryId').select2({
            placeholder: '{translate key=AllAccessories}'
        });
        $('#scheduleId').select2({
            placeholder: '{translate key=AllSchedules}'
        });
        $('#groupId').select2({
            placeholder: '{translate key=AllGroups}'
        });
	});

	$('#report-filter-panel').showHidePanel();


	$('#user-filter, #participant-filter').clearable();
</script>

{control type="DatePickerSetupControl" ControlId="startDate" AltId="formattedBeginDate"}
{control type="DatePickerSetupControl" ControlId="endDate" AltId="formattedEndDate"}

</div>
{include file='globalfooter.tpl'}