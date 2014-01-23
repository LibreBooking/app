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
{include file='globalheader.tpl' cssFiles='scripts/css/jquery.contextMenu.css,scripts/css/jqtree.css,css/admin.css'}

<h1>{translate key='ManageResourceGroups'}</h1>

<div id="globalError" class="error" style="display:none"></div>
<div class="admin">
	<div class="title">
		{translate key='ResourceGroups'}
		<div id="help-button" class="help" help-ref="help">&nbsp;</div>
	</div>

	<div id="manage-resource-groups-container">
		<div id="new-group">
			<form method="post" id="addGroupForm" ajaxAction="{ManageResourceGroupsActions::AddGroup}">
				<input type="text" name="{FormKeys::GROUP_NAME}" class="textbox new-group" size="30"/>
				<input type="hidden" name="{FormKeys::PARENT_ID}" />
				{html_image src="plus-circle.png" class="image-button" id="btnAddGroup"}
			</form>
		</div>
		<div id="group-tree"></div>
		<div id="resource-list">
			<h4>{translate key=Resources}</h4>
			<ul>
				{foreach from=$Resources item=resource}
					<li class="resource-draggable" resource-name="{$resource->GetName()|escape:javascript}"
						resource-id="{$resource->GetId()}">{$resource->GetName()}</li>
				{/foreach}
			</ul>
		</div>
		<div class="clear">&nbsp;</div>
	</div>
</div>

<div class="warning" id="resourceGroupWarning">
	{translate key=ResourceGroupWarning}
</div>

<input type="hidden" id="activeId" value=""/>

<div id="renameDialog" class="dialog" title="{translate key=Rename}">
	<form id="renameForm" method="post" ajaxAction="{ManageResourceGroupsActions::RenameGroup}">
		{translate key='Name'}: <input id="editName" type="text" class="textbox required triggerSubmit" maxlength="85"
									   style="width:250px" {formname key=GROUP_NAME} />
		<br/><br/>
		<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Rename'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div id="deleteDialog" class="dialog" title="{translate key=Delete}">
	<form id="deleteForm" method="post" ajaxAction="{ManageResourceGroupsActions::DeleteGroup}">
		<div class="error" style="margin-bottom: 25px;">
			<h3>{translate key=DeleteWarning}</h3>
		</div>

		<button type="button" class="button save">{html_image src="cross-button.png"} {translate key='Delete'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div id="addChildDialog" class="dialog" title="{translate key=AddNewGroup}">
	<form id="addChildForm" method="post" ajaxAction="{ManageResourceGroupsActions::AddGroup}">
	{translate key='Name'}: <input id="childName" type="text" class="textbox required new-group" maxlength="85"
								   style="width:250px" {formname key=GROUP_NAME} />
		<br/><br/>
		<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Add'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
		<input type="hidden" id="groupParentId" name="{FormKeys::PARENT_ID}" />
	</form>
</div>

<div id="help" class="dialog" title="{translate key=Help}">
	<ul>
		<li>{translate key=ResourceGroupHelp1}</li>
		<li>{translate key=ResourceGroupHelp2}</li>
		<li>{translate key=ResourceGroupHelp3}</li>
	</ul>
</div>

{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}
{jsfile src="js/jquery.watermark.min.js"}
{jsfile src="admin/edit.js"}
{jsfile src="admin/resource-groups.js"}
{jsfile src="js/jquery.form-3.09.min.js"}
{jsfile src="js/tree.jquery.js"}
{jsfile src="js/jquery.cookie.js"}
{jsfile src="js/jquery.contextMenu.js"}

<script type="text/javascript">

	$(document).ready(function ()
	{
		var actions = {
			addResource: '{ManageResourceGroupsActions::AddResource}',
			removeResource: '{ManageResourceGroupsActions::RemoveResource}',
			moveNode: '{ManageResourceGroupsActions::MoveNode}'
		};

		var groupOptions = {
			submitUrl: '{$smarty.server.SCRIPT_NAME}',
			actions: actions,
			newGroupText: '{translate key=AddNewGroup}',
			renameText: '{translate key=Rename}',
			addChildText: '{translate key=AddGroup}',
			deleteText: '{translate key=Delete}',
			exitText: '{translate key=Close}'
		};

		var groupManagement = new ResourceGroupManagement(groupOptions);
		groupManagement.init({$ResourceGroups});

		$('#help-button').click(function(e){
			$('#' + $(this).attr('help-ref')).dialog();
		});
	});

</script>

{include file='globalfooter.tpl'}