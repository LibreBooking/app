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
{include file='globalheader.tpl' InlineEdit=true cssFiles='scripts/css/colorpicker.css'}

<div id="page-manage-users" class="admin-page row">

    <div>
        <div class="dropdown admin-header-more pull-right">
            <button class="btn btn-flat dropdown-trigger" type="button" id="moreUserActions"
                    data-target="dropdown-menu">
                <span class="fa fa-bars"></span>
                <span class="no-show">More</span>
            </button>
            <ul id="dropdown-menu" class="dropdown-content" role="menu" aria-labelledby="moreUserActions">
                <li>
                    <a role="menuitem" href="#" id="invite-users" class="">{translate key="InviteUsers"}
                        <span class="fa fa-send"></span>
                    </a>
                </li>
                <li>
                    <a role="menuitem" href="#" id="import-users" class="">{translate key="Import"}
                        <span class="fa fa-upload"></span>
                    </a>
                </li>
                <li>
                    <a role="menuitem" href="{$ExportUrl}" download="{$ExportUrl}" id="export-users"
                       class="" target="_blank">{translate key="Export"}
                        <span class="fa fa-download"></span>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a role="menuitem" href="#" id="add-user" class="">{translate key="AddUser"}
                        <span class="fa fa-plus-circle add icon"></span>
                    </a>
                </li>
            </ul>
        </div>
        <h4>{translate key='ManageUsers'}</h4>
    </div>


    <div>
        <form id="filterForm" class="" role="form">
            <div class="input-field col s6">
                <label for="userSearch">{translate key=FindUser}
                    | {html_link href=$smarty.server.SCRIPT_NAME key=AllUsers}</label>
                <input type="text" id="userSearch"
                       class="form-control"/>
            </div>
            <div class="input-field col s2">
                <label for="filterStatusId" class="active">{translate key=Status}</label>
                <select id="filterStatusId" class="form-control">
                    {html_options selected=$FilterStatusId options=$statusDescriptions}
                </select>
            </div>
            <div class="col s4">
                &nbsp;
            </div>
            <div class="clearfix"></div>
        </form>
    </div>

    {assign var=colCount value=11}
    <table class="table admin-panel" id="userList">
        <thead>
        <tr>
            <th>{sort_column key=Name field=ColumnNames::LAST_NAME}</th>
            <th>{sort_column key=Username field=ColumnNames::USERNAME}</th>
            <th>{sort_column key=Email field=ColumnNames::EMAIL}</th>
            <th>{sort_column key=Phone field=ColumnNames::PHONE_NUMBER}</th>
            <th>{sort_column key=Organization field=ColumnNames::ORGANIZATION}</th>
            <th>{sort_column key=Position field=ColumnNames::POSITION}</th>
            <th>{sort_column key=Created field=ColumnNames::USER_CREATED}</th>
            <th>{sort_column key=LastLogin field=ColumnNames::LAST_LOGIN}</th>
            <th class="action">{sort_column key=Status field=ColumnNames::USER_STATUS}</th>
            {if $CreditsEnabled}
                <th class="action">{translate key=Credits}</th>
                {assign var=colCount value=$colCount+1}
            {/if}
            {if $PerUserColors}
                <th class="action">{translate key='Color'}</th>
                {assign var=colCount value=$colCount+1}
            {/if}
            <th class="action">{translate key='Actions'}</th>
            <th class="action-delete">
                <label for="delete-all">
                    <input type="checkbox" id="delete-all" aria-label="{translate key=All}"
                           title="{translate key=All}"/>
                    <span>&nbsp;</span>
                </label>
            </th>
        </tr>
        </thead>
        <tbody>
        {foreach from=$users item=user}
            {cycle values='row0,row1' assign=rowCss}
            {assign var=id value=$user->Id}
            <tr class="{$rowCss}" data-userId="{$id}">
                <td>{fullname first=$user->First last=$user->Last ignorePrivacy="true"}</td>
                <td>{$user->Username}</td>
                <td><a href="mailto:{$user->Email}">{$user->Email}</a></td>
                <td>{$user->Phone}</td>
                <td>{$user->Organization}</td>
                <td>{$user->Position}</td>
                <td>{format_date date=$user->DateCreated key=short_datetime timezone=$Timezone}</td>
                <td>{format_date date=$user->LastLogin key=short_datetime timezone=$Timezone}</td>
                <td class="action"><a href="#" class="update changeStatus">{$statusDescriptions[$user->StatusId]}</a>
                    {indicator id="userStatusIndicator"}
                </td>
                {if $CreditsEnabled}
                    <td class="align-right">
						<span class="propertyValue inlineUpdate changeCredits"
                              data-type="number" data-pk="{$id}" data-value="{$user->CurrentCreditCount}"
                              data-name="{FormKeys::CREDITS}">{$user->CurrentCreditCount}</span>
                        <a href="credit_log.php?{QueryStringKeys::USER_ID}={$id}" title="{translate key=CreditHistory}">
                            {*                            <span class="no-color">{translate key=CreditHistory}</span>*}
                            <span class="fa fa-clock-o"></span>
                        </a>
                    </td>
                {/if}
                {if $PerUserColors}
                    <td class="action">
                        <a href="#" class="update changeColor">{translate key='Edit'}</a>
                        {if !empty($user->ReservationColor)}
                            <div class="user-color update changeColor"
                                 style="background-color:#{$user->ReservationColor}">&nbsp;
                            </div>
                        {/if}
                    </td>
                {/if}

                <td>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-flat update edit">
                            <span class="no-show">{translate key=Update}</span>
                            <span class="fa fa-pencil-square-o"></button>
                        <button type="button" class="btn btn-sm btn-flat dropdown-trigger"
                                id="{$id}user-edit-actions-label" data-target="{$id}user-edit-actions">
                            <span class="fa fa-caret-down"></span>
                            <span class="sr-only">{translate key=More}</span>
                        </button>
                        <ul class="dropdown-content user-edit-actions" role="menu"
                            aria-labelledby="{$id}user-edit-actions-label" id="{$id}user-edit-actions">
                            <li role="presentation"><a role="menuitem"
                                                       href="#" class="update edit">{translate key="Edit"}</a>
                            </li>
                            <li role="presentation"><a role="menuitem"
                                                       href="#"
                                                       class="update changePermissions">{translate key="Permissions"}</a>
                            </li>
                            <li role="presentation"><a role="menuitem"
                                                       href="#"
                                                       class="update changeGroups">{translate key="Groups"}</a>
                            </li>
                            <li role="presentation"><a role="menuitem"
                                                       href="#"
                                                       class="update viewReservations">{translate key="Reservations"}</a>
                            </li>
                            <li role="presentation"><a role="menuitem"
                                                       href="#"
                                                       class="update resetPassword">{translate key="ChangePassword"}</a>
                            </li>
                            <li role="presentation"><a role="menuitem"
                                                       href="#"
                                                       class="update delete">{translate key="Delete"} <span
                                            class="fa fa-trash icon remove"></span></a>
                            </li>

                        </ul>
                    </div>
                </td>
                <td class="action-delete">
                    <label for="delete{$id}" class="">
                        <input {formname key=USER_ID multi=true} class="delete-multiple" type="checkbox"
                                                                 id="delete{$id}" value="{$id}"
                                                                 aria-label="{translate key=Delete}"
                                                                 title="{translate key=Delete}"/>
                        <span>&nbsp;</span>
                    </label>
                </td>
            </tr>
            {assign var=attributes value=$AttributeList}
            {if $attributes|count > 0}
                <tr data-userId="{$id}">
                    <td colspan="{$colCount}" class="{$rowCss} customAttributes" userId="{$id}">
                        {assign var=changeAttributeAction value=ManageUsersActions::ChangeAttribute}
                        {assign var=attributeUrl value="`$smarty.server.SCRIPT_NAME`?action=`$changeAttributeAction`"}
                        {foreach from=$AttributeList item=attribute}
                            {include file='Admin/InlineAttributeEdit.tpl' url=$attributeUrl id=$id attribute=$attribute value=$user->GetAttributeValue($attribute->Id())}
                        {/foreach}
                    </td>
                </tr>
            {/if}
        {/foreach}
        </tbody>
        <tfoot>
        <tr>
            <td colspan="{$colCount-1}"></td>
            <td class="action-delete">
                <a href="#" id="delete-selected" class="no-show" title="{translate key=Delete}">
                    <span class="no-show">{translate key=Delete}</span>
                    <span class="fa fa-trash icon remove"></span>
                </a>
            </td>
        </tr>
        </tfoot>
    </table>

    {pagination pageInfo=$PageInfo}

    <div id="addUserDialog" class="modal modal-fixed-header modal-fixed-footer" tabindex="-1" role="dialog"
         aria-labelledby="addUserModalLabel"
         aria-hidden="true">
        <form id="addUserForm" class="form" role="form" method="post"
              ajaxAction="{ManageUsersActions::AddUser}">
            <div class="modal-header">
                <h4 class="modal-title left" id="addUserModalLabel">{translate key=AddUser}</h4>
                <a href="#" class="modal-close right black-text"><i class="fa fa-remove"></i></a>
            </div>
            <div class="modal-content">
                <div id="addUserResults" class="validationSummary alert alert-danger no-show">
                    <ul>
                        {async_validator id="addUserEmailformat" key="ValidEmailRequired"}
                        {async_validator id="addUserUniqueemail" key="UniqueEmailRequired"}
                        {async_validator id="addUserUsername" key="UniqueUsernameRequired"}
                        {async_validator id="addAttributeValidator" key=""}
                    </ul>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group has-feedback">
                        <label for="addUsername">{translate key="Username"}</label>
                        <input type="text" {formname key="USERNAME"} class="required form-control" required
                               id="addUsername"/>
                        <i class="glyphicon glyphicon-asterisk form-control-feedback"
                           data-bv-icon-for="addUsername"></i>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group has-feedback">
                        <label for="addEmail">{translate key="Email"}</label>
                        <input type="text" {formname key="EMAIL"} class="required form-control" required
                               id="addEmail"/>
                        <i class="glyphicon glyphicon-asterisk form-control-feedback"
                           data-bv-icon-for="addEmail"></i>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group has-feedback">
                        <label for="addFname">{translate key="FirstName"}</label>
                        <input type="text" {formname key="FIRST_NAME"} class="required form-control"
                               required
                               id="addFname"/>
                        <i class="glyphicon glyphicon-asterisk form-control-feedback"
                           data-bv-icon-for="addFname"></i>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group has-feedback">
                        <label for="addLname">{translate key="LastName"}</label>
                        <input type="text" {formname key="LAST_NAME"} class="required form-control" required
                               id="addLname"/>
                        <i class="glyphicon glyphicon-asterisk form-control-feedback"
                           data-bv-icon-for="addLname"></i>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group has-feedback">
                        <label for="addPassword">{translate key="Password"}</label>
                        <input type="text" {formname key="PASSWORD"} class="required form-control" required
                               id="addPassword"/>
                        <i class="glyphicon glyphicon-asterisk form-control-feedback"
                           data-bv-icon-for="addPassword"></i>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group has-feedback">
                        <label for="addTimezone">{translate key="Timezone"}</label>
                        <select id="addTimezone" {formname key='TIMEZONE'} class="form-control">
                            {html_options values=$Timezones output=$Timezones selected=$Timezone}
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="addPhone">{translate key="Phone"}</label>
                        <input type="text" {formname key="PHONE"} class="form-control" id="addPhone"/>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="addOrganization">{translate key="Organization"}</label>
                        <input type="text" {formname key="ORGANIZATION"} class="form-control"
                               id="addOrganization"/>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="addPosition">{translate key="Position"}</label>
                        <input type="text" {formname key="POSITION"} class="form-control" id="addPosition"/>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group has-feedback">
                        <label for="addGroup">{translate key="Group"}</label>
                        <select id="addGroup" {formname key='GROUP_ID'} class="form-control">
                            <option value="">{translate key=None}</option>
                            {object_html_options options=$Groups label=Name key=Id}
                        </select>
                    </div>
                </div>
                {if $AttributeList|count > 0}
                    <div class="col-xs-12 col-sm-6">
                        {control type="AttributeControl" attribute=$AttributeList[0]}
                    </div>
                {else}
                    <div class="col-sm-12 col-md-6">&nbsp;</div>
                {/if}

                {if $AttributeList|count > 1}
                    {for $i=1 to $AttributeList|count-1}
                        {*{if $i%2==1}*}
                        {*<div class="row">*}
                        {*{/if}*}
                        <div class="col-xs-12 col-sm-6">
                            {control type="AttributeControl" attribute=$AttributeList[$i]}
                        </div>
                        {*{if $i%2==0 || $i==$AttributeList|count-1}*}
                        {*</div>*}
                        {*{/if}*}
                    {/for}
                {/if}
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer"><label for="sendAddEmail">
                    <input type="checkbox" id="sendAddEmail"
                           checked="checked" {formname key=SEND_AS_EMAIL} />
                    <span>{translate key=NotifyUser}</span>
                </label>
                {cancel_button}
                {add_button}
                {indicator}
            </div>

        </form>
    </div>

    <div id="importUsersDialog" class="modal modal-fixed-header modal-fixed-footer" tabindex="-1" role="dialog"
         aria-labelledby="importUsersModalLabel"
         aria-hidden="true">
        <form id="importUsersForm" class="form" role="form" method="post" enctype="multipart/form-data"
              ajaxAction="{ManageUsersActions::ImportUsers}">
            <div class="modal-header">
                <h4 class="modal-title left" id="importUsersModalLabel">{translate key=Import}</h4>
                <a href="#" class="modal-close right black-text"><i class="fa fa-remove"></i></a>
            </div>
            <div class="modal-content">
                <div id="importUserResults" class="validationSummary alert alert-danger no-show">
                    <ul>
                        {async_validator id="fileExtensionValidator" key=""}
                    </ul>
                </div>
                <div class="card error no-show">
                    <div class="card-content" id="importErrors"></div>
                </div>
                <div id="importResult" class="card success no-show">
                    <div class="card-content">
                        <span>{translate key=RowsImported}</span>

                        <div id="importCount" class="inline bold">0</div>
                        <span>{translate key=RowsSkipped}</span>

                        <div id="importSkipped" class="inline bold">0</div>
                        <a class="" href="{$smarty.server.SCRIPT_NAME}">{translate key=Done}</a>
                    </div>
                </div>
                <div class="margin-bottom-25">
                    <div class="file-field input-field">
                        <div class="btn">
                            <span class="fa fa-file"></span>
                            <input type="file" {formname key=USER_IMPORT_FILE} id="userImportFile" accept=".csv"/>
                            <label for="userImportFile" class="no-show">User Import File</label>
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text" id="userImportFilePath">
                            <label for="userImportFilePath" class="no-show">User Import File</label>
                        </div>
                    </div>
                    <label for="updateOnImport">
                        <input type="checkbox" id="updateOnImport" {formname key=UPDATE_ON_IMPORT}/>
                        <span>{translate key=UpdateUsersOnImport}</span></label>
                </div>
                <div id="importInstructions" class="card info">
                    <div class="card-content">
                        <div class="note">{translate key=UserImportInstructions}</div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="left">
                    <a href="{$smarty.server.SCRIPT_NAME}?dr=template"
                       download="{$smarty.server.SCRIPT_NAME}?dr=template"
                       target="_blank" class="btn btn-white waves-effect waves-light">{translate key=GetTemplate} <span
                                class="fa fa-download"></span></a>
                </div>
                <div class="right">
                    {cancel_button}
                    {add_button key=Import}
                    {indicator}
                </div>
                <div class="clearfix"></div>
            </div>

        </form>
    </div>

    <input type="hidden" id="activeId"/>

    <div id="permissionsDialog" class="modal modal-fixed-header modal-fixed-footer" tabindex="-1" role="dialog"
         aria-labelledby="permissionsModalLabel"
         aria-hidden="true">
        <form id="permissionsForm" method="post" ajaxAction="{ManageUsersActions::Permissions}">
            <div class="modal-header">
                <h4 class="modal-title left" id="permissionsModalLabel">{translate key=Permissions}</h4>
                <a href="#" class="modal-close right black-text"><i class="fa fa-remove"></i></a>
            </div>
            <div class="modal-content">
                <div class="card warning">
                    <div class="card-content">{translate key=UserPermissionInfo}</div>
                </div>

                <a href="#" id="checkNoResources">{translate key=None}</a> |
                <a href="#" id="checkAllResourcesFull">{translate key=FullAccess}</a> |
                <a href="#" id="checkAllResourcesView">{translate key=ViewOnly}</a>

                {foreach from=$resources item=resource}
                    {cycle values='row0,row1' assign=rowCss}
                    {assign var=rid value=$resource->GetResourceId()}
                    <div class="{$rowCss} permissionRow">
                        <span class="">{$resource->GetName()}</span>
                        <div class="input-field">
                            <label for="permission_{$rid}" class="no-show">{translate key=Permissions}</label>
                            <select class="input-sm resourceId"
                                    style="width:auto;" {formname key=RESOURCE_ID multi=true}
                                    id="permission_{$rid}">
                                <option value="{$rid}_none" class="none">{translate key=None}</option>
                                <option value="{$rid}_0" class="full">{translate key=FullAccess}</option>
                                <option value="{$rid}_1" class="view">{translate key=ViewOnly}</option>
                            </select>
                        </div>
                    </div>
                {/foreach}
            </div>
            <div class="modal-footer">
                {cancel_button}
                {update_button}
                {indicator}
            </div>
        </form>
    </div>

    <div id="passwordDialog" class="modal modal-fixed-header modal-fixed-footer" tabindex="-1" role="dialog"
         aria-labelledby="passwordModalLabel"
         aria-hidden="true">
        <form id="passwordForm" method="post" ajaxAction="{ManageUsersActions::Password}">
            <div class="modal-header">
                <h4 class="modal-title left" id="passwordModalLabel">{translate key=Password}</h4>
                <a href="#" class="modal-close right black-text"><i class="fa fa-remove"></i></a>
            </div>
            <div class="modal-content">
                <div class="input-field">
                    <label for="password" class="active">{translate key=Password}</label>
                    {textbox type="password" name="PASSWORD" class="required" value="" id="updatePassword" autofocus="autofocus"}
                </div>
            </div>
            <div class="modal-footer">
                {cancel_button}
                {update_button}
                {indicator}
            </div>
        </form>
    </div>

    <div id="invitationDialog" class="modal modal-fixed-header modal-fixed-footer" tabindex="-1" role="dialog"
         aria-labelledby="invitationModalLabel"
         aria-hidden="true">
        <form id="invitationForm" method="post" ajaxAction="{ManageUsersActions::InviteUsers}">
            <div class="modal-header">
                <h4 class="modal-title left" id="invitationModalLabel">{translate key=InviteUsers}</h4>
                <a href="#" class="modal-close right black-text"><i class="fa fa-remove"></i></a>
            </div>
            <div class="modal-content">
                <div class="input-field">
                    <label for="inviteEmails">{translate key=InviteUsersLabel}</label>
                    <textarea class="materialize-textarea" id="inviteEmails" rows="5"
                              autofocus="autofocus" {formname key=INVITED_EMAILS}></textarea>
                </div>
            </div>
            <div class="modal-footer">
                {cancel_button}
                <button type="button" class="btn btn-primary save"><span
                            class="fa fa-send"></span> {translate key=InviteUsers}</button>
                {indicator}
            </div>

        </form>
    </div>

    <div id="userDialog" class="modal modal-fixed-header modal-fixed-footer" tabindex="-1" role="dialog"
         aria-labelledby="userModalLabel"
         aria-hidden="true">
        <form id="userForm" method="post" ajaxAction="{ManageUsersActions::UpdateUser}">
            <div class="modal-header">
                <h4 class="modal-title left" id="userModalLabel">{translate key=Edit}</h4>
                <a href="#" class="modal-close right black-text"><i class="fa fa-remove"></i></a>
            </div>

            <div class="modal-content">
                <div id="updateUserResults" class="card error no-show">
                    <div class="card-content">
                        <ul>
                            {async_validator id="emailformat" key="ValidEmailRequired"}
                            {async_validator id="uniqueemail" key="UniqueEmailRequired"}
                            {async_validator id="uniqueusername" key="UniqueUsernameRequired"}
                        </ul>
                    </div>
                </div>
                <div class="col s12 m6">

                    <div class="input-field">
                        <label for="username">{translate key="Username"}</label>
                        <input type="text" {formname key="USERNAME"} class="required" required
                               id="username" autofocus/>
                    </div>
                </div>

                <div class="col s12 m6">
                    <div class="input-field">
                        <label for="email">{translate key="Email"}</label>
                        <input type="text" {formname key="EMAIL"} class="required" required
                               id="email"/>
                    </div>
                </div>

                <div class="col s12 m6">
                    <div class="input-field">
                        <label for="fname">{translate key="FirstName"}</label>
                        <input type="text" {formname key="FIRST_NAME"} class="required" required
                               id="fname"/>
                    </div>
                </div>

                <div class="col s12 m6">
                    <div class="input-field">
                        <label for="lname">{translate key="LastName"}</label>
                        <input type="text" {formname key="LAST_NAME"} class="required" required
                               id="lname"/>
                    </div>
                </div>

                <div class="col s12 m6">
                    <div class="input-field">
                        <label for="timezone" class="active">{translate key="Timezone"}</label>
                        <select {formname key='TIMEZONE'} id='timezone' class="">
                            {html_options values=$Timezones output=$Timezones}
                        </select>
                    </div>
                </div>

                <div class="col s12 m6">
                    <div class="input-field">
                        <label for="phone">{translate key="Phone"}</label>
                        <input type="text" {formname key="PHONE"} class="form-control" id="phone"/>
                    </div>
                </div>

                <div class="col s12 m6">
                    <div class="input-field">
                        <label for="organization">{translate key="Organization"}</label>
                        <input type="text" {formname key="ORGANIZATION"} class="form-control"
                               id="organization"/>
                    </div>
                </div>

                <div class="col s12 m6">
                    <div class="input-field">
                        <label for="position">{translate key="Position"}</label>
                        <input type="text" {formname key="POSITION"} class="form-control" id="position"/>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                {cancel_button}
                {update_button}
                {indicator}
            </div>
        </form>
    </div>

    <div id="deleteDialog" class="modal modal-fixed-header modal-fixed-footer" tabindex="-1" role="dialog"
         aria-labelledby="deleteModalLabel"
         aria-hidden="true">
        <form id="deleteUserForm" method="post" ajaxAction="{ManageUsersActions::DeleteUser}">
            <div class="modal-header">
                <h4 class="modal-title left" id="deleteModalLabel">{translate key=Delete}</h4>
                <a href="#" class="modal-close right black-text"><i class="fa fa-remove"></i></a>
            </div>
            <div class="modal-content">
                <div class="card warning">
                    <div class="card-content">
                        <div>{translate key=DeleteWarning}</div>

                        <div>{translate key=DeleteMultipleUserWarning}</div>
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

    <div id="deleteMultipleDialog" class="modal modal-fixed-header modal-fixed-footer" tabindex="-1" role="dialog"
         aria-labelledby="deleteMultipleModalLabel"
         aria-hidden="true">
        <form id="deleteMultipleUserForm" method="post" ajaxAction="{ManageUsersActions::DeleteMultipleUsers}">
            <div class="modal-header">
                <h4 class="modal-title left" id="deleteMultipleModalLabel">{translate key=Delete}</h4>
                <a href="#" class="modal-close right black-text"><i class="fa fa-remove"></i></a>
            </div>
            <div class="modal-content">
                <div class="card warning">
                    <div class="card-content">
                        <div>{translate key=DeleteWarning}</div>

                        <div>{translate key=DeleteMultipleUserWarning}</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {cancel_button}
                {delete_button}
                {indicator}
            </div>
            <div id="deleteMultiplePlaceHolder" class="no-show"></div>
        </form>
    </div>

    <div id="groupsDialog" class="modal modal-fixed-header modal-fixed-footer" tabindex="-1" role="dialog"
         aria-labelledby="groupsModalLabel"
         aria-hidden="true">
        <div class="modal-header">
            <h4 class="modal-title left" id="groupsModalLabel">{translate key=Groups}</h4>
            <a href="#" class="modal-close right black-text"><i class="fa fa-remove"></i></a>
        </div>

        <div class="modal-content">
            <div id="groupList" class="hidden">
                {foreach from=$Groups item=group}
                    <div class="group-item" groupId="{$group->Id}">
                        <a href="#"><span class="no-show">{$group->Name}</span>&nbsp;</a>
                        <span>{$group->Name}</span>
                    </div>
                {/foreach}
            </div>

            <div class="title">{translate key=GroupMembership} <span class="badge" id="groupCount">0</span></div>
            <div id="addedGroups">
            </div>

            <div class="title">{translate key=AvailableGroups}</div>
            <div id="removedGroups">
            </div>

            <form id="addGroupForm" method="post" ajaxAction="addUser">
                <input type="hidden" id="addGroupId" {formname key=GROUP_ID} />
                <input type="hidden" id="addGroupUserId" {formname key=USER_ID} />
            </form>

            <form id="removeGroupForm" method="post" ajaxAction="removeUser">
                <input type="hidden" id="removeGroupId" {formname key=GROUP_ID} />
                <input type="hidden" id="removeGroupUserId" {formname key=USER_ID} />
            </form>
        </div>
    </div>

    <div id="colorDialog" class="modal modal-fixed-header modal-fixed-footer" tabindex="-1" role="dialog"
         aria-labelledby="colorModalLabel"
         aria-hidden="true">
        <form id="colorForm" method="post" ajaxAction="{ManageUsersActions::ChangeColor}">
            <div class="modal-header">
                <h4 class="modal-title left" id="colorModalLabel">{translate key=Color}</h4>
                <a href="#" class="modal-close right black-text"><i class="fa fa-remove"></i></a>
            </div>
            <div class="modal-content">
                <div class="input-group">
                    <span class="input-group-addon">#</span>
                    <label for="reservationColor" class="no-show">Reservation Color</label>
                    <input type="text" {formname key=RESERVATION_COLOR} id="reservationColor" maxlength="6"
                           class="form-control" placeholder="FFFFFF">
                </div>
            </div>
            <div class="modal-footer">
                {cancel_button}
                {update_button}
                {indicator}
            </div>
        </form>
    </div>

    {csrf_token}
    {include file="javascript-includes.tpl" InlineEdit=true}
    {jsfile src="ajax-helpers.js"}
    {jsfile src="autocomplete.js"}
    {jsfile src="admin/user.js"}
    {jsfile src="js/jquery.form-3.09.min.js"}
    {jsfile src="js/colorpicker.js"}

    <script type="text/javascript">
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
                url: updateUrl + '{ManageUsersActions::ChangeAttribute}', emptytext: '-'
            });

            $('.changeCredits').editable({
                url: updateUrl + '{ManageUsersActions::ChangeCredits}', emptytext: '-'
            });
        }

        $(document).ready(function () {

            $('div.modal').modal();

            $('.dropdown-trigger').dropdown({
                constrainWidth: false,
                coverTrigger: false
            });

            var actions = {
                activate: '{ManageUsersActions::Activate}', deactivate: '{ManageUsersActions::Deactivate}'
            };

            var userOptions = {
                userAutocompleteUrl: "../ajax/autocomplete.php?type={AutoCompleteType::MyUsers}",
                orgAutoCompleteUrl: "../ajax/autocomplete.php?type={AutoCompleteType::Organization}",
                groupsUrl: '{$smarty.server.SCRIPT_NAME}',
                groupManagementUrl: '{$ManageGroupsUrl}',
                permissionsUrl: '{$smarty.server.SCRIPT_NAME}',
                submitUrl: '{$smarty.server.SCRIPT_NAME}',
                saveRedirect: '{$smarty.server.SCRIPT_NAME}',
                selectUserUrl: '{$smarty.server.SCRIPT_NAME}?uid=',
                filterUrl: '{$smarty.server.SCRIPT_NAME}?{QueryStringKeys::ACCOUNT_STATUS}=',
                actions: actions,
                manageReservationsUrl: '{$ManageReservationsUrl}'
            };

            var userManagement = new UserManagement(userOptions);
            userManagement.init();

            {foreach from=$users item=user}
            var user = {
                id: {$user->Id},
                first: '{$user->First|escape:"javascript"}',
                last: '{$user->Last|escape:"javascript"}',
                isActive: '{$user->IsActive()}',
                username: '{$user->Username|escape:"javascript"}',
                email: '{$user->Email|escape:"javascript"}',
                timezone: '{$user->Timezone}',
                phone: '{$user->Phone|escape:"javascript"}',
                organization: '{$user->Organization|escape:"javascript"}',
                position: '{$user->Position|escape:"javascript"}',
                reservationColor: '{$user->ReservationColor|escape:"javascript"}'
            };
            userManagement.addUser(user);
            {/foreach}

            $('#reservationColor').ColorPicker({
                onSubmit: function (hsb, hex, rgb, el) {
                    $(el).val(hex);
                    $(el).ColorPickerHide();
                }, onBeforeShow: function () {
                    $(this).ColorPickerSetColor(this.value);
                }
            });


            setUpEditables();
        });
    </script>
</div>
{include file='globalfooter.tpl'}