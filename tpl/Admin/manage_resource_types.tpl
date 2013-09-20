{*
Copyright 2011-2013 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*}
{include file='globalheader.tpl' cssFiles='css/admin.css'}

<h1>{translate key='ManageResourceTypes'}</h1>

<div id="globalError" class="error" style="display:none"></div>
<div class="admin">
<div class="title">
	{translate key='AllResources'}
</div>
{foreach from=$Resources item=resource}
	{assign var=id value=$resource->GetResourceId()}
	<div class="resourceDetails" resourceId="{$id}">


		{assign var=attributes value=$AttributeList->GetAttributes($id)}
		{if $attributes|count > 0}
			<div class="customAttributes">
				<form method="post" class="attributesForm">
					<h3>{translate key=AdditionalAttributes} <a href="#"
																class="update changeAttributes">{translate key=Edit}</a>
					</h3>

					<div class="validationSummary">
						<ul>
						</ul>
						<div class="clear">&nbsp;</div>
					</div>
					<ul>
						{foreach from=$attributes item=attribute}
							<li class="customAttribute" attributeId="{$attribute->Id()}">
								<div class="attribute-readonly">{control type="AttributeControl" attribute=$attribute readonly=true}</div>
								<div class="attribute-readwrite hidden">{control type="AttributeControl" attribute=$attribute}
							</li>
						{/foreach}
					</ul>
					<div class="attribute-readwrite hidden clear">
						<button type="button"
								class="button save">{html_image src="tick-circle.png"} {translate key='Update'}</button>
						<button type="button"
								class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
					</div>
				</form>
			</div>
			{/if}
{/foreach}
</div>

	<div class="admin" style="margin-top:30px">
		<div class="title">
			{translate key='AddNewResourceType'}
		</div>
		<div>
			<div id="addResourceResults" class="error" style="display:none;"></div>
			<form id="addResourceForm" method="post">
				<table>
					<tr>
						<th>{translate key='Name'}</th>
						<th>{translate key='Description'}</th>
						<th>&nbsp;</th>
					</tr>
					<tr>
						<td><input type="text" class="textbox required" maxlength="85"
								   style="width:250px" {formname key=RESOURCE_TYPE_NAME} />
						</td>
						<td>
							<textarea class="textbox" {formname key=RESOURCE_TYPE_DESCRIPTION}></textarea>
						</td>
						<td>
							<button type="button"
									class="button save">{html_image src="plus-button.png"} {translate key='AddResource'}</button>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>


<input type="hidden" id="activeId" value=""/>

<div id="renameDialog" class="dialog" style="display:none;" title="{translate key=Rename}">
	<form id="renameForm" method="post">
		{translate key='Name'}: <input id="editName" type="text" class="textbox required" maxlength="85"
									   style="width:250px" {formname key=RESOURCE_NAME} />
		<br/><br/>
		<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Rename'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div id="descriptionDialog" class="dialog" style="display:none;" title="{translate key=Description}">
	<form id="descriptionForm" method="post">
		{translate key=Description}:<br/>
		<textarea id="editDescription" class="textbox"
				  style="width:460px;height:150px;" {formname key=RESOURCE_DESCRIPTION}></textarea>
		<br/><br/>
		<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div id="deleteDialog" class="dialog" style="display:none;" title="{translate key=Delete}">
	<form id="deleteForm" method="post">
		<div class="error" style="margin-bottom: 25px;">
			<h3>{translate key=DeleteWarning}</h3>
			<br/>{translate key=DeleteResourceWarning}:
			<ul>
				<li>{translate key=DeleteResourceWarningReservations}</li>
				<li>{translate key=DeleteResourceWarningPermissions}</li>
			</ul>
			<br/>
			{translate key=DeleteResourceWarningReassign}
		</div>

		<button type="button" class="button save">{html_image src="cross-button.png"} {translate key='Delete'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}
<script type="text/javascript" src="{$Path}scripts/js/jquery.watermark.min.js"></script>
<script type="text/javascript" src="{$Path}scripts/admin/edit.js"></script>
<script type="text/javascript" src="{$Path}scripts/admin/resource.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.form-3.09.min.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/ajaxfileupload.js"></script>

<script type="text/javascript">

	$(document).ready(function ()
	{
		var actions = {

		};

		var opts = {
			submitUrl: '{$smarty.server.SCRIPT_NAME}',
			saveRedirect: '{$smarty.server.SCRIPT_NAME}',
			actions: actions
		};


		{foreach from=$Resources item=resource}

		{/foreach}
	})

</script>

{include file='globalfooter.tpl'}