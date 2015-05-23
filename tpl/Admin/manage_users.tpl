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
{include file='globalheader.tpl' cssFiles='scripts/css/colorpicker.css'}

<div id="page-manage-users">

	<h1>{translate key=ManageUsers}</h1>

	<form id="filterForm" class="" role="form">
		<div class="form-group col-xs-4">
			<label for="userSearch">{translate key=FindUser}
				| {html_link href=$smarty.server.SCRIPT_NAME key=AllUsers}</label>
			<input type="text" id="userSearch"
				   class="form-control"/>
		</div>
		<div class="form-group col-xs-2">
			<label for="filterStatusId">{translate key=Status}</label>
			<select id="filterStatusId" class="form-control">
				{html_options selected=$FilterStatusId options=$statusDescriptions}
			</select>
		</div>
		<div class="col-xs-6"></div>
	</form>

	<table class="table" id="userList">
		<thead>
		<tr>
			<th>{translate key='Name'}</th>
			<th>{translate key='Username'}</th>
			<th>{translate key='Email'}</th>
			<th>{translate key='Phone'}</th>
			<th>{translate key='Organization'}</th>
			<th>{translate key='Position'}</th>
			<th>{translate key='Created'}</th>
			<th>{translate key='LastLogin'}</th>
			<th class="action">{translate key='Status'}</th>
			{if $PerUserColors}
				<th class="action">{translate key='Color'}</th>
			{/if}
			<th>{translate key='Actions'}</th>
		</tr>
		</thead>
		<tbody>
		{foreach from=$users item=user}
			{cycle values='row0,row1' assign=rowCss}
			{assign var=id value=$user->Id}
			<tr class="{$rowCss} editable" data-userId="{$id}">
				<td>{fullname first=$user->First last=$user->Last ignorePrivacy="true"}</td>
				<td>{$user->Username}</td>
				<td><a href="mailto:{$user->Email}">{$user->Email}</a></td>
				<td>{$user->Phone}</td>
				<td>{$user->Organization}</td>
				<td>{$user->Position}</td>
				<td>{format_date date=$user->DateCreated key=short_datetime}</td>
				<td>{format_date date=$user->LastLogin key=short_datetime}</td>
				<td class="action"><a href="#" class="update changeStatus">{$statusDescriptions[$user->StatusId]}</a>
				</td>
				{if $PerUserColors}
					<td class="action">
						<a href="#" class="update changeColor">{translate key='Edit'}</a>
						{if !empty($user->ReservationColor)}
							<div class="user-color update changeColor"
								 style="background-color:#{$user->ReservationColor}">&nbsp;</div>
						{/if}
					</td>
				{/if}

				<td>
					<div class="btn-group">
						<button type="button" class="btn btn-sm btn-default update edit"><span
									class="fa fa-pencil-square-o"></button>
						<button type="button" class="btn btn-sm btn-default dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span>
							<span class="sr-only">{translate key=More}</span>
						</button>
						<ul class="dropdown-menu dropdown-menu-right" role="menu" aria-labelledby="moreActions{$id}">
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

						</ul>
					</div>
					|
					<a href="#" class="update delete"><span class="fa fa-trash icon remove"></span></a>
				</td>
			</tr>
			{assign var=attributes value=$AttributeList}
			{if $attributes|count > 0}
				<tr>
					<td class="id"><input type="hidden" class="id" value="{$id}"/></td>
					<td colspan="15" class="{$rowCss} customAttributes" userId="{$id}">
						<form method="post" class="attributesForm" ajaxAction="{ManageUsersActions::ChangeAttributes}">
							<h3>{translate key=AdditionalAttributes}
								<a href="#" class="update changeAttributes">{translate key=Edit}</a>
							</h3>

							<div class="validationSummary">
								<ul>
								</ul>
								<div class="clear">&nbsp;</div>
							</div>

							<div>
								<ul>
									{foreach from=$attributes item=attribute}
										{assign var="attributeValue" value=$user->GetAttributeValue($attribute->Id())}
										<li class="customAttribute" attributeId="{$attribute->Id()}">
											<div class="attribute-readonly">{control type="AttributeControl" attribute=$attribute value=$attributeValue readonly=true}</div>
											<div class="attribute-readwrite hidden">{control type="AttributeControl" attribute=$attribute value=$attributeValue}
										</li>
									{/foreach}
								</ul>
							</div>

							<div class="attribute-readwrite hidden clear" style="height:auto;">
								<button type="button"
										class="button save">{html_image src="tick-circle.png"} {translate key='Update'}</button>
								<button type="button"
										class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
							</div>
						</form>
					</td>
				</tr>
			{/if}
		{/foreach}
		</tbody>
	</table>

	{pagination pageInfo=$PageInfo}

	<div class="admin" style="margin-top:30px;">
		<div class="title">
			{translate key=AddUser}
		</div>
		<div>
			<ul>
				{async_validator id="addUserEmailformat" key="ValidEmailRequired"}
				{async_validator id="addUserUniqueemail" key="UniqueEmailRequired"}
				{async_validator id="addUserUsername" key="UniqueUsernameRequired"}
				{async_validator id="addAttributeValidator" key=""}
			</ul>
			<form id="addUserForm" method="post" ajaxAction="{ManageUsersActions::AddUser}">
				<div style="display: table-row">
					<div style="display: table-cell;">
						<ul>
							<li>{translate key="Username"}</li>
							<li>{textbox name="USERNAME" class="required textbox" size="40" id="addUsername"}</li>
						</ul>
					</div>
					<div style="display: table-cell;">
						<ul>
							<li>{translate key="Email"}</li>
							<li>{textbox name="EMAIL" class="required textbox" size="40" id="addEmail"}</li>
						</ul>
					</div>
					<div style="display: table-cell;">
						<ul>
							<li>{translate key="FirstName"}</li>
							<li>{textbox name="FIRST_NAME" class="required textbox" size="40" id="addFname"}</li>
						</ul>
					</div>
					<div style="display: table-cell;">
						<ul>
							<li>{translate key="LastName"}</li>
							<li>{textbox name="LAST_NAME" class="required textbox" size="40" id="addLname"}</li>
						</ul>
					</div>
				</div>
				<div style="display: table-row">
					<div style="display: table-cell;">
						<ul>
							<li>{translate key="Timezone"}</li>
							<li>
								<select {formname key='TIMEZONE'} class="textbox">
									{html_options values=$Timezones output=$Timezones selected=$Timezone}
								</select>
							</li>
						</ul>
					</div>
					<div style="display: table-cell;">
						<ul>
							<li>{translate key="Password"}</li>
							<li>{textbox name="PASSWORD" class="required textbox" size="40" id="addPassword"}</li>
						</ul>
					</div>
					<div style="display: table-cell;">
						<ul>
							<li>{translate key="Group"}</li>
							<li>
								<select {formname key='GROUP_ID'} class="textbox">
									<option value="">{translate key=None}</option>
									{object_html_options options=$Groups label=Name key=Id}
								</select>
							</li>
						</ul>
					</div>
				</div>

				<div class="customAttributes">
					<ul>
						{assign var=attributes value=$AttributeList}
						{foreach from=$attributes item=attribute}
							<li class="customAttribute">
								{control type="AttributeControl" attribute=$attribute algin=vertical}
							</li>
						{/foreach}
					</ul>
					<div style="clear:both;"></div>
				</div>

				<div class="admin-update-buttons">
					<button type="button"
							class="button save">{html_image src="disk-black.png"} {translate key='AddUser'}</button>
					<button type="button"
							class="button clearform">{html_image src="slash.png"} {translate key='Cancel'}</button>
				</div>
			</form>
		</div>
	</div>

	<input type="hidden" id="activeId"/>

		<div id="permissionsDialog" class="modal" tabindex="-1" role="dialog" aria-labelledby="permissionsModalLabel"
			 aria-hidden="true">
			<form id="permissionsForm" method="post" ajaxAction="{ManageUsersActions::Permissions}">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="permissionsModalLabel">{translate key=Permissions}</h4>
						</div>
						<div class="modal-body">
							<div class="alert alert-warning">{translate key=UserPermissionInfo}</div>
							{foreach from=$resources item=resource}
								{assign var=resourceId value=$resource->GetResourceId()}
								<div class="checkbox">
									<input id="resource{$resourceId}" {formname key=RESOURCE_ID  multi=true} class="resourceId" type="checkbox" value="{$resource->GetResourceId()}">
									<label for="resource{$resourceId}"">{$resource->GetName()}</label>
								</div>
							{/foreach}
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">{translate key='Cancel'}</button>
							<button type="button" class="btn btn-success save"><span class="glyphicon glyphicon-ok-circle"></span>
								{translate key='Update'}</button>
							{indicator}
						</div>
					</div>
				</div>
			</form>
		</div>

		<div id="passwordDialog" class="dialog" style="display:none;" title="{translate key=Password}">
			<form id="passwordForm" method="post" ajaxAction="{ManageUsersActions::Password}">
				{translate key=Password}<br/>
				{textbox type="password" name="PASSWORD" class="required textbox" value=""}
				<div class="admin-update-buttons">
					<button type="button"
							class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
					<button type="button"
							class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
				</div>
			</form>
		</div>

		<div id="userDialog" class="dialog" title="{translate key=Update}">
			<form id="userForm" method="post" ajaxAction="{ManageUsersActions::UpdateUser}">
				<ul>
					{async_validator id="emailformat" key="ValidEmailRequired"}
					{async_validator id="uniqueemail" key="UniqueEmailRequired"}
					{async_validator id="uniqueusername" key="UniqueUsernameRequired"}
				</ul>

				<ul>
					<li>{translate key="Username"}</li>
					<li>{textbox name="USERNAME" class="required textbox" size="40" id="username"}</li>
					<li>{translate key="Email"}</li>
					<li>{textbox name="EMAIL" class="required textbox" size="40" id="email"}</li>

					<li>{translate key="FirstName"}</li>
					<li>{textbox name="FIRST_NAME" class="required textbox" size="40" id="fname"}</li>
					<li>{translate key="LastName"}</li>
					<li>{textbox name="LAST_NAME" class="required textbox" size="40" id="lname"}</li>

					<li>{translate key="Timezone"}</li>
					<li>
						<select {formname key='TIMEZONE'} id='timezone' class="textbox">
							{html_options values=$Timezones output=$Timezones}
						</select>
					</li>

					<li>{translate key="Phone"}</li>
					<li>{textbox name="PHONE" class="textbox" size="40" id="phone"}</li>
					<li>{translate key="Organization"}</li>
					<li>{textbox name="ORGANIZATION" class="textbox" size="40" id="organization"}</li>
					<li>{translate key="Position"}</li>
					<li>{textbox name="POSITION" class="textbox" size="40" id="position"}</li>
				</ul>
				<div class="admin-update-buttons">
					<button type="button"
							class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
					<button type="button"
							class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
				</div>
			</form>
		</div>

		<div id="deleteDialog" class="dialog" title="{translate key=Delete}">
			<form id="deleteUserForm" method="post" ajaxAction="{ManageUsersActions::DeleteUser}">
				<div class="error" style="margin-bottom: 25px;">
					<h3>{translate key=DeleteWarning}</h3>

					<div>{translate key=DeleteUserWarning}</div>
				</div>
				<div class="admin-update-buttons">
					<button type="button"
							class="button save">{html_image src="cross-button.png"} {translate key='Delete'}</button>
					<button type="button"
							class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
				</div>
			</form>
		</div>

		<div id="groupsDialog" class="dialog" title="{translate key=Groups}">
			<div id="allUsers" style="display:none;" class="dialog" title="{translate key=AllUsers}"></div>

			<div id="groupList" class="hidden">
				{foreach from=$Groups item=group}
					<div class="group-item" groupId="{$group->Id}"><a href="#">&nbsp;</a> <span>{$group->Name}</span>
					</div>
				{/foreach}
			</div>

			<div id="addedGroups">
			</div>

			<div id="removedGroups">
			</div>
		</div>

		<div id="colorDialog" class="dialog" title="{translate key=Color}">
			<form id="colorForm" method="post" ajaxAction="{ManageUsersActions::ChangeColor}">
				#{textbox name="RESERVATION_COLOR" class="textbox" id="reservationColor" maxlength=6}
				<div class="admin-update-buttons">
					<button type="button"
							class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
					<button type="button"
							class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
				</div>
			</form>
		</div>

		{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}

		{jsfile src="admin/edit.js"}
		{jsfile src="autocomplete.js"}
		{jsfile src="admin/user.js"}
		{jsfile src="js/jquery.form-3.09.min.js"}
		{jsfile src="js/colorpicker.js"}

		<script type="text/javascript">
			$(document).ready(function ()
			{
				var actions = {
					activate: '{ManageUsersActions::Activate}',
					deactivate: '{ManageUsersActions::Deactivate}'
				};

				var userOptions = {
					userAutocompleteUrl: "../ajax/autocomplete.php?type={AutoCompleteType::MyUsers}",
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
					first: '{$user->First|escape:"quotes"}',
					last: '{$user->Last|escape:"quotes"}',
					isActive: '{$user->IsActive()}',
					username: '{$user->Username|escape:"quotes"}',
					email: '{$user->Email|escape:"quotes"}',
					timezone: '{$user->Timezone}',
					phone: '{$user->Phone|escape:"quotes"}',
					organization: '{$user->Organization|escape:"quotes"}',
					position: '{$user->Position|escape:"quotes"}',
					reservationColor: '{$user->ReservationColor|escape:"quotes"}'
				};
				userManagement.addUser(user);
				{/foreach}

				$('#reservationColor').ColorPicker({
					onSubmit: function (hsb, hex, rgb, el)
					{
						$(el).val(hex);
						$(el).ColorPickerHide();
					},
					onBeforeShow: function ()
					{
						$(this).ColorPickerSetColor(this.value);
					}
				});

			});
		</script>
	</div>
{include file='globalfooter.tpl'}