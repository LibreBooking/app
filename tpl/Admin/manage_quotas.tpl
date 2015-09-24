{*
Copyright 2011-2015 Nick Korbel

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
{include file='globalheader.tpl'}
<div id="page-manage-quotas" class="admin-page">
	<h1>{translate key=ManageQuotas}</h1>

	<form id="addQuotaForm" method="post" role="form" class="form-inline">

		<div class="panel panel-default" id="add-quota-panel">
			<div class="panel-heading">{translate key="AddQuota"} {showhide_icon}</div>
			<div class="panel-body" id="addQuota">
				{capture name="schedules" assign="schedules"}
					<select class='form-control' {formname key=SCHEDULE_ID} title="Select Schedule">
						<option selected='selected' value=''>{translate key=AllSchedules}</option>
						{foreach from=$Schedules item=schedule}
							<option value='{$schedule->GetId()}'>{$schedule->GetName()|replace:',':' '}</option>
						{/foreach}
					</select>
				{/capture}

				{capture name="resources" assign="resources"}
					<select class='form-control' {formname key=RESOURCE_ID} title="Select Resource">
						<option selected='selected' value=''>{translate key=AllResources}</option>
						{foreach from=$Resources item=resource}
							<option value='{$resource->GetResourceId()}'>{$resource->GetName()|replace:',':' '}</option>
						{/foreach}
					</select>
				{/capture}

				{capture name="groups" assign="groups"}
					<select class='form-control' {formname key=GROUP} title="Select Group">
						<option selected='selected' value=''>{translate key=AllGroups}</option>
						{foreach from=$Groups item=group}
							<option value='{$group->Id}'>{$group->Name|replace:',':' '}</option>
						{/foreach}
					</select>
				{/capture}

				{capture name="amount" assign="amount"}
					<input type='number' step='any' class='form-control' min='0' value='0' {formname key=LIMIT} title="Quota number"/>
				{/capture}

				{capture name="unit" assign="unit"}
					<select class='form-control' {formname key=UNIT} title="Quota unit">
						<option value='{QuotaUnit::Hours}'>{translate key=hours}</option>
						<option value='{QuotaUnit::Reservations}'>{translate key=reservations}</option>
					</select>
				{/capture}

				{capture name="duration" assign="duration"}
					<select class='form-control' {formname key=DURATION} title="Quota frequency">
						<option value='{QuotaDuration::Day}'>{translate key=day}</option>
						<option value='{QuotaDuration::Week}'>{translate key=week}</option>
						<option value='{QuotaDuration::Month}'>{translate key=month}</option>
						<option value='{QuotaDuration::Year}'>{translate key=year}</option>
					</select>
				{/capture}

				{translate key=QuotaConfiguration args="$schedules,$resources,$groups,$amount,$unit,$duration"}

				<div class="note">{translate key=QuotaReminder}</div>
			</div>

			<div class="panel-footer">
				{add_button class="btn-sm"}
				{reset_button class="btn-sm"}
				{indicator}
			</div>
		</div>
	</form>

	<div class="panel panel-default" id="list-quotas-panel">
		<div class="panel-heading">{translate key="AllQuotas"}</div>
		<div class="panel-body no-padding" id="quotaList">
			{foreach from=$Quotas item=quota}
				{capture name="scheduleName" assign="scheduleName"}
					<span class='bold'>{if $quota->ScheduleName ne ""}
							{$quota->ScheduleName|replace:',':' '}
						{else}
							{translate key="AllSchedules"}
						{/if}
					</span>
				{/capture}
				{capture name="resourceName" assign="resourceName"}
					<span class='bold'>{if $quota->ResourceName ne ""}
							{$quota->ResourceName|replace:',':' '}
						{else}
							{translate key="AllResources"}
						{/if}
					</span>
				{/capture}
				{capture name="groupName" assign="groupName"}
					<span class='bold'>
						{if $quota->GroupName ne ""}
							{$quota->GroupName|replace:',':' '}
						{else}
							{translate key="AllGroups"}
						{/if}
					</span>
				{/capture}
				{capture name="amount" assign="amount"}
					<span class='bold'>{$quota->Limit}</span>
				{/capture}
				{capture name="unit" assign="unit"}
					<span class='bold'>{translate key=$quota->Unit}</span>
				{/capture}
				{capture name="duration" assign="duration"}
					<span class='bold'>{translate key=$quota->Duration}</span>
				{/capture}
				{cycle values='row0,row1' assign=rowCss}
				<div class="quotaItem {$rowCss}">
					{translate key=QuotaConfiguration args="$scheduleName,$resourceName,$groupName,$amount,$unit,$duration"}
					<a href="#" quotaId="{$quota->Id}" class="delete pull-right"><span class="fa fa-trash icon remove"></span></a>
				</div>
				{foreachelse}
				{translate key=None}
			{/foreach}
		</div>
	</div>

	<div class="modal fade" id="deleteDialog" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="deleteModalLabel">{translate key=Delete}</h4>
				</div>
				<div class="modal-body">
					<div class="alert alert-warning">
						{translate key=DeleteWarning}
					</div>
				</div>
				<div class="modal-footer">
					<form id="deleteQuotaForm" method="post">
						{cancel_button}
						{delete_button}
						{indicator}
					</form>
				</div>
			</div>
		</div>
	</div>

	{csrf_token}
	{jsfile src="ajax-helpers.js"}
	{jsfile src="admin/quota.js"}
	{jsfile src="js/jquery.form-3.09.min.js"}

	<script type="text/javascript">
		$(document).ready(function () {

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

			$('#add-quota-panel').showHidePanel();
		});
	</script>
</div>
{include file='globalfooter.tpl'}