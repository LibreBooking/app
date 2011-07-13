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
		<th>{translate key='ResourcePermissions'}</th>
		<th>{translate key='Delete'}</th>
	</tr>
{foreach from=$groups item=group}
	{cycle values='row0,row1' assign=rowCss}
	<tr class="{$rowCss}">
		<td class="id"><input type="hidden" class="id" value="{$group->Id}"/></td>
		<td>{$group->Name}</td>
		<td><a href="#" class="update rename">{translate key='Rename'}</a></td>
		<td><a href="#" class="update members">{translate key='Manage'}</a></td>
		<td><a href="#" class="update permissions">{translate key='Change'}</a></td>
		<td><a href="#" class="update delete">{translate key='Delete'}</a></td>
	</tr>
{/foreach}
</table>

{pagination pageInfo=$PageInfo}

<input type="hidden" id="activeId" />

<div id="membersDialog" class="dialog" style="display:none;">
	Add User: <input type="text" id="userSearch" class="textbox" size="30" /> <a href="#" id="browseUsers">Browse <div id="allUsers" style="display:none;" class="dialog"></div></a>
	<h4><span id="totalUsers"></span> Users in this group</h4>
	<div id="groupUserList"></div>
</div>

<div id="permissionsDialog" class="dialog" style="display:none;">
	<form id="permissionsForm" method="post">
		{foreach from=$resources item=resource}
			<label><input {formname key=RESOURCE_ID  multi=true} class="resourceId" type="checkbox" value="{$resource->GetResourceId()}"> {$resource->GetName()}</label><br/>
		{/foreach}
		<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>


<form id="removeUserForm" method="post">
	<input type="hidden" id="removeUserId" {formname key=USER_ID} />
</form>

<form id="addUserForm" method="post">
	<input type="hidden" id="addUserId" {formname key=USER_ID} />
</form>

<div id="deleteDialog" class="dialog" style="display:none;">
	<form id="deleteGroupForm" method="post">
		<div class="error" style="margin-bottom: 25px;">
			<h3>This action is permanent and irrecoverable!</h3>
			<div>Deleting this group will remove all associated resource permissions.  Users in this group may lose access to resources.</div>
		</div>
		<button type="button" class="button save">{html_image src="cross-button.png"} {translate key='Delete'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div id="renameDialog" class="dialog" style="display:none;">
	<form id="renameGroupForm" method="post">
		Name<br/> <input type="text" class="textbox required" {formname key=GROUP_NAME} />
		<button type="button" class="button save">{html_image src="disk-black.png"} Rename Group</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div class="admin" style="margin-top:30px">
	<div class="title">
		Add New Group
	</div>
	<div>
		<div id="addGroupResults" class="error" style="display:none;"></div>
		<form id="addGroupForm" method="post">
			Name<br/> <input type="text" class="textbox required" {formname key=GROUP_NAME} />
			<button type="button" class="button save">{html_image src="disk-black.png"} Add Group</button>
		</form>
	</div>
</div>

{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}

<script type="text/javascript" src="{$Path}scripts/admin/edit.js"></script>
<script type="text/javascript" src="{$Path}scripts/autocomplete.js"></script>
<script type="text/javascript" src="{$Path}scripts/admin/group.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.form-2.43.js"></script>

<script type="text/javascript">
	$(document).ready(function() {

	var actions = {
		activate: '{ManageGroupsActions::Activate}',
		deactivate: '{ManageGroupsActions::Deactivate}',
		permissions: '{ManageGroupsActions::Permissions}',
		password: '{ManageGroupsActions::Password}',
		removeUser: '{ManageGroupsActions::RemoveUser}',
		addUser: '{ManageGroupsActions::AddUser}',
		addGroup: '{ManageGroupsActions::AddGroup}',
		renameGroup: '{ManageGroupsActions::RenameGroup}',
		deleteGroup: '{ManageGroupsActions::DeleteGroup}'
	};
			
	var groupOptions = {
		userAutocompleteUrl: "../ajax/autocomplete.php?type={AutoCompleteType::User}",
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
	});
</script>
{include file='globalfooter.tpl'}