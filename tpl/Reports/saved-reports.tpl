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
{include file='globalheader.tpl' cssFiles="scripts/js/jqplot/jquery.jqplot.min.css"}

<div id="page-saved-reports">

	<div class="panel panel-default" id="saved-reports-panel">
		<div class="panel-heading">
			{translate key=MySavedReports} <span class="badge">{$ReportList|count}</span>
		</div>
		<div class="panel-body no-padding">
			{if $ReportList|count == 0}
				<h2 class="no-data" style="text-align: center;">{translate key=NoSavedReports}</h2>
                <div style="text-align:center;"><a href="{$Path}reports/{Pages::REPORTS_GENERATE}">{translate key=GenerateReport}</a></div>
			{else}
				<div id="report-list">
					<table class="table">
						<tbody>
						{foreach from=$ReportList item=report}
							{cycle values=',alt' assign=rowCss}
							<tr reportId="{$report->Id()}" class="{$rowCss}">
								<td><span class="report-title">{$report->ReportName()|default:$untitled}</span></td>
								<td class="right"><span
											class="report-created-date">{format_date date=$report->DateCreated()}</span>
								</td>

								<td class="report-action"><a href="#" class="runNow report"><span
												class="fa fa-play-circle-o icon add"></span> {translate key=RunReport}
									</a></td>
								<td class="report-action"><a href="#" class="emailNow report"><span
												class="fa fa-envelope-o icon"></span> {translate key=EmailReport}</a>
								</td>
								<td class="report-action"><a href="#" class="delete report"><span
												class="fa fa-trash icon remove"></span> {translate key=Delete}</a></td>
								{*
								   {if $report->IsScheduled()}
									   Schedule: <a href="#" class="editSchedule report">{translate key=Edit}</a>
									   {else}
									   <a href="#" class="schedule report">Schedule</a>
								   {/if}
								   *}


							</tr>
						{/foreach}
						</tbody>
					</table>
				</div>
			{/if}
		</div>

	</div>

	<div id="resultsDiv">
	</div>

	<div id="emailSent" class="alert alert-success no-show">
		<strong>{translate key=ReportSent}</strong>N
	</div>

	<div class="modal fade" id="emailDiv" tabindex="-1" role="dialog" aria-labelledby="emailDialogLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<form id="emailForm" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="emailDialogLabel">{translate key=EmailReport}</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="emailTo">{translate key=Email}</label>
							<input id="emailTo" {formname key=EMAIL} value="{$UserEmail}" class="form-control"/>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default cancel"
									data-dismiss="modal">{translate key='Cancel'}</button>
							<button id="btnSendEmail" type="button" class="btn btn-success save"><span
										class="fa fa-envelope-o"></span> {translate key=EmailReport}
							</button>
							{indicator}
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="modal fade" id="deleteDiv" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
		<div class="modal-dialog">
			<form id="deleteForm" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="deleteLabel">{translate key=Delete}</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger">
							{translate key=DeleteWarning}
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default cancel"
								data-dismiss="modal">{translate key='Cancel'}</button>
						<button type="button" class="btn btn-danger save">{translate key='Delete'}</button>
						{indicator}
					</div>
				</div>
				{csrf_token}
			</form>
		</div>
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
    {include file="javascript-includes.tpl"}
	{jsfile src="ajax-helpers.js"}
	{jsfile src="reports/saved-reports.js"}
	{jsfile src="reports/chart.js"}
	{jsfile src="reports/common.js"}

	<script type="text/javascript">
		$(document).ready(function () {
			var reportOptions = {
				generateUrl: "{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::Generate}&{QueryStringKeys::REPORT_ID}=",
				emailUrl: "{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::Email}&{QueryStringKeys::REPORT_ID}=",
				deleteUrl: "{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::Delete}&{QueryStringKeys::REPORT_ID}=",
				printUrl: "{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::PrintReport}&{QueryStringKeys::REPORT_ID}=",
				csvUrl: "{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::Csv}&{QueryStringKeys::REPORT_ID}="
			};

			var reports = new SavedReports(reportOptions);
			reports.init();

			var common = new ReportsCommon(
					{
						scriptUrl: '{$ScriptUrl}',
                        chartOpts: {
                            dateAxisFormat: '{$DateAxisFormat}'
                        }
					}
			);
			common.init();
		});
	</script>
</div>
{include file='globalfooter.tpl'}