{include file='globalheader.tpl' cssFiles='css/admin.css'}

<h1>{translate key=ManageAccessories}</h1>

<table class="list">
	<tr>
		<th class="id">&nbsp;</th>
		<th>{translate key='AccessoryName'}</th>
		<th>{translate key='QuantityAvailable'}</th>
		<th>{translate key='Actions'}</th>
	</tr>
{foreach from=$accessories item=accessory}
	{cycle values='row0,row1' assign=rowCss}
	<tr class="{$rowCss}">
		<td class="id"><input type="hidden" class="id" value="{$accessory->Id}"/></td>
		<td >{$accessory->Name}</td>
		<td >{$accessory->QuantityAvailable}</td>
		<td align="center"><a href="#" class="update rename">{translate key='Rename'}</a> | <a href="#" class="update delete">{translate key='Delete'}</a></td>
	</tr>
{/foreach}
</table>

{pagination pageInfo=$PageInfo}

<input type="hidden" id="activeId" />

<div id="deleteDialog" class="dialog" style="display:none;">
	<form id="deleteAccessoryForm" method="post">
		<div class="error" style="margin-bottom: 25px;">
			<h3>This action is permanent and irrecoverable!</h3>
			<div>Deleting this accessory will remove it from all reservations.</div>
		</div>
		<button type="button" class="button save">{html_image src="cross-button.png"} {translate key='Delete'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div id="renameDialog" class="dialog" style="display:none;">
	<form id="renameAccessoryForm" method="post">
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
			<button type="button" class="button save">{html_image src="plus-button.png"} Add Group</button>
		</form>
	</div>
</div>


{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}

<script type="text/javascript" src="{$Path}scripts/admin/edit.js"></script>
<script type="text/javascript" src="{$Path}scripts/autocomplete.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.form-2.43.js"></script>

<script type="text/javascript">
	$(document).ready(function() {

	var actions = {
		add: '{ManageGroupsActions::AddGroup}',
		rename: '{ManageGroupsActions::RenameGroup}',
		delete: '{ManageGroupsActions::DeleteGroup}'
	};

	var accessoryOptions = {
		submitUrl: '{$smarty.server.SCRIPT_NAME}',
		saveRedirect: '{$smarty.server.SCRIPT_NAME}',
		actions: actions,
		dataRequests: dataRequests
	};

	var groupManagement = new GroupManagement(groupOptions);
	groupManagement.init();
	});
</script>
{include file='globalfooter.tpl'}