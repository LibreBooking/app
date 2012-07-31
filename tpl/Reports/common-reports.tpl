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

<h2>Common Reports</h2>
<div id="report-list">
Resource Usage (Time Booked)
	<a href="#" reportId="{CannedReport::RESOURCE_TIME_ALLTIME}" class="report runNow">All Time</a>
	<a href="#" reportId="{CannedReport::RESOURCE_TIME_THISWEEK}" class="report runNow">This Week</a>
	<a href="#" reportId="{CannedReport::RESOURCE_TIME_THISMONTH}" class="report runNow">This Month</a>
<br/>
Resource Usage (Reservation Count)
	<a href="#" reportId="{CannedReport::RESOURCE_COUNT_ALLTIME}" class="report runNow">All Time</a>
	<a href="#" reportId="{CannedReport::RESOURCE_COUNT_THISWEEK}" class="report runNow">This Week</a>
	<a href="#" reportId="{CannedReport::RESOURCE_COUNT_THISMONTH}" class="report runNow">This Month</a>
</div>


<div id="resultsDiv">
</div>

<div id="indicator" style="display:none; text-align: center;">
	<h3>{translate key=Working}...</h3>
{html_image src="admin-ajax-indicator.gif"}
</div>

<script type="text/javascript" src="{$Path}scripts/ajax-helpers.js"></script>
<script type="text/javascript" src="{$Path}scripts/canned-reports.js"></script>

<script type="text/javascript">
	$(document).ready(function () {
		var reportOptions = {
			generateUrl:"{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::Generate}&{QueryStringKeys::REPORT_ID}=",
			emailUrl:"{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::Email}&{QueryStringKeys::REPORT_ID}=",
			deleteUrl:"{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::Delete}&{QueryStringKeys::REPORT_ID}=",
			printUrl:"{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::PrintReport}&{QueryStringKeys::REPORT_ID}=",
			csvUrl:"{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACTION}={ReportActions::Csv}&{QueryStringKeys::REPORT_ID}="
		};

		var reports = new CannedReports(reportOptions);
		reports.init();
	});
</script>

{include file='globalfooter.tpl'}