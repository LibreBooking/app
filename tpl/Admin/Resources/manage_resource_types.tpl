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
{include file='globalheader.tpl' InlineEdit=true}

<div id="page-manage-resource-types" class="admin-page row">

    {include file='Admin/Resources/manage_resource_menu.tpl' ResourcePageTitleKey='ManageResourceTypes'}

    <div id="globalError" class="error" style="display:none"></div>

    <form id="addForm" ajaxAction="{ManageResourceTypesActions::Add}" class="form-inline" role="form" method="post">
        <div class="card admin-panel">
            <div class="card-content" id="add-resource-type-panel">
                <div class="panel-heading">{translate key="AddResourceType"} {showhide_icon}</div>
                <div class="panel-body add-contents">
                    <div id="addResults" class="error no-show"></div>
                    <div class="input-field">
                        <label for="resourceTypeName">{translate key='Name'} *</label>
                        <input type="text" class="required" required="required" maxlength="85"
                                {formname key=RESOURCE_TYPE_NAME} id="resourceTypeName"/>
                    </div>
                    <div class="input-field">
                        <label for="resourceTypeDesc">{translate key='Description'}</label>
                        <textarea class="materialize-textarea" rows="1" {formname key=RESOURCE_TYPE_DESCRIPTION}
							  id="resourceTypeDesc"></textarea>
                    </div>
                </div>
            </div>
            <div class="card-action align-right">
                {reset_button id="clearFilter"}
                {add_button submit=true}
                {indicator}
            </div>
        </div>
    </form>

    <table class="table" id="resourceTypes">
        <thead>
        <tr>
            <th>{translate key='Name'}</th>
            <th>{translate key='Description'}</th>
            <th class="action">{translate key='Actions'}</th>
        </tr>
        </thead>
        <tbody>
        {foreach from=$ResourceTypes item=type}
            {cycle values='row0,row1' assign=rowCss}
            {assign var=id value=$type->Id()}
            <tr class="{$rowCss}">
                <td>{$type->Name()}</td>
                <td>{$type->Description()|nl2br}</td>
                <td class="action">
                    <a href="#" class="update edit"><span class="fa fa-pencil-square-o icon"></a> |
                    <a href="#" class="update delete"><span class="fa fa-trash icon remove"></span></a>
                    <input type="hidden" class="id" value="{$id}"/>
                </td>
            </tr>
            {if $AttributeList|count > 0}
                <tr>
                    <td colspan="4">
                        {foreach from=$AttributeList item=attribute}
                            {include file='Admin/InlineAttributeEdit.tpl' id=$id attribute=$attribute value=$type->GetAttributeValue($attribute->Id())}
                        {/foreach}
                    </td>
                </tr>
            {/if}
        {/foreach}
        </tbody>
    </table>

    <input type="hidden" id="activeId" value=""/>

    <div class="modal modal-fixed-header modal-fixed-footer" id="editDialog" tabindex="-1" role="dialog"
         aria-labelledby="editDialogLabel"
         aria-hidden="true">
        <form id="editForm" method="post" ajaxAction="{ManageResourceTypesActions::Update}">
            <div class="modal-header">
                <h4 class="modal-title left" id="addResourceModalLabel">{translate key=Edit}</h4>
                <a href="#" class="modal-close right black-text"><i class="fa fa-remove"></i></a>
            </div>
            <div class="modal-content">
                <div class="input-field">
                    <label for="editName" class="active">{translate key=Name} *</label>
                    <input type="text" id="editName"
                           class="required" required="required"
                           maxlength="85" {formname key=RESOURCE_TYPE_NAME} />
                </div>
                <div class="input-field">
                    <label for="editDescription">{translate key='Description'}</label>
                    <textarea class="materialize-textarea" rows="1" {formname key=RESOURCE_TYPE_DESCRIPTION}
									  id="editDescription"></textarea>
                </div>

            </div>
            <div class="modal-footer">
                {cancel_button}
                {update_button}
                {indicator}
            </div>
        </form>
    </div>

    <div class="modal modal-fixed-header modal-fixed-footer" id="deleteDialog" tabindex="-1" role="dialog"
         aria-labelledby="deleteDialogLabel"
         aria-hidden="true">
        <form id="deleteForm" method="post" ajaxAction="{ManageResourceTypesActions::Delete}">
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
</div>

{csrf_token}

{include file="javascript-includes.tpl" InlineEdit=true}
{jsfile src="ajax-helpers.js"}
{jsfile src="admin/resource-types.js"}
{jsfile src="js/jquery.form-3.09.min.js"}

<script type="text/javascript">

    function hidePopoversWhenClickAway() {
        $('body').on('click', function (e) {
            $('[rel="popover"]').each(function () {
                if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
                    $(this).popover('hide');
                }
            });
        });
    }

    function setUpEditables() {
        $.fn.editable.defaults.mode = 'popup';
        $.fn.editable.defaults.toggle = 'manual';
        $.fn.editable.defaults.emptyclass = '';
        $.fn.editable.defaults.params = function (params) {
            params.CSRF_TOKEN = $('#csrf_token').val();
            return params;
        };

        var updateUrl = '{$smarty.server.SCRIPT_NAME}?action=';

        $('.inlineAttribute').editable({
            url: updateUrl + '{ManageResourceTypesActions::ChangeAttribute}',
            emptytext: '-'
        });
    }

    $(document).ready(function () {
        $('#moreResourceActions').dropdown({
            constrainWidth: false,
            coverTrigger: false
        });

        $('div.modal').modal();

        setUpEditables();

        var opts = {
            submitUrl: '{$smarty.server.SCRIPT_NAME}',
            saveRedirect: '{$smarty.server.SCRIPT_NAME}'
        };

        var resourceTypes = new ResourceTypeManagement(opts);
        resourceTypes.init();

        {foreach from=$ResourceTypes item=type}
        resourceTypes.add(
            {
                id:{$type->Id()},
                name: "{$type->Name()|escape:'javascript'}",
                description: "{$type->Description()|escape:'javascript'}"
            });
        {/foreach}
    });


    $('#add-resource-type-panel').showHidePanel();


</script>
</div>

{include file='globalfooter.tpl'}
