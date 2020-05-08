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

<div id="page-manage-resource-status" class="admin-page row">

    {function name=displayReason}
        {cycle values='row0,row1' assign=rowCss}
		<div class="{$rowCss} reason-item" reasonId="{$reason->Id()}">
			<span class="reason-description">{$reason->Description()}</span>

			<div class="pull-right">
				<a href="#" class="update edit">{translate key=Edit}</a> |
				<a href="#" class="update delete">{translate key=Delete}</a>
			</div>
		</div>
    {/function}

    {include file='Admin/Resources/manage_resource_menu.tpl' ResourcePageTitleKey='ManageResourceStatus'}

	<div id="globalError" class="error" style="display:none"></div>

	<div class="card resource-status-list" id="resource-status-list-available">
		<div class="card-content">
			<div class="card-title">
				{translate key="Available"}
				({$StatusReasons[{ResourceStatus::AVAILABLE}]|count})
                {showhide_icon}
			</div>
			<div class="panel-body add-contents">
				<div>
					<a href="#" add-to="{ResourceStatus::AVAILABLE}" class="add-link">{translate key="AddStatusReason"}
						<span class="fa fa-plus-circle icon add"></span>
					</a></div>
                {foreach from=$StatusReasons[{ResourceStatus::AVAILABLE}] item=reason}
                    {displayReason reason=$reason}
                {/foreach}
			</div>
		</div>
	</div>

	<div class="card resource-status-list" id="resource-status-list-unavailable">
		<div class="card-content">
			<div class="card-title">
				{translate key="Unavailable"}
				({$StatusReasons[{ResourceStatus::UNAVAILABLE}]|count})
                {showhide_icon}
			</div>
			<div class="panel-body add-contents">
				<a href="#" add-to="{ResourceStatus::UNAVAILABLE}" class="add-link">{translate key="AddStatusReason"}
					<span class="fa fa-plus-circle icon add"></span>
				</a>
                {foreach from=$StatusReasons[{ResourceStatus::UNAVAILABLE}] item=reason}
                    {displayReason reason=$reason}
                {/foreach}
			</div>
		</div>
	</div>

	<div class="card resource-status-list" id="resource-status-list-hidden">
		<div class="card-content">
			<div class="card-title">
				{translate key="Hidden"}
				({$StatusReasons[{ResourceStatus::HIDDEN}]|count})
                {showhide_icon}
			</div>
			<div class="panel-body add-contents">
				<a href="#" add-to="{ResourceStatus::HIDDEN}" class="add-link">{translate key="AddStatusReason"}
					<span class="fa fa-plus-circle icon add"></span>
				</a>
                {foreach from=$StatusReasons[{ResourceStatus::HIDDEN}] item=reason}
                    {displayReason reason=$reason}
                {/foreach}
			</div>
		</div>
	</div>

	<input type="hidden" id="activeId" value=""/>

	<div class="modal modal-fixed-header modal-fixed-footer" id="addDialog" tabindex="-1" role="dialog" aria-labelledby="addDialogLabel"
		 aria-hidden="true">
		<form id="addForm" method="post" ajaxAction="{ManageResourceStatusActions::Add}">
			<div class="modal-header">
				<h4 class="modal-title left" id="addResourceModalLabel">{translate key=AddStatusReason}</h4>
				<a href="#" class="modal-close right black-text"><i class="fa fa-remove"></i></a>
			</div>
			<div class="modal-content">
				<div class="input-field">
					<label for="add-reason-description">{translate key=Reason} *</label><br/>
					<input type="text" class="required" required
						   id="add-reason-description" {formname key=RESOURCE_STATUS_REASON} />
					<input type="hidden" id="add-reason-status" {formname key=RESOURCE_STATUS_ID} />
				</div>
			</div>
			<div class="modal-footer">
                {cancel_button}
                {add_button}
                {indicator}
			</div>
		</form>
	</div>

	<div class="modal modal-fixed-header modal-fixed-footer" id="editDialog" tabindex="-1" role="dialog" aria-labelledby="editDialogLabel"
		 aria-hidden="true">
		<form id="editForm" method="post" ajaxAction="{ManageResourceStatusActions::Update}">
			<div class="modal-header">
				<h4 class="modal-title left" id="editDialogLabel">{translate key=Edit}</h4>
				<a href="#" class="modal-close right black-text"><i class="fa fa-remove"></i></a>
			</div>
			<div class="modal-content">
				<div class="input-field">
					<label for="edit-reason-description">{translate key=Name} *</label><br/>
					<input type="text" class="required" required
						   id="edit-reason-description" {formname key=RESOURCE_STATUS_REASON} />
					<input type="hidden" id="add-reason-status" {formname key=RESOURCE_STATUS_ID} />
				</div>
			</div>
			<div class="modal-footer">
                {cancel_button}
                {update_button submit=true}
                {indicator}
			</div>
		</form>
	</div>

	<div class="modal modal-fixed-header modal-fixed-footer" id="deleteDialog" tabindex="-1" role="dialog" aria-labelledby="deleteDialogLabel"
		 aria-hidden="true">
		<form id="deleteForm" method="post" ajaxAction="{ManageResourceStatusActions::Delete}">
			<div class="modal-header">
				<h4 class="modal-title left" id="deleteDialogLabel">{translate key=Delete}</h4>
				<a href="#" class="modal-close right black-text"><i class="fa fa-remove"></i></a>
			</div>
			<div class="modal-content">
				<div class="card error">
					<div class="card-content">
						<div>{translate key=DeleteWarning}</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
                {cancel_button}
                {delete_button}
                {indicator}
			</div>
		</form>

	</div>

    {csrf_token}
    {include file="javascript-includes.tpl"}
    {jsfile src="ajax-helpers.js"}
    {jsfile src="admin/resource-status.js"}
    {jsfile src="js/jquery.form-3.09.min.js"}

	<script type="text/javascript">

		$(document).ready(function () {
			$('div.modal').modal();

			$('#moreResourceActions').dropdown({
				constrainWidth: false, coverTrigger: false
			});

			var opts = {
				submitUrl: '{$smarty.server.SCRIPT_NAME}', saveRedirect: '{$smarty.server.SCRIPT_NAME}'
			};

			var resourceStatus = new ResourceStatusManagement(opts);
			resourceStatus.init();

			$('#resource-status-list-available').showHidePanel();
			$('#resource-status-list-unavailable').showHidePanel();
			$('#resource-status-list-hidden').showHidePanel();
		})

	</script>

</div>

{include file='globalfooter.tpl'}