{include file='globalheader.tpl' cssFiles='css/admin.css'}

<h1>{translate key=ManageQuotas}</h1>

<div class="admin">
	<div class="title">
		All Quotas
	</div>
	<div class="list">
		{foreach from=$Quotas item=quota}
			{capture name="resourceName" assign="resourceName"}
				<h4>{if $quota->ResourceName ne ""}
					{$quota->ResourceName}
				{else}
					{translate key="AllResources"}
				{/if}
				</h4>
			{/capture}
			{capture name="groupName" assign="groupName"}
				<h4>
				{if $quota->GroupName ne ""}
					{$quota->GroupName}
				{else}
					{translate key="AllGroups"}
				{/if}
				</h4>
			{/capture}
			{capture name="amount" assign="amount"}
				<h4>{$quota->Amount}</h4>
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
				{translate key=QuotaConfiguration args="$resourceName,$groupName,$amount,$unit,$duration"}
			</div>
		{foreachelse}
			{translate key=None}
		{/foreach}
	</div>
</div>

<div class="admin" style="margin-top:30px">
	<div class="title">
		Add Quota
	</div>
	<div>
		{capture name="resources" assign="resources"}
			<select class='textbox'>
				<option selected='selected'>{translate key=AllResources}</option>
			{foreach from=$Resources item=resource}
				<option value='{$resource->GetResourceId()}'>{$resource->GetName()}</option>
			{/foreach}
			</select>
		{/capture}
			
		{capture name="groups" assign="groups"}
			<select class='textbox'>
				<option>{translate key=AllGroups}</option>
			{foreach from=$Groups item=group}
				<option value='{$group->Id}'>{$group->Name}</option>
			{/foreach}
			</select>
		{/capture}
			
		{capture name="amount" assign="amount"}
			<input type='text' class='textbox' value='0' size='5'/>
		{/capture}
		{capture name="unit" assign="unit"}
			<select class='textbox'>
				<option>hours</option>
				<option>reservations</option>
			</select>
		{/capture}
		{capture name="duration" assign="duration"}
			<select class='textbox'>
				<option>day</option>
				<option>week</option>
				<option>month</option>
			</select>
		{/capture}

		{translate key=QuotaConfiguration args="$resources,$groups,$amount,$unit,$duration"}
		
		<button class="button">{html_image src="disk-black.png"} {translate key="Add"}</button>
		{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}
	</div>
	<div class="note">Remember: Quotas are enforced based on the schedule's timezone.</div>
</div>

<div id="deleteDialog" class="dialog" style="display:none;">
	<form id="deleteGroupForm" method="post">
		<div class="error" style="margin-bottom: 25px;">
			<h3>This action is permanent and irrecoverable!</h3>
		</div>
		<button type="button" class="button save">{html_image src="cross-button.png"} {translate key='Delete'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<script type="text/javascript" src="{$Path}scripts/admin/edit.js"></script>
<script type="text/javascript" src="{$Path}scripts/admin/quota.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.form-2.43.js"></script>

<script type="text/javascript">
	$(document).ready(function() {

	var actions = {
	};

	var quotaOptions = {
	};

	var quotaManagement = new QuotaManagement(quotaOptions);
	quotaManagement.init();
	});
</script>
{include file='globalfooter.tpl'}