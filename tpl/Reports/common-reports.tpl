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

<div id="page-common-reports">

    <div class="panel panel-default" id="saved-reports-panel">
        <div class="panel-heading">
            {translate key=CommonReports}
        </div>
        <div class="panel-body no-padding">
            <div id="report-list">
                <table class="table">
                    <tbody>
                    <tr>
                        <td class="report-title">{translate key=ReservedResources}</td>
                        <td class="right">
                            <a href="#" reportId="{CannedReport::RESERVATIONS_TODAY}"
                               class="report report-action runNow">{html_image src="calendar.png"} {translate key=Today}</a>
                            <a href="#" reportId="{CannedReport::RESERVATIONS_THISWEEK}"
                               class="report report-action runNow">{html_image src="calendar-select-week.png"} {translate key=CurrentWeek}</a>
                            <a href="#" reportId="{CannedReport::RESERVATIONS_THISMONTH}"
                               class="report report-action runNow">{html_image src="calendar-select-month.png"} {translate key=CurrentMonth}</a>
                        </td>
                    </tr>
                    <tr class="alt">
                        <td class="report-title">{translate key=ReservedAccessories}</td>
                        <td class="right">
                            <a href="#" reportId="{CannedReport::ACCESSORIES_TODAY}"
                               class="report report-action runNow">{html_image src="calendar.png"} {translate key=Today}</a>
                            <a href="#" reportId="{CannedReport::ACCESSORIES_THISWEEK}"
                               class="report report-action runNow">{html_image src="calendar-select-week.png"} {translate key=CurrentWeek}</a>
                            <a href="#" reportId="{CannedReport::ACCESSORIES_THISMONTH}"
                               class="report report-action runNow">{html_image src="calendar-select-month.png"} {translate key=CurrentMonth}</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="report-title">{translate key=ResourceUsageTimeBooked}</td>
                        <td class="right">
                            <a href="#" reportId="{CannedReport::RESOURCE_TIME_ALLTIME}"
                               class="report report-action runNow">{html_image src="calendar.png"} {translate key=AllTime}</a>
                            <a href="#" reportId="{CannedReport::RESOURCE_TIME_THISWEEK}"
                               class="report report-action runNow">{html_image src="calendar-select-week.png"} {translate key=CurrentWeek}</a>
                            <a href="#" reportId="{CannedReport::RESOURCE_TIME_THISMONTH}"
                               class="report report-action runNow">{html_image src="calendar-select-month.png"} {translate key=CurrentMonth}</a>
                        </td>
                    </tr>
                    <tr class="alt">
                        <td class="report-title">{translate key=ResourceUsageReservationCount}</td>
                        <td class="right">
                            <a href="#" reportId="{CannedReport::RESOURCE_COUNT_ALLTIME}"
                               class="report report-action runNow">{html_image src="calendar.png"} {translate key=AllTime}</a>
                            <a href="#" reportId="{CannedReport::RESOURCE_COUNT_THISWEEK}"
                               class="report report-action runNow">{html_image src="calendar-select-week.png"} {translate key=CurrentWeek}</a>
                            <a href="#" reportId="{CannedReport::RESOURCE_COUNT_THISMONTH}"
                               class="report report-action runNow">{html_image src="calendar-select-month.png"} {translate key=CurrentMonth}</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="report-title">{translate key=Top20UsersTimeBooked}</td>
                        <td class="right">
                            <a href="#" reportId="{CannedReport::USER_TIME_ALLTIME}"
                               class="report report-action runNow">{html_image src="calendar.png"} {translate key=AllTime}</a>
                            <a href="#" reportId="{CannedReport::USER_TIME_THISWEEK}"
                               class="report report-action runNow">{html_image src="calendar-select-week.png"} {translate key=CurrentWeek}</a>
                            <a href="#" reportId="{CannedReport::USER_TIME_THISMONTH}"
                               class="report report-action runNow">{html_image src="calendar-select-month.png"} {translate key=CurrentMonth}</a>
                        </td>
                    </tr>
                    <tr class="alt">
                        <td class="report-title">{translate key=Top20UsersReservationCount}</td>
                        <td class="right">
                            <a href="#" reportId="{CannedReport::USER_COUNT_ALLTIME}"
                               class="report report-action  runNow">{html_image src="calendar.png"} {translate key=AllTime}</a>
                            <a href="#" reportId="{CannedReport::USER_COUNT_THISWEEK}"
                               class="report report-action runNow">{html_image src="calendar-select-week.png"} {translate key=CurrentWeek}</a>
                            <a href="#" reportId="{CannedReport::USER_COUNT_THISMONTH}"
                               class="report report-action  runNow">{html_image src="calendar-select-month.png"} {translate key=CurrentMonth}</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div id="resultsDiv">
</div>

<div id="indicator" style="display:none; text-align: center;">
    <h3>{translate key=Working}</h3>
    {html_image src="admin-ajax-indicator.gif"}
</div>

{csrf_token}

{include file="Reports/chart.tpl"}

{include file="javascript-includes.tpl"}
{jsfile src="ajax-helpers.js"}
{jsfile src="reports/canned-reports.js"}
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

        var reports = new CannedReports(reportOptions);
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

{include file='globalfooter.tpl'}