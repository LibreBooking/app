{*
Copyright 2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*}
{include file='globalheader.tpl' cssFiles="css/reports.css"}

<h1>Create Custom Report</h1>
<a href="#" id="showHideCustom">{translate key=ShowHide}</a>
<fieldset id="customReportInput-container">
	<form id="customReportInput">
		<div id="custom-report-input">
			<div class="input-set" id="selectDiv">
				<span class="label">Select</span>
				<input type="radio" {formname key=REPORT_RESULTS} value="{Report_ResultSelection::FULL_LIST}"
					   id="results_list" checked="checked"/><label
					for="results_list">List</label>
				<input type="radio" {formname key=REPORT_RESULTS} value="{Report_ResultSelection::TIME}"
					   id="results_time"/><label
					for="results_time">Total Time</label>
				<input type="radio" {formname key=REPORT_RESULTS} value="{Report_ResultSelection::COUNT}"
					   id="results_count"/><label for="results_count">Count</label>
			</div>

			<div class="input-set select-toggle" id="listOfDiv">
				<span class="label">Usage</span>
				<input type="radio" {formname key=REPORT_USAGE} value="{Report_Usage::RESOURCES}" id="usage_resources"
					   checked="checked"><label for="usage_resources">{translate key=Resources}</label>
				<input type="radio" {formname key=REPORT_USAGE} value="{Report_Usage::ACCESSORIES}"
					   id="usage_accessories"><label for="usage_accessories">{translate key=Accessories}</label>
			</div>

			<div class="input-set select-toggle" id="aggregateDiv" style="display:none;">
				<span class="label">Aggregate By</span>
				<input type="radio" {formname key=REPORT_GROUPBY} value="{Report_GroupBy::NONE}" id="groupby_none"
					   checked="checked"/><label
					for="groupby_none">None</label>
				<input type="radio" {formname key=REPORT_GROUPBY} value="{Report_GroupBy::RESOURCE}"
					   id="groupby_resource"/><label
					for="groupby_resource">Resource</label>
				<input type="radio" {formname key=REPORT_GROUPBY} value="{Report_GroupBy::SCHEDULE}"
					   id="groupby_schedule"/><label
					for="groupby_schedule">Schedule</label>
				<input type="radio" {formname key=REPORT_GROUPBY} value="{Report_GroupBy::USER}"
					   id="groupby_user"/><label
					for="groupby_user">User</label>
				<input type="radio" {formname key=REPORT_GROUPBY} value="{Report_GroupBy::GROUP}"
					   id="groupby_group"/><label
					for="groupby_group">Group</label>
			</div>
			<div class="input-set">
				<span class="label">Range</span>
				<input type="radio" {formname key=REPORT_RANGE} value="{Report_Range::ALL_TIME}" id="range_all"
					   checked="checked"/><label for="range_all">All
				Time</label>
				<input type="radio" {formname key=REPORT_RANGE} value="{Report_Range::DATE_RANGE}"
					   id="range_within"/><label
					for="range_within">Between</label>
				<input type="input" {formname key=REPORT_START} class="textbox dateinput" id="startDate"/> and <input
					type="input" {formname key=REPORT_END} class="textbox dateinput" id="endDate"/>
			</div>
			<div class="input-set">
				<span class="label">Filter By</span>
				<select class="textbox" {formname key=RESOURCE_ID}>
					<option value="">{translate key=AllResources}</option>
				{foreach from=$Resources item=resource}
					<option value="{$resource->GetId()}">{$resource->GetName()}</option>
				{/foreach}
				</select>
				<select class="textbox" {formname key=ACCESSORY_ID} id="accessoryId">
					<option value="">{translate key=AllAccessories}</option>
				{foreach from=$Accessories item=accessory}
					<option value="{$accessory->Id}">{$accessory->Name}</option>
				{/foreach}
				</select>
				<select class="textbox" {formname key=SCHEDULE_ID}>
					<option value="">{translate key=AllSchedules}</option>
				{foreach from=$Schedules item=schedule}
					<option value="{$schedule->GetId()}">{$schedule->GetName()}</option>
				{/foreach}
				</select>
				<a href="#">{translate key=AllUsers}</a>
				<a href="#">{translate key=AllGroups}</a>

				<input id="user_id" type="hidden" {formname key=USER_ID}/>
				<input id="group_id" type="hidden" {formname key=GROUP_ID}/>
			</div>
		</div>
		<input type="submit" value="{translate key=GetReport}" class="button" id="btnCustomReport" asyncAction=""/>
	</form>
</fieldset>

<div id="saveMessage" class="success" style="display:none">
	{translate key=ReportSaved} <a href="{$Path}reports/{Pages::REPORTS_SAVED}">{translate key=MySavedReports}</a>
</div>

<div id="resultsDiv">
</div>

<div id="indicator" style="display:none; text-align: center;"><h3>{translate key=Working}
	...</h3>{html_image src="admin-ajax-indicator.gif"}</div>

<div class="dialog" id="userPopup">
{translate key=User}<input id="user_filter" type="text" class="textbox"/>
</div>

<div class="dialog" id="groupPopup">
{translate key=Group}<input id="group_filter" type="text" class="textbox"/>
</div>

<div class="dialog" id="saveDialog" title="{translate key=SaveThisReport}">
	<label for="saveReportName">{translate key=Name}:</label>

	<form id="saveReportForm">
		<input type="text" id="saveReportName" {formname key=REPORT_NAME} class="textbox">
	</form>
	<br/><br/>
	<button type="button"
			class="button save" id="btnSaveReport">{html_image src="disk-black.png"} {translate key='SaveThisReport'}</button>
	<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
</div>

<script type="text/javascript" src="{$Path}scripts/autocomplete.js"></script>
<script type="text/javascript" src="{$Path}scripts/generate-reports.js"></script>

<script type="text/javascript">
	$(document).ready(function () {
		var reportOptions = {
			userAutocompleteUrl:"{$Path}ajax/autocomplete.php?type={AutoCompleteType::User}",
			groupAutocompleteUrl:"{$Path}ajax/autocomplete.php?type={AutoCompleteType::Group}",
			customReportUrl:"{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::Generate}",
			printUrl:"{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::PrintReport}&",
			csvUrl:"{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::Csv}&",
			saveUrl:"{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::Save}"
		};

		var reports = new GenerateReports(reportOptions);
		reports.init();
	});
</script>

{control type="DatePickerSetupControl" ControlId="startDate" AltId="formattedBeginDate"}
{control type="DatePickerSetupControl" ControlId="endDate" AltId="formattedEndDate"}

{include file='globalfooter.tpl'}