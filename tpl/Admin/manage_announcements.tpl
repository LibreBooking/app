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

<div id="page-manage-announcements" class="admin-page row">
    <h1 class="page-title">{translate key=ManageAnnouncements}</h1>

    <div class="card" id="add-announcement-panel">
        <form id="addForm" class="form-inline" role="form" method="post">
            <div class="card-content">
                <div class="panel-heading">{translate key="AddAnnouncement"} {showhide_icon}</div>
                <div class="panel-body add-contents">
                    <div id="addResults" class="card error no-show"></div>
                    <div class="input-field col s12">
                        <label for="addAnnouncement">{translate key='Announcement'}</label>
                        <textarea class="materialize-textarea required"
                                  rows="1" {formname key=ANNOUNCEMENT_TEXT} id="addAnnouncement"></textarea>
                    </div>
                    <div class="input-field col m3 s6">
                        <label for="BeginDate">{translate key='BeginDate'}</label>
                        <input type="text" id="BeginDate" class="" {formname key=ANNOUNCEMENT_START} />
                        <input type="hidden" id="formattedBeginDate" {formname key=ANNOUNCEMENT_START} />
                    </div>
                    <div class="input-field col m3 s6">
                        <label for="EndDate">{translate key='EndDate'}</label>
                        <input type="text" id="EndDate" class="" {formname key=ANNOUNCEMENT_END} />
                        <input type="hidden" id="formattedEndDate" {formname key=ANNOUNCEMENT_END} />
                    </div>
                    <div class="input-field col m3 s6">
                        <label for="addPriority">{translate key='Priority'}</label>
                        <input type="number" min="0" step="1" class="" {formname key=ANNOUNCEMENT_PRIORITY}
                               id="addPriority"/>
                    </div>
                    <div class="input-field col m3 s6">
                        <label for="addPage" class="active">{translate key='DisplayPage'}</label>
                        <select id="addPage" class="" {formname key=DISPLAY_PAGE}>
                            <option value="1">{translate key=Dashboard}</option>
                            <option value="5">{translate key=Login}</option>
                        </select>
                    </div>
                    <div class="input-field col s12 m6">
                        <label for="announcementGroups" class="active">{translate key=UsersInGroups}</label>
                        <select id="announcementGroups" class=""
                                multiple="multiple" {formname key=FormKeys::GROUP_ID multi=true}>
                            {foreach from=$Groups item=group}
                                <option value="{$group->Id}">{$group->Name}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="input-field col s12 m6">
                        <label for="resourceGroups"
                               class="active">{translate key=UsersWithAccessToResources}</label>
                        <select id="resourceGroups" class=""
                                multiple="multiple" {formname key=RESOURCE_ID multi=true}>
                            {foreach from=$Resources item=resource}
                                <option value="{$resource->GetId()}">{$resource->GetName()}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="input-field col s12">
                        <label for="sendAsEmail">
                            <input type="checkbox" id="sendAsEmail" {formname key=FormKeys::SEND_AS_EMAIL} />
                            <span>{translate key=SendAsEmail}</span>
                        </label>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="card-action align-right">
                {reset_button class="btn-sm"}
                {add_button class="btn-sm"}
                {indicator}
            </div>
        </form>
    </div>

    <table class="table" id="announcementList">
        <thead>
        <tr>
            <th>{sort_column key=Announcement field=ColumnNames::ANNOUNCEMENT_TEXT}</th>
            <th>{sort_column key=Priority field=ColumnNames::ANNOUNCEMENT_PRIORITY}</th>
            <th>{sort_column key=BeginDate field=ColumnNames::ANNOUNCEMENT_START}</th>
            <th>{sort_column key=EndDate field=ColumnNames::ANNOUNCEMENT_END}</th>
            <th>{translate key='Groups'}</th>
            <th>{translate key='Resources'}</th>
            <th>{translate key='DisplayPage'}</th>
            <th class="action">{translate key='Actions'}</th>
        </tr>
        </thead>
        <tbody>
        {foreach from=$announcements item=announcement}
            {cycle values='row0,row1' assign=rowCss}
            <tr class="{$rowCss}" data-announcement-id="{$announcement->Id()}">
                <td class="announcementText">{$announcement->Text()|nl2br}</td>
                <td class="announcementPriority">{$announcement->Priority()}</td>
                <td class="announcementStart">{formatdate date=$announcement->Start()->ToTimezone($timezone)}</td>
                <td class="announcementEnd">{formatdate date=$announcement->End()->ToTimezone($timezone)}</td>
                <td class="announcementGroups">{foreach from=$announcement->GroupIds() item=groupId}{$Groups[$groupId]->Name} {/foreach}</td>
                <td class="announcementResources">{foreach from=$announcement->ResourceIds() item=resourceId}{$Resources[$resourceId]->GetName()} {/foreach}</td>
                <td class="announcementDisplayPage">{translate key={Pages::NameFromId($announcement->DisplayPage())}}</td>
                <td class="action announcementActions">
                    <a href="#" title="{translate key=Edit}" class="update edit"><span
                                class="fa fa-pencil-square-o icon"></a> |
                    {if $announcement->CanEmail()}
                        <a href="#" title="{translate key=Email}" class="update sendEmail"><span
                                    class="fa fa-envelope-o icon"></a>
                        |
                    {/if}
                    <a href="#" title="{translate key=Delete}" class="update delete"><span
                                class="fa fa-trash icon remove"></span></a>
                </td>
            </tr>
        {/foreach}
        </tbody>
    </table>

    <input type="hidden" id="activeId"/>

    <div class="modal modal-fixed-header modal-fixed-footer" id="deleteDialog" tabindex="-1" role="dialog"
         aria-labelledby="deleteDialogLabel"
         aria-hidden="true">
        <form id="deleteForm" method="post">
            <div class="modal-header">
                <h4 class="modal-title left" id="deleteDialogLabel">{translate key=Delete}</h4>
                <a href="#" class="modal-close right black-text"><i class="fas fa-times"></i></a>
            </div>
            <div class="modal-content">
                <div class="card warning">
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

    <div class="modal modal-fixed-header modal-fixed-footer" id="editDialog" tabindex="-1" role="dialog"
         aria-labelledby="editDialogLabel"
         aria-hidden="true">
        <form id="editForm" method="post">
            <div class="modal-header">
                <h4 class="modal-title left" id="editDialogLabel">{translate key=Edit}</h4>
                <a href="#" class="modal-close right black-text"><i class="fas fa-times"></i></a>
            </div>
            <div class="modal-content">
                <div class="input-field">
                    <label for="editText">{translate key=Announcement}</label><br/>
                    <textarea id="editText" class="required materialize-textarea"
                              required {formname key=ANNOUNCEMENT_TEXT}></textarea>
                </div>
                <div class="input-field ">
                    <label for="editBegin">{translate key='BeginDate'}</label><br/>
                    <input type="text" id="editBegin" class=""/>
                    <input type="hidden" id="formattedEditBegin" {formname key=ANNOUNCEMENT_START} />
                </div>
                <div class="input-field ">
                    <label for="editEnd">{translate key='EndDate'}</label><br/>
                    <input type="text" id="editEnd" class=""/>
                    <input type="hidden" id="formattedEditEnd" {formname key=ANNOUNCEMENT_END} />
                </div>
                <div class="input-field ">
                    <label for="editPriority">{translate key='Priority'}</label> <br/>
                    <input type="number" min="0" step="1" id="editPriority"
                           class="" {formname key=ANNOUNCEMENT_PRIORITY} />
                </div>
                <div class="input-field " id="editUserGroupsDiv">
                    <label for="editUserGroups" class="active">{translate key=UsersInGroups}</label>
                    <select id="editUserGroups" class=""
                            multiple="multiple" {formname key=FormKeys::GROUP_ID multi=true}>
                        {foreach from=$Groups item=group}
                            <option value="{$group->Id}">{$group->Name}</option>
                        {/foreach}
                    </select>
                </div>
                <div class="input-field " id="editResourceGroupsDiv">
                    <label for="editResourceGroups"
                           class="active">{translate key=UsersWithAccessToResources}</label>
                    <select id="editResourceGroups" class="" multiple="multiple" {formname key=RESOURCE_ID multi=true}>
                        {foreach from=$Resources item=resource}
                            <option value="{$resource->GetId()}">{$resource->GetName()}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                {cancel_button}
                {update_button}
                {indicator}
            </div>
        </form>
    </div>

    <div class="modal modal-fixed-header modal-fixed-footer" id="emailDialog" tabindex="-1" role="dialog"
         aria-labelledby="emailDialogLabel"
         aria-hidden="true">
        <form id="emailForm" method="post">
            <div class="modal-header">
                <h4 class="modal-title left" id="emailDialogLabel">{translate key=SendAsEmail}</h4>
                <a href="#" class="modal-close right black-text"><i class="fas fa-times"></i></a>
            </div>
            <div class="modal-content">
                <div class="card info">
                    <div class="card-content">
                        <span id="emailCount" class="bold"></span> {translate key=AnnouncementEmailNotice}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {cancel_button}
                {update_button key=SendAsEmail}
                {indicator}
            </div>
        </form>
    </div>

    {include file="javascript-includes.tpl"}
    {control type="DatePickerSetupControl" ControlId="BeginDate" AltId="formattedBeginDate"}
    {control type="DatePickerSetupControl" ControlId="EndDate" AltId="formattedEndDate"}
    {control type="DatePickerSetupControl" ControlId="editBegin" AltId="formattedEditBegin"}
    {control type="DatePickerSetupControl" ControlId="editEnd" AltId="formattedEditEnd"}

    {csrf_token}

    {jsfile src="ajax-helpers.js"}
    {jsfile src="admin/announcement.js"}
    {jsfile src="js/jquery.form-3.09.min.js"}

    <script type="text/javascript">
        $(document).ready(function () {

            $('div.modal').modal();

            var actions = {
                add: '{ManageAnnouncementsActions::Add}',
                edit: '{ManageAnnouncementsActions::Change}',
                deleteAnnouncement: '{ManageAnnouncementsActions::Delete}',
                email: '{ManageAnnouncementsActions::Email}'
            };

            var accessoryOptions = {
                submitUrl: '{$smarty.server.SCRIPT_NAME}',
                saveRedirect: '{$smarty.server.SCRIPT_NAME}',
                getEmailCountUrl: '{$smarty.server.SCRIPT_NAME}?dr=emailCount',
                actions: actions
            };

            var announcementManagement = new AnnouncementManagement(accessoryOptions);
            announcementManagement.init();

            {foreach from=$announcements item=announcement}
            announcementManagement.addAnnouncement(
                '{$announcement->Id()}',
                '{$announcement->Text()|escape:"quotes"|regex_replace:"/[\n]/":"\\n"}',
                '{formatdate date=$announcement->Start()->ToTimezone($timezone)}',
                '{formatdate date=$announcement->End()->ToTimezone($timezone)}',
                '{$announcement->Priority()}',
                [{foreach from=$announcement->GroupIds() item=id}{$id},{/foreach}],
                [{foreach from=$announcement->ResourceIds() item=id}{$id},{/foreach}],
                    {$announcement->DisplayPage()}
            );
            {/foreach}

            $('#add-announcement-panel').showHidePanel();

        });
    </script>
</div>
{include file='globalfooter.tpl'}
