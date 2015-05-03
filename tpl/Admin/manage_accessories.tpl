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
{include file='globalheader.tpl' cssFiles='css/admin.css'}

<h1>{translate key=ManageAccessories}</h1>

<table class="list">
	<tr>
		<th class="id">&nbsp;</th>
		<th>{translate key='AccessoryName'}</th>
		<th>{translate key='QuantityAvailable'}</th>
		<th>{translate key='Resources'}</th>
		<th>{translate key='Actions'}</th>
	</tr>
	{foreach from=$accessories item=accessory}
		{cycle values='row0,row1' assign=rowCss}
		<tr class="{$rowCss}" data-accessory-id="{$accessory->Id}">
			<td class="id"><input type="hidden" class="id" value="{$accessory->Id}"/></td>
			<td>{$accessory->Name}</td>
			<td>{$accessory->QuantityAvailable|default:'&infin;'}</td>
			<td><a href="#"
				   class="update resources">{if $accessory->AssociatedResources == 0}{translate key=All}{else}{$accessory->AssociatedResources}{/if}</a></td>
			<td align="center"><a href="#" class="update edit">{translate key='Edit'}</a> | <a href="#" class="update delete">{translate key='Delete'}</a></td>
		</tr>
	{/foreach}
</table>

<input type="hidden" id="activeId"/>

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
		<label for="editName">{translate key=AccessoryName}</label><br/> <input id="editName" type="text" class="textbox required" maxlength="85" style="width:250px" {formname key=ACCESSORY_NAME} />
		<br/><br/>
		<label for="editQuantity">{translate key='QuantityAvailable'}</label><br/><input id="editQuantity" type="text" class="textbox" size="2" disabled="disabled" {formname key=ACCESSORY_QUANTITY_AVAILABLE} />
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
					<th><label for="addName">{translate key='AccessoryName'}</label></th>
					<th><label for="addQuantity">{translate key='QuantityAvailable'}</label></th>
					<th>&nbsp;</th>
				</tr>
				<tr>
					<td>
						<input type="text" id="addName" class="textbox required" maxlength="85" style="width:250px" {formname key=ACCESSORY_NAME} />
					</td>
					<td>
						<input type="text" id="addQuantity" class="textbox" size="2" disabled="disabled" {formname key=ACCESSORY_QUANTITY_AVAILABLE} />
						<input type="checkbox" id="chkUnlimitedAdd" class="unlimited" name="chkUnlimited" checked="checked"/>
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

<div id="accessoryResourcesDialog" class="dialog">
	<form id="accessoryResourcesForm" ajaxAction="{ManageAccessoriesActions::ChangeAccessoryResource}" method="post">
		{foreach from=$resources item=resource}
			<div resource-id="{$resource->GetId()}">
				<label><input type="checkbox" data-type="resource-id" class="resourceCheckbox" name="{FormKeys::ACCESSORY_RESOURCE}[{$resource->GetId()}]" value="{$resource->GetId()}"> {$resource->GetName()}</label>

				<div class="hidden">
					<label>{translate key=MinimumQuantity} <input type="text" data-type="min-quantity" class="textbox" size="4" maxlength="4" name="{FormKeys::ACCESSORY_MIN_QUANTITY}[{$resource->GetId()}]"></label>
					<label>{translate key=MaximumQuantity} <input type="text" data-type="max-quantity" class="textbox" size="4" maxlength="4" name="{FormKeys::ACCESSORY_MAX_QUANTITY}[{$resource->GetId()}]"></label>
				</div>
			</div>
		{/foreach}
		<br/><br/>

		<div>
			<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
			<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
		</div>
	</form>
</div>

{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}

{jsfile src="admin/edit.js"}
{jsfile src="admin/accessory.js"}
{jsfile src="js/jquery.form-3.09.min.js"}

<script type="text/javascript">
	$(document).ready(function ()
	{

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