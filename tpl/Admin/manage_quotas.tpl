{*
Copyright 2011-2014 Nick Korbel

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
{include file='globalheader.tpl' cssFiles='css/admin.css'}

<h1>{translate key=ManageQuotas}</h1>

<div class="admin">
	<div class="title">
		{translate key=AllQuotas}
	</div>
	<div class="list" id="quotaList">
		{foreach from=$Quotas item=quota}
			{capture name="scheduleName" assign="scheduleName"}
				<h4>{if $quota->ScheduleName ne ""}
					{$quota->ScheduleName|replace:',':' '}
				{else}
					{translate key="AllSchedules"}
				{/if}
				</h4>
			{/capture}
			{capture name="resourceName" assign="resourceName"}
				<h4>{if $quota->ResourceName ne ""}
					{$quota->ResourceName|replace:',':' '}
				{else}
					{translate key="AllResources"}
				{/if}
				</h4>
			{/capture}
			{capture name="groupName" assign="groupName"}
				<h4>
				{if $quota->GroupName ne ""}
					{$quota->GroupName|replace:',':' '}
				{else}
					{translate key="AllGroups"}
				{/if}
				</h4>
			{/capture}
			{capture name="amount" assign="amount"}
				<h4>{$quota->Limit}</h4>
			{/capture}
			{capture name="unit" assign="unit"}
				<h4>{translate key=$quota->Unit}</h4>
			{/capture}
			{capture name="duration" assign="duration"}
				<h4>{translate key=$quota->Duration}</h4>
			{/capture}
			{cycle values='row0,row1' assign=rowCss}

			<div class="{$rowCss}">
				<a href="#" quotaId="{$quota->Id}" class="delete">{html_image src="cross-button.png"}</a>
				{translate key=QuotaConfiguration args="$scheduleName,$resourceName,$groupName,$amount,$unit,$duration"}
			</div>
		{foreachelse}
			{translate key=None}
		{/foreach}
	</div>
</div>

<div class="admin" style="margin-top:30px">
	<div class="title">
		{translate key=AddQuota}
	</div>
	<div>
		<form id="addQuotaForm" method="post">
		{capture name="schedules" assign="schedules"}
			<select class='textbox' {formname key=SCHEDULE_ID}>
				<option selected='selected' value=''>{translate key=AllSchedules}</option>
			{foreach from=$Schedules item=schedule}
				<option value='{$schedule->GetId()}'>{$schedule->GetName()|replace:',':' '}</option>
			{/foreach}
			</select>
		{/capture}

		{capture name="resources" assign="resources"}
			<select class='textbox' {formname key=RESOURCE_ID}>
				<option selected='selected' value=''>{translate key=AllResources}</option>
			{foreach from=$Resources item=resource}
				<option value='{$resource->GetResourceId()}'>{$resource->GetName()|replace:',':' '}</option>
			{/foreach}
			</select>
		{/capture}

		{capture name="groups" assign="groups"}
			<select class='textbox' {formname key=GROUP}>
				<option selected='selected' value=''>{translate key=AllGroups}</option>
			{foreach from=$Groups item=group}
				<option value='{$group->Id}'>{$group->Name|replace:',':' '}</option>
			{/foreach}
			</select>
		{/capture}

		{capture name="amount" assign="amount"}
			<input type='text' class='textbox' value='0' size='5' {formname key=LIMIT} />
		{/capture}

		{capture name="unit" assign="unit"}
			<select class='textbox' {formname key=UNIT}>
				<option value='{QuotaUnit::Hours}'>{translate key=hours}</option>
				<option value='{QuotaUnit::Reservations}'>{translate key=reservations}</option>
			</select>
		{/capture}

		{capture name="duration" assign="duration"}
			<select class='textbox' {formname key=DURATION}>
				<option value='{QuotaDuration::Day}'>{translate key=day}</option>
				<option value='{QuotaDuration::Week}'>{translate key=week}</option>
				<option value='{QuotaDuration::Month}'>{translate key=month}</option>
			</select>
		{/capture}

		{translate key=QuotaConfiguration args="$schedules,$resources,$groups,$amount,$unit,$duration"}

		<button type="button" class="button save">{html_image src="plus-circle.png"} {translate key="Add"}</button>
		{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}
		</form>
	</div>
	<div class="note">{translate key=QuotaReminder}</div>
</div>

<div id="deleteDialog" class="dialog" style="display:none;" title="{translate key=Delete}">
	<form id="deleteQuotaForm" method="post">
		<div class="error" style="margin-bottom: 25px;">
			<h3>{translate key=DeleteWarning}</h3>
		</div>
		<button type="button" class="button save">{html_image src="cross-button.png"} {translate key='Delete'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

{jsfile src="admin/edit.js"}
{jsfile src="admin/quota.js"}
{jsfile src="js/jquery.form-3.09.min.js"}

<script type="text/javascript">
	$(document).ready(function() {

	var actions = {
		addQuota: '{ManageQuotasActions::AddQuota}',
		deleteQuota: '{ManageQuotasActions::DeleteQuota}'
	};

	var quotaOptions = {
		submitUrl: '{$smarty.server.SCRIPT_NAME}',
		saveRedirect: '{$smarty.server.SCRIPT_NAME}',
		actions: actions
	};

	var quotaManagement = new QuotaManagement(quotaOptions);
	quotaManagement.init();
	});
</script>
{include file='globalfooter.tpl'}