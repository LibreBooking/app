{*
Copyright 2011-2012 Nick Korbel

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
{include file='globalheader.tpl'}
<div id="reportingbox">
<form class="reports" method="post" action="{$smarty.server.SCRIPT_NAME}">

{validation_group class="error"}
        {validator id="name" key="NameRequired"}
{/validation_group}

	<div class="reportingHeader"><h3>Scheduler report generator</h3></div>
	<div>
		<table class="reportingn">
			<tr><th class="admin-fieldHeading">{translate key="FormFields"}</th>
				<th class="reporting">{translate key="Included"}</th>
			</tr>
			<tr>
				<td class="admin-fieldName">{translate key="FirstName"}</td>
                <td class="center"><input type="checkbox" class="admin-radio" name="{constant echo='FormKeys::FIRST_NAME'}" value="1" checked="checked" tabindex="11" /></td>
			</tr>
			<tr>
				<td class="admin-fieldName">{translate key="LastName"}</td>
                <td class="center"><input type="checkbox" class="admin-radio" name="{constant echo='FormKeys::LAST_NAME'}" value="1" checked="checked" tabindex="11" /></td>
			</tr>
			<tr>
				<td class="admin-fieldName">{translate key="Username"}</td>
				<td class="center"><input type="checkbox" class="admin-radio" name="{constant echo='FormKeys::USERNAME'}" value="1" checked="checked" tabindex="11" /></td>
			</tr>
			<tr>
				<td class="admin-fieldName">{translate key="Organization"}</td>
				<td class="center"><input type="checkbox" class="admin-radio" name="{constant echo='FormKeys::ORGANIZATION'}" value="1" checked="checked" tabindex="11" /></td>
			</tr>
			<tr>
				<td class="admin-fieldName">{translate key="Group"}</td>
				<td class="center"><input type="checkbox" class="admin-radio" name="{constant echo='FormKeys::GROUP'}" value="1" checked="checked" tabindex="11" /></td>
			</tr>
			<tr>
				<td class="admin-fieldName">{translate key="Resource"}</td>
				<td class="center"><input type="checkbox" class="admin-radio" name="{constant echo='FormKeys::RESOURCE'}" value="1" checked="checked" tabindex="11" /></td>
			</tr>
			<tr>
				<td class="admin-fieldName">{translate key="ReportStartTime"}</td>
				<td class="center"><input type="checkbox" class="admin-radio" name="{constant echo='FormKeys::REPORT_START'}" value="1" checked="checked" tabindex="11" /></td>
			</tr>
			<tr>
				<td class="admin-fieldName">{translate key="ReportEndTime"}</td>
				<td class="center"><input type="checkbox" class="admin-radio" name="{constant echo='FormKeys::REPORT_END'}" value="1" checked="checked" tabindex="11" /></td>
			</tr>
		</table>
	</div>
	<div id="reportingbox-footer">
        <p class="reporting-submit">
                <input type="submit" name="{constant echo='Actions::GET_REPORT'}" value="{translate key='GetReport'}" class="button" tabindex="200" />
        </p>
	</div>
</form>
</div>
{setfocus key='RESOURCE_NAME'}
{include file='globalfooter.tpl'}
