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
		<td>{$accessory->Name}</td>
		<td>{$accessory->QuantityAvailable|default:'&infin;'}</td>
		<td align="center"><a href="#" class="update edit">{translate key='Edit'}</a> | <a href="#" class="update delete">{translate key='Delete'}</a></td>
	</tr>
{/foreach}
</table>

<input type="hidden" id="activeId" />

<div id="deleteDialog" class="dialog" style="display:none;" title="{translate key=Delete}">
	<form id="deleteForm" method="post">
		<div class="error" style="margin-bottom: 25px;">
			<h3>{translate key=DeleteWarning}</h3>
			<div>{translate key=DeleteAccessoryWarning}</div>
		</div>
		<button type="button" class="button save">{html_image src="cross-button.png"} {translate key='Delete'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div id="editDialog" class="dialog" style="display:none;" title="{translate key=Edit}">
	<form id="editForm" method="post">
		{translate key=AccessoryName}<br/> <input id="editName" type="text" class="textbox required" maxlength="85" style="width:250px" {formname key=ACCESSORY_NAME} />
		<br/><br/>
		{translate key='QuantityAvailable'}<br/><input id="editQuantity" type="text" class="textbox" size="2" disabled="disabled" {formname key=ACCESSORY_QUANTITY_AVAILABLE} />
		<input type="checkbox" id="chkUnlimitedEdit" class="unlimited" name="chkUnlimited" checked="checked" />
		<label for="chkUnlimitedEdit"> {translate key=Unlimited}</label><br/><br/>
		<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div class="admin" style="margin-top:30px">
	<div class="title">
		{translate key=AddAccessory}
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
						<input type="text" id="addQuantity" class="textbox" size="2" disabled="disabled" {formname key=ACCESSORY_QUANTITY_AVAILABLE} />
						<input type="checkbox" id="chkUnlimitedAdd" class="unlimited" name="chkUnlimited" checked="checked" />
						<label for="chkUnlimitedAdd"> {translate key=Unlimited}</label>
					</td>
					<td>
						<button type="button" class="button save">{html_image src="plus-button.png"} {translate key=AddAccessory}</button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>

{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}

{jsfile src="admin/edit.js"}
{jsfile src="admin/accessory.js"}
{jsfile src="js/jquery.form-3.09.min.js"}

<script type="text/javascript">
	$(document).ready(function() {

	var actions = {
		add: '{ManageAccessoriesActions::Add}',
		edit: '{ManageAccessoriesActions::Change}',
		deleteAccessory: '{ManageAccessoriesActions::Delete}'
	};

	var accessoryOptions = {
		submitUrl: '{$smarty.server.SCRIPT_NAME}',
		saveRedirect: '{$smarty.server.SCRIPT_NAME}',
		actions: actions
	};

	var accessoryManagement = new AccessoryManagement(accessoryOptions);
	accessoryManagement.init();

	{foreach from=$accessories item=accessory}
		accessoryManagement.addAccessory('{$accessory->Id}', '{$accessory->Name|escape:javascript}', '{$accessory->QuantityAvailable}');
	{/foreach}

	});
</script>
{include file='globalfooter.tpl'}