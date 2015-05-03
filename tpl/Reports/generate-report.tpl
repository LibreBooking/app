{*
Copyright 2012-2015 Nick Korbel

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
{include file='globalheader.tpl' cssFiles="css/reports.css,scripts/js/jqplot/jquery.jqplot.min.css"}

<h1>{translate key=GenerateReport}</h1>
<a href="#" id="showHideCustom">{translate key=ShowHide}</a>
<fieldset id="customReportInput-container">
	<form id="customReportInput">
		<div id="custom-report-input">
			<div class="input-set" id="selectDiv">
				<span class="label">{translate key=Select}</span>
				<input type="radio" {formname key=REPORT_RESULTS} value="{Report_ResultSelection::FULL_LIST}"
					   id="results_list" checked="checked"/>
				<label for="results_list">{translate key=List}</label>
				<input type="radio" {formname key=REPORT_RESULTS} value="{Report_ResultSelection::TIME}"
					   id="results_time"/>
				<label for="results_time">{translate key=TotalTime}</label>
				<input type="radio" {formname key=REPORT_RESULTS} value="{Report_ResultSelection::COUNT}"
					   id="results_count"/>
				<label for="results_count">{translate key=Count}</label>
			</div>

			<div class="input-set select-toggle" id="listOfDiv">
				<span class="label">{translate key=Usage}</span>
				<input type="radio" {formname key=REPORT_USAGE} value="{Report_Usage::RESOURCES}" id="usage_resources"
					   checked="checked">
				<label for="usage_resources">{translate key=Resources}</label>
				<input type="radio" {formname key=REPORT_USAGE} value="{Report_Usage::ACCESSORIES}"
					   id="usage_accessories">
				<label for="usage_accessories">{translate key=Accessories}</label>
			</div>

			<div class="input-set select-toggle" id="aggregateDiv" style="display:none;">
				<span class="label">{translate key=AggregateBy}</span>
				<input type="radio" {formname key=REPORT_GROUPBY} value="{Report_GroupBy::NONE}"
					   id="groupby_none" checked="checked"/>
				<label for="groupby_none">{translate key=None}</label>
				<input type="radio" {formname key=REPORT_GROUPBY} value="{Report_GroupBy::RESOURCE}"
					   id="groupby_resource"/>
				<label for="groupby_resource">{translate key=Resource}</label>
				<input type="radio" {formname key=REPORT_GROUPBY} value="{Report_GroupBy::SCHEDULE}"
					   id="groupby_schedule"/>
				<label for="groupby_schedule">{translate key=Schedule}</label>
				<input type="radio" {formname key=REPORT_GROUPBY} value="{Report_GroupBy::USER}"
					   id="groupby_user"/>
				<label for="groupby_user">{translate key=User}</label>
				<input type="radio" {formname key=REPORT_GROUPBY} value="{Report_GroupBy::GROUP}"
					   id="groupby_group"/>
				<label for="groupby_group">{translate key=Group}</label>
			</div>
			<div class="input-set">
				<span class="label">{translate key=Range}</span>
				<input type="radio" {formname key=REPORT_RANGE} value="{Report_Range::ALL_TIME}" id="range_all"
					   checked="checked"/>
				<label for="range_all">{translate key=AllTime}</label>
				<input type="radio" {formname key=REPORT_RANGE} value="{Report_Range::CURRENT_MONTH}" id="current_month"/>
				<label for="current_month">{translate key=CurrentMonth}</label>
				<input type="radio" {formname key=REPORT_RANGE} value="{Report_Range::CURRENT_WEEK}" id="current_week"/>
				<label for="current_week">{translate key=CurrentWeek}</label>
				<input type="radio" {formname key=REPORT_RANGE} value="{Report_Range::TODAY}" id="today"/>
				<label for="today" style="width:auto;">{translate key=Today}</label>
				<input type="radio" {formname key=REPORT_RANGE} value="{Report_Range::DATE_RANGE}" id="range_within"/>
				<label for="range_within" style="width:auto;">{translate key=Between}</label>
				<input type="input" class="textbox dateinput" id="startDate"/> -
				<input type="hidden" id="formattedBeginDate" {formname key=REPORT_START}/>
				<input type="input" class="textbox dateinput" id="endDate"/>
				<input type="hidden" id="formattedEndDate" {formname key=REPORT_END} />
			</div>
			<div class="input-set">
				<span class="label">{translate key=FilterBy}</span>
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

				<select class="textbox" {formname key=GROUP_ID}>
					<option value="">{translate key=AllGroups}</option>
				{foreach from=$Groups item=group}
					<option value="{$group->Id}">{$group->Name}</option>
				{/foreach}
				</select>

				<div id="user-filter-div" class="link-filter">
					<a href="#" class="all">{translate key=AllUsers}</a>
					<a href="#" class="selected filter-off"></a>
					<input id="user-filter" type="text" class="textbox filter-input filter-off"/>
				{html_image src="minus-gray.png" class="clear-filter filter-off"}
					<input id="user_id" class="filter-id" type="hidden" {formname key=USER_ID}/>
				</div>

				<div id="participant-filter-div" class="link-filter">
					<a href="#" class="all">{translate key=AllParticipants}</a>
					<a href="#" class="selected filter-off"></a>
					<input id="participant-filter" type="text" class="textbox filter-input filter-off"/>
				{html_image src="minus-gray.png" class="clear-filter filter-off"}
					<input id="participant_id" class="filter-id" type="hidden" {formname key=PARTICIPANT_ID}/>
				</div>
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
	</h3>{html_image src="admin-ajax-indicator.gif"}</div>

{include file="Reports/chart.tpl"}

<div class="dialog" id="userPopup">
{translate key=User}<a href="#" id="browseUser">Browse</a>
</div>

<div class="dialog" id="groupPopup">
{translate key=Group}<input id="group_filter" type="text" class="textbox"/>
</div>


<div class="dialog" id="saveDialog" title="{translate key=SaveThisReport}">
	<label for="saveReportName">{translate key=Name}:</label>

	<form id="saveReportForm" action="" method="post">
		<input type="text" id="saveReportName" {formname key=REPORT_NAME} class="textbox">
		<br/><br/>
		<button type="button"
				class="button save"
				id="btnSaveReport">{html_image src="disk-black.png"} {translate key='SaveThisReport'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

{jsfile src="autocomplete.js"}
{jsfile src="ajax-helpers.js"}
{jsfile src="reports/generate-reports.js"}
{jsfile src="reports/chart.js"}

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