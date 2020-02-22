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

{include file='globalheader.tpl' cssFiles='scripts/css/jquery.contextMenu.css,scripts/css/jqtree.css'}

<div id="page-manage-resource-groups" class="admin-page row">

    {include file='Admin/Resources/manage_resource_menu.tpl' ResourcePageTitleKey='ManageResourceGroups'}

    <div id="globalError" class="error no-show"></div>

    <div id="manage-resource-groups-container">
        <div id="new-group" class="row">
            <form method="post" id="addGroupForm" ajaxAction="{ManageResourceGroupsActions::AddGroup}">
                <div class="form-group">
                    <label for="groupName" class="no-show">{translate key=AddNewGroup}</label>
                    <input type="text" name="{FormKeys::GROUP_NAME}" class="form-control new-group inline" size="30"
                           id="groupName" placeholder="{translate key=AddNewGroup}"/>
                    <input type="hidden" name="{FormKeys::PARENT_ID}"/>
                    <a href="#" class="fa fa-plus-circle icon add inline" id="btnAddGroup"><span
                                class="no-show">{translate key=Add}</span></a>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="col m6 s12">
                <div>Groups</div>
                <div id="group-tree"></div>
            </div>
            <div class="col m6 s12">
                <div id="resource-list">
                    <div>{translate key=Resources}</div>
                    {foreach from=$Resources item=resource}
                        <div class="resource-draggable" resource-name="{$resource->GetName()|escape:javascript}"
                             resource-id="{$resource->GetId()}">{$resource->GetName()}</div>
                    {/foreach}
                </div>
            </div>
        </div>

    </div>

    {*	<div class="alert alert-warning" id="resourceGroupWarning" role="alert">*}
    {*		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span*}
    {*					aria-hidden="true">&times;</span></button>*}
    {*		{translate key=ResourceGroupWarning}*}
    {*	</div>*}

    <input type="hidden" id="activeId" value=""/>

    <div id="renameDialog" class="modal modal-fixed-header modal-fixed-footer" tabindex="-1" role="dialog"
         aria-labelledby="renameGroupDialogLabel"
         aria-hidden="true">
        <form id="renameForm" method="post" ajaxAction="{ManageResourceGroupsActions::RenameGroup}">
            <div class="modal-header">
                <h4 class="modal-title left" id="addResourceModalLabel">{translate key=Rename}</h4>
                <a href="#" class="modal-close right black-text"><i class="fa fa-remove"></i></a>
            </div>
            <div class="modal-content">
                <div class="input-field">
                    <input id="editName" type="text" class="required triggerSubmit" required="required"
                           maxlength="85" {formname key=GROUP_NAME} />
                    <label for="editName" class="active">{translate key='Name'} *</label>
                </div>
            </div>
            <div class="modal-footer">
                {cancel_button}
                {update_button}
                {indicator}
            </div>
        </form>
    </div>

    <div id="deleteDialog" class="modal modal-fixed-header modal-fixed-footer" tabindex="-1" role="dialog"
         aria-labelledby="deleteDialogLabel"
         aria-hidden="true">
        <form id="deleteForm" method="post" ajaxAction="{ManageResourceGroupsActions::DeleteGroup}">
            <div class="modal-header">
                <h4 class="modal-title left" id="addResourceModalLabel">{translate key=Delete}</h4>
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

    <div id="addChildDialog" class="modal modal-fixed-header modal-fixed-footer" tabindex="-1" role="dialog"
         aria-labelledby="addGroupDialogLabel"
         aria-hidden="true">
        <form id="addChildForm" method="post" ajaxAction="{ManageResourceGroupsActions::AddGroup}">
            <div class="modal-header">
                <h4 class="modal-title left" id="addResourceModalLabel">{translate key=AddNewGroup}</h4>
                <a href="#" class="modal-close right black-text"><i class="fa fa-remove"></i></a>
            </div>
            <div class="modal-content">
                <div class="input-field">
                    <label for="childName">{translate key='Name'} *</label>
                    <input id="childName" type="text" class="required new-group" required="required" maxlength="85"
                            {formname key=GROUP_NAME} />
                </div>
            </div>
            <div class="modal-footer">
                {cancel_button}
                {add_button}
                <input type="hidden" id="groupParentId" name="{FormKeys::PARENT_ID}"/>
                {indicator}
            </div>
        </form>
    </div>

    {*	<div id="help" class="alert alert-info" role="alert">*}
    {*		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span*}
    {*					aria-hidden="true">&times;</span></button>*}
    {*		<div>{translate key=ResourceGroupHelp1}</div>*}
    {*		<div>{translate key=ResourceGroupHelp2}</div>*}
    {*		<div>{translate key=ResourceGroupHelp3}</div>*}
    {*	</div>*}

    {csrf_token}

    {include file="javascript-includes.tpl"}
    {jsfile src="ajax-helpers.js"}
    {jsfile src="admin/resource-groups.js"}
    {jsfile src="js/jquery.form-3.09.min.js"}
    {jsfile src="js/tree.jquery.js"}
    {jsfile src="js/jquery.cookie.js"}
    {jsfile src="js/jquery.contextMenu.js"}

    <script type="text/javascript">

        $(document).ready(function () {
            $('#moreResourceActions').dropdown({
                constrainWidth: false,
                coverTrigger: false
            });

            $('div.modal').modal();

            var actions = {
                addResource: '{ManageResourceGroupsActions::AddResource}',
                removeResource: '{ManageResourceGroupsActions::RemoveResource}',
                moveNode: '{ManageResourceGroupsActions::MoveNode}'
            };

            var groupOptions = {
                submitUrl: '{$smarty.server.SCRIPT_NAME}',
                actions: actions,
                renameText: '{translate key=Rename|escape:'javascript'}',
                addChildText: '{translate key=AddGroup|escape:'javascript'}',
                deleteText: '{translate key=Delete|escape:'javascript'}',
                exitText: '{translate key=Close|escape:'javascript'}'
            };

            var groupManagement = new ResourceGroupManagement(groupOptions);
            groupManagement.init({$ResourceGroups});

            $('#help-button').click(function (e) {
                $('#' + $(this).attr('help-ref')).dialog();
            });
        });

    </script>
</div>

{include file='globalfooter.tpl'}