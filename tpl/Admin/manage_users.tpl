{include file='globalheader.tpl'}
<style type="text/css">
	@import url({$Path}css/admin.css);
</style>

<h1>Manage Users</h1>

Find User: <input type="text" id="userSearch"/>
<table class="list">
	<tr>
		<th class="id">&nbsp;</th>
		<th>{translate key='Name'}</th>
		<th>{translate key='Username'}</th>
		<th>{translate key='Email'}</th>
		<th>{translate key='LastLogin'}</th>
		<th>{translate key='Timezone'}</th>
		<th>{translate key='Status'}</th>
		<th>{translate key='Groups'}</th>
		<th>{translate key='ResourcePermissions'}</th>
		<th>{translate key='Reservations'}</th>
		<th>&nbsp;</th>
	</tr>
{foreach from=$users item=user}
	{cycle values='row0,row1' assign=rowCss}
	<tr class="{$rowCss}">
		<td class="id"><input type="hidden" class="id" value="{$user->Id}"/></td>
		<td>{$user->First} {$user->Last}</td>
		<td>{$user->Username}</td>
		<td>{$user->Email}</td>
		<td>{$user->LastLogin}</td>
		<td>{$user->Timezone}</td>
		<td><a href="#" class="update changeStatus">{translate key=$statusDescriptions[$user->StatusId]}</a></td>
		<td><a href="#" class="update changeGroups">{translate key='Change'}</a></td>
		<td><a href="#" class="update changePermissions">{translate key='Change'}</a></td>
		<td><a href="#" class="update viewReservations">{translate key='Search'}</a></td>
		<td><a href="#" class="update resetPassword">{translate key='ResetPassword'}</a></td>
	</tr>
{/foreach}
</table>

<input type="hidden" id="activeId" />

<div id="permissionsDialog" class="dialog" style="display:none;">
	<form id="permissionsForm" method="post">
		* Actual access to resource may be different depending on group permissions and external permission settings<br/>
		{foreach from=$resources item=resource}
			<label><input class="resourceId" type="checkbox" value="{$resource->GetResourceId()}"> {$resource->GetName()}</label><br/>
		{/foreach}
		<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<p>{$resultsStart} - {$resultsEnd} of {$totalResults}</p>
<p>Page {foreach from=$pages item=page} {pagelink page=$page} {/foreach}</p>

<script type="text/javascript" src="{$Path}scripts/admin/edit.js"></script>
<script type="text/javascript" src="{$Path}scripts/admin/user.js"></script>

<script type="text/javascript">
	$(document).ready(function() {

	var actions = {
		activate: '{ManageUsersActions::Activate}',
		deactivate:'{ManageUsersActions::Deactivate}'
	};
			
	var userOptions = {
		userAutocompleteUrl: "{$Path}ajax/autocomplete.php?type=user",
		groupsUrl:  "{$Path}admin/manage_groups.php",
		permissionsUrl:  '{$smarty.server.SCRIPT_NAME}',
		submitUrl: '{$smarty.server.SCRIPT_NAME}',
		saveRedirect: '{$smarty.server.SCRIPT_NAME}',
		actions: actions
	};

	var userManagement = new UserManagement(userOptions);
	userManagement.init();

	{foreach from=$users item=user}
		var user = {
			id: {$user->Id},
			first: '{$user->First}',
			last: '{$user->Last}',
			isActive: '{$user->IsActive()}'
		};
		userManagement.addUser(user);
	{/foreach}

	});
</script>
{include file='globalfooter.tpl'}