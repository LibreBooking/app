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

<h1>{translate key=MySavedReports} (<span id="reportCount">{$ReportList|count}</span>)</h1>
{if $ReportList|count == 0}
<h2 class="no-data" style="text-align: center;">{translate key=NoSavedReports}</h2><a
		href="{$Path}reports/{Pages::REPORTS_GENERATE}">{translate key=GenerateReport}</a>
	{else}
<div id="report-list">
	<ul>
		{foreach from=$ReportList item=report}
			{cycle values=',alt' assign=rowCss}
			<li reportId="{$report->Id()}" class="{$rowCss}"><span class="report-title">{$report->ReportName()|default:$untitled}</span>
				<span class="right"><span class="report-created-date">{format_date date=$report->DateCreated()}</span>

				<span class="report-action"><a href="#"
													 class="runNow report">{html_image src="control.png"}{translate key=RunReport}</a></span>
				<span class="report-action"><a href="#"
													 class="emailNow report">{html_image src="mail-send.png"}{translate key=EmailReport}</a></span>
				<span class="report-action"><a href="#"
													 class="delete report">{html_image src="cross-button.png"}{translate key=Delete}</a></span>
				</span>
			{*
			   {if $report->IsScheduled()}
				   Schedule: <a href="#" class="editSchedule report">{translate key=Edit}</a>
				   {else}
				   <a href="#" class="schedule report">Schedule</a>
			   {/if}
			   *}


			</li>
		{/foreach}
	</ul>
</div>
{/if}


<div id="resultsDiv">
</div>

<div id="emailSent" style="display:none" class="success">
{translate key=ReportSent}
</div>

<div id="emailDiv" class="dialog" title="{translate key=EmailReport}">
	<form id="emailForm">
		<label for="emailTo">{translate key=Email}</label> <input id="emailTo" type="text" {formname key=email}
																  value="{$UserEmail}" class="textbox"/>
		<br/>
		<br/>
		<button type="button" id="btnSendEmail"
				class="button">{html_image src="mail-send.png"} {translate key=EmailReport}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key=Cancel}</button>
		<span id="sendEmailIndicator" style="display:none">{translate key=Working}</span>
	</form>
</div>

<div id="deleteDiv" class="dialog" title="{translate key=Delete}">
	<div class="error" style="margin-bottom: 25px;">
		<h3>{translate key=DeleteWarning}</h3>
	</div>
	<button type="button" id="btnDeleteReport"
			class="button">{html_image src="cross-button.png"} {translate key='Delete'}</button>
	<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
</div>

<div id="indicator" style="display:none; text-align: center;">
	<h3>{translate key=Working}</h3>
{html_image src="admin-ajax-indicator.gif"}
</div>

{include file="Reports/chart.tpl"}

{*
<div id="scheduleDiv" class="dialog" title="Schedule Report">
	<label>Email Report</label>
	<select id="repeatOptions" {formname key=repeat_options} class="pulldown">
	{foreach from=$RepeatOptions key=k item=v}
		<option value="{$k}">{translate key=$v['key']}</option>
	{/foreach}
	</select>

	<div id="repeatEveryDiv" style="display:none;" class="days weeks months years">
		<label>{translate key="RepeatEveryPrompt"}</label>
		<select id="repeatInterval" {formname key=repeat_every} class="pulldown">
		{html_options values=$RepeatEveryOptions output=$RepeatEveryOptions}
		</select>
		<span class="days">{translate key=$RepeatOptions['daily']['everyKey']}</span>
		<span class="weeks">{translate key=$RepeatOptions['weekly']['everyKey']}</span>
		<span class="months">{translate key=$RepeatOptions['monthly']['everyKey']}</span>
		<span class="years">{translate key=$RepeatOptions['yearly']['everyKey']}</span>
	</div>
	<div id="repeatOnWeeklyDiv" style="display:none;" class="weeks">
		<label>{translate key="RepeatDaysPrompt"}</label>
		<input type="checkbox"
			   id="repeatDay0" {formname key=repeat_sunday} /><label
			for="repeatDay0">{translate key="DaySundaySingle"}</label>
		<input type="checkbox"
			   id="repeatDay1" {formname key=repeat_monday} /><label
			for="repeatDay1">{translate key="DayMondaySingle"}</label>
		<input type="checkbox"
			   id="repeatDay2" {formname key=repeat_tuesday} /><label
			for="repeatDay2">{translate key="DayTuesdaySingle"}</label>
		<input type="checkbox"
			   id="repeatDay3" {formname key=repeat_wednesday} /><label
			for="repeatDay3">{translate key="DayWednesdaySingle"}</label>
		<input type="checkbox"
			   id="repeatDay4" {formname key=repeat_thursday} /><label
			for="repeatDay4">{translate key="DayThursdaySingle"}</label>
		<input type="checkbox"
			   id="repeatDay5" {formname key=repeat_friday} /><label
			for="repeatDay5">{translate key="DayFridaySingle"}</label>
		<input type="checkbox"
			   id="repeatDay6" {formname key=repeat_saturday} /><label
			for="repeatDay6">{translate key="DaySaturdaySingle"}</label>
	</div>
	<div id="repeatOnMonthlyDiv" style="display:none;" class="months">
		<input type="radio" {formname key=REPEAT_MONTHLY_TYPE} value="{RepeatMonthlyType::DayOfMonth}"
			   id="repeatMonthDay" checked="checked"/>
		<label for="repeatMonthDay">{translate key="repeatDayOfMonth"}</label>
		<input type="radio" {formname key=REPEAT_MONTHLY_TYPE} value="{RepeatMonthlyType::DayOfWeek}"
			   id="repeatMonthWeek"/>
		<label for="repeatMonthWeek">{translate key="repeatDayOfWeek"}</label>
	</div>
</div>
*}

{jsfile src="ajax-helpers.js"}
{jsfile src="reports/saved-reports.js"}
{jsfile src="reports/chart.js"}

<script type="text/javascript">
	$(document).ready(function () {
		var reportOptions = {
			generateUrl:"{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::Generate}&{QueryStringKeys::REPORT_ID}=",
			emailUrl:"{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::Email}&{QueryStringKeys::REPORT_ID}=",
			deleteUrl:"{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::Delete}&{QueryStringKeys::REPORT_ID}=",
			printUrl:"{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::PrintReport}&{QueryStringKeys::REPORT_ID}=",
			csvUrl:"{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::Csv}&{QueryStringKeys::REPORT_ID}="
		};

		var reports = new SavedReports(reportOptions);
		reports.init();
	});
</script>

{include file='globalfooter.tpl'}