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
		<td >{$accessory->QuantityAvailable|default:'&infin;'}</td>
		<td align="center"><a href="#" class="update edit">{translate key='Edit'}</a> | <a href="#" class="update delete">{translate key='Delete'}</a></td>
	</tr>
{/foreach}
</table>

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

<div id="editDialog" class="dialog" style="display:none;">
	<form id="editForm" method="post">
		{translate key=AccessoryName}<br/> <input type="text" class="textbox required" maxlength="85" style="width:250px" {formname key=ACCESSORY_NAME} />
		<br/><br/>
		{translate key='QuantityAvailable'}<br/><input type="text" class="textbox" size="2" disabled="disabled" {formname key=ACCESSORY_QUANTITY_AVAILABLE} />
		<input type="checkbox" id="chkUnlimitedEdit" class="unlimited" name="chkUnlimited" checked="checked" />
		<label for="chkUnlimitedEdit"> {translate key=Unlimited}</label><br/><br/>
		<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div class="admin" style="margin-top:30px">
	<div class="title">
		Add New Accessory
	</div>
	<div>
		<div id="addResults" class="error" style="display:none;"></div>
		<form id="addForm" method="post">
			<table>
				<tr>
					<th>{translate key='AccessoryName'}</th>
					<th>{translate key='QuantityAvailable'}</th>
					<th>&nbsp;</th>
				</tr>
				<tr>
					<td>
						<input type="text" class="textbox required" maxlength="85" style="width:250px" {formname key=ACCESSORY_NAME} />
					</td>
					<td>
						<input type="text" class="textbox" size="2" disabled="disabled" {formname key=ACCESSORY_QUANTITY_AVAILABLE} />
						<input type="checkbox" id="chkUnlimitedAdd" class="unlimited" name="chkUnlimited" checked="checked" />
						<label for="chkUnlimitedAdd"> {translate key=Unlimited}</label>
					</td>
					<td>
						<button type="button" class="button save">{html_image src="plus-button.png"} Add Accessory</button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>

{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}

<script type="text/javascript" src="{$Path}scripts/admin/edit.js"></script>
<script type="text/javascript" src="{$Path}scripts/admin/accessory.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.form-2.43.js"></script>

<script type="text/javascript">
	$(document).ready(function() {

	var actions = {
		add: '{ManageAccessoriesActions::Add}',
		edit: '{ManageAccessoriesActions::Change}',
		delete: '{ManageAccessoriesActions::Delete}'
	};

	var accessoryOptions = {
		submitUrl: '{$smarty.server.SCRIPT_NAME}',
		saveRedirect: '{$smarty.server.SCRIPT_NAME}',
		actions: actions
	};

	var accessoryManagement = new AccessoryManagement(accessoryOptions);
	accessoryManagement.init();
	});
</script>
{include file='globalfooter.tpl'}