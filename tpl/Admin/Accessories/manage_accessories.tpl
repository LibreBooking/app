{*
Copyright 2011-2020 Nick Korbel

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

<div id="page-manage-accessories" class="admin-page row">
	<div>
		<div class="right">
			<button class="add-accessory-prompt btn admin-action-button waves-effect waves-light" id="add-accessory-prompt">
                {translate key="AddAccessory"}
				<span class="fas fa-plus-circle icon"></span>
			</button>
		</div>
		<h1 class="page-title underline">{translate key=ManageAccessories}</h1>
	</div>

	{pagination pageInfo=$PageInfo showCount=true}

	<table class="table" id="accessoriesTable">
		<thead>
		<tr>
			<th>{sort_column key=AccessoryName field=ColumnNames::ACCESSORY_NAME}</th>
			<th>{sort_column key=QuantityAvailable field=ColumnNames::ACCESSORY_QUANTITY}</th>
			<th>{translate key='Resources'}</th>
			<th class="action">{translate key='Actions'}</th>
		</tr>
		</thead>
		<tbody>
        {foreach from=$accessories item=accessory}
            {cycle values='row0,row1' assign=rowCss}
			<tr class="{$rowCss}" data-accessory-id="{$accessory->Id}">
				<td>{$accessory->Name}</td>
				<td>{$accessory->QuantityAvailable|default:'&infin;'}</td>
				<td>
					<button class="btn btn-flat btn-link update resources">{if $accessory->AssociatedResources == 0}{translate key=All}{else}{$accessory->AssociatedResources}{/if}</button>
				</td>
				<td class="action">
					<button class="btn btn-flat btn-link update edit" title="{translate key=Edit}">
						<span class="far fa-edit update edit icon"></button>
					|
					<button class="btn btn-flat btn-link update delete" title="{translate key=Delete}">
						<span class="fas fa-trash update icon delete remove"></span></button>
				</td>
			</tr>
        {/foreach}
		</tbody>
	</table>

	{pagination pageInfo=$PageInfo showCount=true}

	<input type="hidden" id="activeId"/>

	<div class="modal modal-fixed-header modal-fixed-footer" id="addDialog" tabindex="-1" role="dialog" aria-labelledby="addDialogLabel"
		 aria-hidden="true">
		<form id="addForm" role="form" method="post">
			<div class="modal-header">
				<h4 class="modal-title left" id="deleteDialogLabel">{translate key=AddAccessory}</h4>
                {close_modal}
			</div>
			<div class="modal-content">
				<div class="row">
					<div class="input-field">
						<label for="accessoryName">{translate key=AccessoryName} *</label>
						<input {formname key=ACCESSORY_NAME} type="text" autofocus id="accessoryName" required
															 class="required"/>
					</div>
				</div>
				<div class="row">
					<div class="input-field inline">
						<label for="addQuantity">{translate key='QuantityAvailable'}</label>
						<input type="number" id="addQuantity" class="" min="0"
							   disabled="disabled" {formname key=ACCESSORY_QUANTITY_AVAILABLE} />
					</div>
					<div class="inline margin-left-1">
						<label for="chkUnlimitedAdd">
							<input type="checkbox" id="chkUnlimitedAdd" class="unlimited" name="chkUnlimited"
								   checked="checked"/>
							<span>{translate key=Unlimited} </span>
						</label>
					</div>
				</div>
			</div>
			<div class="modal-footer">
                {cancel_button}
                {add_button submit=true}
                {indicator}
			</div>
		</form>
	</div>

	<div class="modal modal-fixed-header modal-fixed-footer" id="deleteDialog" tabindex="-1" role="dialog" aria-labelledby="deleteDialogLabel"
		 aria-hidden="true">
		<form id="deleteForm" method="post">
			<div class="modal-header">
				<h4 class="modal-title left" id="deleteDialogLabel">{translate key=Delete}</h4>
                {close_modal}
			</div>
			<div class="modal-content">
				<div class="alert alert-warning">
					<div>{translate key=DeleteWarning}</div>
					<div>{translate key=DeleteAccessoryWarning}</div>
				</div>
			</div>
			<div class="modal-footer">
                {cancel_button}
                {delete_button submit=true}
                {indicator}
			</div>
		</form>
	</div>

	<div class="modal modal-fixed-header modal-fixed-footer" id="editDialog" tabindex="-1" role="dialog" aria-labelledby="editDialogLabel"
		 aria-hidden="true">
		<form id="editForm" method="post">
			<div class="modal-header">
				<h4 class="modal-title left" id="editDialogLabel">{translate key=Edit}</h4>
                {close_modal}
			</div>
			<div class="modal-content">
				<div class="row">
					<div class="input-field">
						<label for="editName">{translate key=AccessoryName} *</label>
						<input id="editName" type="text" class="required" autofocus
							   maxlength="85" {formname key=ACCESSORY_NAME} />
					</div>
				</div>
				<div class="row">
					<div class="input-field inline">
						<label for="editQuantity" class="active">{translate key='QuantityAvailable'}</label>
						<input id="editQuantity" type="number" min="0" class=""
							   disabled="disabled" {formname key=ACCESSORY_QUANTITY_AVAILABLE} />
					</div>
					<div class="inline margin-left-1">
						<label for="chkUnlimitedEdit">
							<input type="checkbox" id="chkUnlimitedEdit" class="unlimited" name="chkUnlimited"
								   checked="checked"/>
							<span>{translate key=Unlimited}</span>
						</label>
					</div>
				</div>
			</div>
			<div class="modal-footer">
                {cancel_button}
                {update_button submit=true}
                {indicator}
			</div>
		</form>
	</div>

	<div class="modal modal-fixed-header modal-fixed-footer" id="accessoryResourcesDialog" tabindex="-1" role="dialog"
		 aria-labelledby="resourcesDialogLabel" aria-hidden="true">
		<form id="accessoryResourcesForm" role="form"
			  ajaxAction="{ManageAccessoriesActions::ChangeAccessoryResource}" method="post">
			<div class="modal-header row">
				<h4 class="modal-title left" id="resourcesDialogLabel">{translate key=Resources}</h4>
                {close_modal}
			</div>
			<div class="modal-content">
                {foreach from=$resources item=resource}
                    {assign var="resourceId" value="{$resource->GetId()}"}
					<div resource-id="{$resourceId}">
						<label for="accessoryResource{$resourceId}">
							<input id="accessoryResource{$resourceId}" type="checkbox" data-type="resource-id"
								   class="resourceCheckbox"
								   name="{FormKeys::ACCESSORY_RESOURCE}[{$resource->GetId()}]"
								   value="{$resource->GetId()}">
							<span>{$resource->GetName()}</span>
						</label>
					</div>
					<div class="quantities no-show form-group-sm">
						<div class="input-field">
							<label>{translate key=MinimumQuantity}
								<input type="number" min="0" data-type="min-quantity" class=""
									   size="4" maxlength="4"
									   name="{FormKeys::ACCESSORY_MIN_QUANTITY}[{$resource->GetId()}]"></label>
						</div>
						<div class="input-field">
							<label>{translate key=MaximumQuantity}
								<input type="number" min="0" data-type="max-quantity" class=""
									   size="4" maxlength="4"
									   name="{FormKeys::ACCESSORY_MAX_QUANTITY}[{$resource->GetId()}]"></label>
						</div>
					</div>
                {/foreach}
			</div>
			<div class="modal-footer">
                {cancel_button}
                {update_button submit=true}
                {indicator}
			</div>
		</form>
	</div>

    {csrf_token}

    {include file="javascript-includes.tpl"}
    {jsfile src="ajax-helpers.js"}
    {jsfile src="admin/accessory.js"}
    {jsfile src="js/jquery.form-3.09.min.js"}

	<script type="text/javascript">
		$(document).ready(function () {

			$('div.modal').modal();

			var actions = {
				add: '{ManageAccessoriesActions::Add}', edit: '{ManageAccessoriesActions::Change}', deleteAccessory: '{ManageAccessoriesActions::Delete}'
			};

			var accessoryOptions = {
				submitUrl: '{$smarty.server.SCRIPT_NAME}', saveRedirect: '{$smarty.server.SCRIPT_NAME}', actions: actions
			};

			var accessoryManagement = new AccessoryManagement(accessoryOptions);
			accessoryManagement.init();

            {foreach from=$accessories item=accessory}
			accessoryManagement.addAccessory('{$accessory->Id}', '{$accessory->Name|escape:javascript}', '{$accessory->QuantityAvailable}');
            {/foreach}

			$('#add-accessory-panel').showHidePanel();
		});
	</script>

</div>
{include file='globalfooter.tpl'}