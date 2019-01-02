{*
Copyright 2011-2019 Nick Korbel

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

<div id="page-manage-accessories" class="admin-page">
	<h1>{translate key=ManageAccessories}</h1>

	<form id="addForm" class="form-inline" role="form" method="post">
		<div class="panel panel-default" id="add-accessory-panel">
			<div class="panel-heading">{translate key="AddAccessory"} {showhide_icon}</div>
			<div class="panel-body add-contents">
				<div class="col-xs-5">
					<div class="form-group has-feedback">
						<label for="accessoryName">{translate key=AccessoryName}</label>
						<input {formname key=ACCESSORY_NAME} type="text" autofocus id="accessoryName" required class="form-control required"/>
						<i class="glyphicon glyphicon-asterisk form-control-feedback" data-bv-icon-for="accessoryName"></i>
					</div>
				</div>
				<div class="col-xs-7">
					<div class="form-group">
						<label for="addQuantity">{translate key='QuantityAvailable'}</label>
						<input type="number" id="addQuantity" class="form-control" min="0" disabled="disabled" {formname key=ACCESSORY_QUANTITY_AVAILABLE} />
					</div>
					<div class="checkbox checkbox-align">
						<input type="checkbox" id="chkUnlimitedAdd" class="unlimited" name="chkUnlimited" checked="checked"/>
						<label for="chkUnlimitedAdd"> {translate key=Unlimited}</label>
					</div>
				</div>
			</div>
			<div class="panel-footer">
				{add_button class="btn-sm"}
				{reset_button class="btn-sm"}
			</div>
		</div>
	</form>

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
					<a href="#"
					   class="update resources">{if $accessory->AssociatedResources == 0}{translate key=All}{else}{$accessory->AssociatedResources}{/if}</a>
				</td>
				<td class="action">
					<a href="#" class="update edit"><span class="no-show"></span>
                        <span class="no-show">{translate key=Edit}</span>
                        <span class="fa fa-pencil-square-o icon"></a> |
					<a href="#" class="update delete">
                        <span class="no-show">{translate key=Delete}</span>
                        <span class="fa fa-trash icon remove"></span></a>
				</td>
			</tr>
		{/foreach}
		</tbody>
	</table>

	<input type="hidden" id="activeId"/>

	<div class="modal fade" id="deleteDialog" tabindex="-1" role="dialog" aria-labelledby="deleteDialogLabel" aria-hidden="true">
		<div class="modal-dialog">
			<form id="deleteForm" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="deleteDialogLabel">{translate key=Delete}</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-warning">
							<div>{translate key=DeleteWarning}</div>
							<div>{translate key=DeleteAccessoryWarning}</div>
						</div>
					</div>
					<div class="modal-footer">
						{cancel_button}
						{delete_button}
						{indicator}
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="modal fade" id="editDialog" tabindex="-1" role="dialog" aria-labelledby="editDialogLabel" aria-hidden="true">
		<div class="modal-dialog">
			<form id="editForm" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="editDialogLabel">{translate key=Edit}</h4>
					</div>
					<div class="modal-body">
						<div class="form-group has-feedback col-xs-12">
							<label for="editName">{translate key=AccessoryName}</label>
							<input id="editName" type="text" class="form-control required" autofocus maxlength="85" {formname key=ACCESSORY_NAME} />
						</div>
						<div class="form-group col-xs-4">
							<label for="editQuantity">{translate key='QuantityAvailable'}</label>
							<input id="editQuantity" type="number" min="0" class="form-control"
								   disabled="disabled" {formname key=ACCESSORY_QUANTITY_AVAILABLE} />
						</div>
						<div class="form-group col-xs-8">
							<div class="checkbox checkbox-align">
								<input type="checkbox" id="chkUnlimitedEdit" class="unlimited" name="chkUnlimited" checked="checked"/>
								<label for="chkUnlimitedEdit">{translate key=Unlimited}</label>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="modal-footer">
						{cancel_button}
						{update_button}
						{indicator}
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="modal fade" id="accessoryResourcesDialog" tabindex="-1" role="dialog" aria-labelledby="resourcesDialogLabel" aria-hidden="true">
		<div class="modal-dialog">
			<form id="accessoryResourcesForm" role="form" ajaxAction="{ManageAccessoriesActions::ChangeAccessoryResource}" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="resourcesDialogLabel">{translate key=Resources}</h4>
					</div>
					<div class="modal-body scrollable-modal-content">
						{foreach from=$resources item=resource}
							{assign var="resourceId" value="{$resource->GetId()}"}
							<div resource-id="{$resourceId}">
								<div class="checkbox">
									<input id="accessoryResource{$resourceId}" type="checkbox" data-type="resource-id" class="resourceCheckbox"
										   name="{FormKeys::ACCESSORY_RESOURCE}[{$resource->GetId()}]"
										   value="{$resource->GetId()}">
									<label for="accessoryResource{$resourceId}"> {$resource->GetName()}</label>
								</div>
								<div class="quantities no-show form-group-sm">
									<label>{translate key=MinimumQuantity}
										<input type="number" min="0" data-type="min-quantity" class="form-control" size="4" maxlength="4"
											   name="{FormKeys::ACCESSORY_MIN_QUANTITY}[{$resource->GetId()}]"></label>
									<label>{translate key=MaximumQuantity}
										<input type="number" min="0" data-type="max-quantity" class="form-control" size="4" maxlength="4"
											   name="{FormKeys::ACCESSORY_MAX_QUANTITY}[{$resource->GetId()}]"></label>
								</div>
							</div>
						{/foreach}
					</div>
					<div class="modal-footer">
						{cancel_button}
						{update_button}
						{indicator}
					</div>
				</div>
			</form>
		</div>
	</div>

	{csrf_token}

    {include file="javascript-includes.tpl"}
	{jsfile src="ajax-helpers.js"}
	{jsfile src="admin/accessory.js"}
	{jsfile src="js/jquery.form-3.09.min.js"}

	<script type="text/javascript">
		$(document).ready(function () {

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

			$('#add-accessory-panel').showHidePanel();
		});
	</script>

</div>
{include file='globalfooter.tpl'}