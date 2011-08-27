{include file='globalheader.tpl' cssFiles='css/admin.css'}

<h1>{translate key=ManageUsers}</h1>

<div style="padding: 10px 0px;">
Find User:<br/>
<input type="text" id="userSearch" class="textbox" size="40"/> {html_link href=$smarty.server.SCRIPT_NAME key=AllUsers}
</div>
<table class="list">
	<tr>
		<th class="id">&nbsp;</th>
		<th>{translate key='Name'}</th>
		<th>{translate key='Username'}</th>
		<th>{translate key='Email'}</th>
		<th>{translate key='Phone'}</th>
		<th>{translate key='Organization'}</th>
		<th>{translate key='Position'}</th>
		<th>{translate key='Created'}</th>
		<th>{translate key='LastLogin'}</th>
		<th>{translate key='Timezone'}</th>
		<th>{translate key='Language'}</th>
		<th>{translate key='Status'}</th>
		<th>{translate key='Groups'}</th>
		<th>{translate key='Permissions'}</th>
		<th>{translate key='Reservations'}</th>
		<th>{translate key='Password'}</th>
		<th>{translate key='Delete'}</th>
	</tr>
{foreach from=$users item=user}
	{cycle values='row0,row1' assign=rowCss}
	<tr class="{$rowCss}">
		<td class="id"><input type="hidden" class="id" value="{$user->Id}"/></td>
		<td>{$user->First} {$user->Last}</td>
		<td>{$user->Username}</td>
		<td><a href="mailto:{$user->Email}">{$user->Email}</a></td>
		<td>{$user->Phone}</td>
		<td>{$user->Organization}</td>
		<td>{$user->Position}</td>
		<td>{$user->Created}</td>
		<td>{$user->LastLogin}</td>
		<td>{$user->TimezoneName}</td>
		<td>{$user->Language}</td>
		<td align="center"><a href="#" class="update changeStatus">{translate key=$statusDescriptions[$user->StatusId]}</a></td>
		<td align="center"><a href="#" class="update changeGroups">{translate key='Edit'}</a></td>
		<td align="center"><a href="#" class="update changePermissions">{translate key='Edit'}</a></td>
		<td align="center"><a href="#" class="update viewReservations">{translate key='Search'}</a></td>
		<td align="center"><a href="#" class="update resetPassword">{translate key='Reset'}</a></td>
		<td align="center"><input type="checkbox"></input></td>
	</tr>
{/foreach}
</table>

<input type="hidden" id="activeId" />

<div id="permissionsDialog" class="dialog" style="display:none;">
	<form id="permissionsForm" method="post">
		<div class="error">Actual access to resource may be different depending on user role, group permissions, or external permission settings</div>
		{foreach from=$resources item=resource}
			<label><input {formname key=RESOURCE_ID  multi=true} class="resourceId" type="checkbox" value="{$resource->GetResourceId()}"> {$resource->GetName()}</label><br/>
		{/foreach}
		<button type="button" class="button save">{html_image src="tick-circle.png"} {translate key='Update'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div id="passwordDialog" class="dialog" style="display:none;">
	<form id="passwordForm" method="post">
		Password<br/>
		{textbox type="password" name="PASSWORD" class="required textbox" value=""}
		<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

{pagination pageInfo=$PageInfo}

{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}

<script type="text/javascript" src="{$Path}scripts/admin/edit.js"></script>
<script type="text/javascript" src="{$Path}scripts/autocomplete.js"></script>
<script type="text/javascript" src="{$Path}scripts/admin/user.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.form-2.43.js"></script>

<script type="text/javascript">
	$(document).ready(function() {

	var actions = {
		activate: '{ManageUsersActions::Activate}',
		deactivate: '{ManageUsersActions::Deactivate}',
		permissions: '{ManageUsersActions::Permissions}',
		password: '{ManageUsersActions::Password}'
	};
			
	var userOptions = {
		userAutocompleteUrl: "../ajax/autocomplete.php?type=user",
		groupsUrl:  "{$Path}admin/manage_groups.php",
		permissionsUrl:  '{$smarty.server.SCRIPT_NAME}',
		submitUrl: '{$smarty.server.SCRIPT_NAME}',
		saveRedirect: '{$smarty.server.SCRIPT_NAME}',
		selectUserUrl: '{$smarty.server.SCRIPT_NAME}?uid=',
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