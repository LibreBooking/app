{include file='globalheader.tpl' cssFiles='css/admin.css'}

<h1>{translate key=ManageGroups}</h1>

<div style="padding: 10px 0px;">
	Find Group:<br/>
	<input type="text" id="groupSearch" class="textbox" size="40"/> {html_link href=$smarty.server.SCRIPT_NAME key=AllGroups}
</div>
<table class="list">
	<tr>
		<th class="id">&nbsp;</th>
		<th>{translate key='Name'}</th>
		<th>&nbsp;</th>
		<th>{translate key='Members'}</th>
	</tr>
{foreach from=$groups item=group}
	{cycle values='row0,row1' assign=rowCss}
	<tr class="{$rowCss}">
		<td class="id"><input type="hidden" class="id" value="{$group->Id}"/></td>
		<td>{$group->Name}</td>
		<td><a href="#" class="update rename">{translate key='Rename'}</a></td>
		<td><a href="#" class="update members">{translate key='Manage'}</a></td>
	</tr>
{/foreach}
</table>

{pagination pageInfo=$PageInfo}

<input type="hidden" id="activeId" />

<div id="membersDialog" class="dialog" style="display:none;">
	<h4><span id="totalUsers"></span> Users in this group</h4>
	<div id="groupUserList"></div>
</div>

<div id="permissionsDialog" class="dialog" style="display:none;">
	<form id="permissionsForm" method="post">
		<div class="error">Actual access to resource may be different depending on user role, group permissions, or external permission settings</div>
		{foreach from=$resources item=resource}
			<label><input {formname key=RESOURCE_ID  multi=true} class="resourceId" type="checkbox" value="{$resource->GetResourceId()}"> {$resource->GetName()}</label><br/>
		{/foreach}
		<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>



{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}

<script type="text/javascript" src="{$Path}scripts/admin/edit.js"></script>
<script type="text/javascript" src="{$Path}scripts/admin/group.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.form-2.43.js"></script>

<script type="text/javascript">
	$(document).ready(function() {

	var actions = {
		activate: '{ManageGroupsActions::Activate}',
		deactivate: '{ManageGroupsActions::Deactivate}',
		permissions: '{ManageGroupsActions::Permissions}',
		password: '{ManageGroupsActions::Password}'
	};
			
	var groupOptions = {
		userAutocompleteUrl: "../ajax/autocomplete.php?type=user",
		groupAutocompleteUrl: "../ajax/autocomplete.php?type={AutoCompleteType::Group}",
		groupsUrl:  "{$Path}admin/manage_groups.php",
		permissionsUrl:  '{$smarty.server.SCRIPT_NAME}',
		submitUrl: '{$smarty.server.SCRIPT_NAME}',
		saveRedirect: '{$smarty.server.SCRIPT_NAME}',
		selectGroupUrl: '{$smarty.server.SCRIPT_NAME}?gid=',
		actions: actions
	};

	var groupManagement = new GroupManagement(groupOptions);
	groupManagement.init();

	{foreach from=$groups item=group}
		var group = {
			id: {$group->Id},
			name: '{$group->Name}'
		};
		groupManagement.addGroup(group);
	{/foreach}

	});
</script>
{include file='globalfooter.tpl'}