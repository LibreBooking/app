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

<h2>My Saved Reports</h2>
{if $ReportList|count == 0}
you have no saved reports <a href="{$Path}reports/{Pages::REPORTS_GENERATE}">{translate key=GenerateReport}</a>
{else}
<div id="report-list">
<ul>
	{foreach from=$ReportList item=report}
		<li>{$report->ReportName()|default:$untitled} {translate key=Created}: {format_date date=$report->DateCreated()} <a href="#" reportId="{$report->Id()}">Run Now</a> <a href="#" reportId="{$report->Id()}">Schedule</a></li>
	{/foreach}
</ul>
</div>
{/if}

<div id="resultsDiv">
</div>

<div id="indicator" style="display:none; text-align: center;">
<h3>{translate key=Working}...</h3>
{html_image src="admin-ajax-indicator.gif"}
</div>

{include file='globalfooter.tpl'}