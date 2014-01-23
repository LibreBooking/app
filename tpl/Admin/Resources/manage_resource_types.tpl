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
{include file='globalheader.tpl' cssFiles='css/admin.css'}

<h1>{translate key='ManageResourceTypes'}</h1>

<div id="globalError" class="error" style="display:none"></div>

<table class="list" id="resourceTypes" style="min-width: 600px;">
	<tr>
		<th>{translate key='Name'}</th>
		<th>{translate key='Description'}</th>
		<th>{translate key='Actions'}</th>
	</tr>
	{foreach from=$ResourceTypes item=type}
		{cycle values='row0,row1' assign=rowCss}
		{assign var=id value=$type->Id()}
		<tr class="{$rowCss}">
			<td>{$type->Name()}</td>
			<td>{$type->Description()|nl2br}</td>
			<td align="center" style="width:100px;">
				<a href="#" class="update edit">{translate key='Edit'}</a> |
				<a href="#" class="update delete">{translate key='Delete'}</a>
				<input type="hidden" class="id" value="{$id}" />
			</td>
		</tr>
		{assign var=attributes value=$AttributeList->GetAttributes($id)}
		{if $attributes|count > 0}
			<tr>
				<td colspan="4" class="{$rowCss} customAttributes" resourceTypeId="{$id}">
					<form method="post" class="attributesForm" ajaxAction="{ManageResourceTypesActions::ChangeAttributes}">
						<h3>{translate key=AdditionalAttributes} <a href="#"
																	class="changeAttributes" resourceTypeId="{$id}">{translate key=Edit}</a>
						</h3>

						<div class="validationSummary">
							<ul>
							</ul>
							<div class="clear">&nbsp;</div>
						</div>

						<div>
							<ul>
								{foreach from=$attributes item=attribute}
									<li class="customAttribute" attributeId="{$attribute->Id()}">
										<div class="attribute-readonly">{control type="AttributeControl" attribute=$attribute readonly=true}</div>
										<div class="attribute-readwrite hidden">{control type="AttributeControl" attribute=$attribute}
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
</table>

<div class="admin" style="margin-top:30px">
	<div class="title">
		{translate key='AddResourceType'}
	</div>
	<div>
		<div id="addResults" class="error" style="display:none;"></div>
		<form id="addForm" method="post" ajaxAction="{ManageResourceTypesActions::Add}">
			<table>
				<tr>
					<th>{translate key='Name'}</th>
					<th>{translate key='Description'}</th>
					<th>&nbsp;</th>
				</tr>
				<tr>
					<td style="vertical-align: top;">
						<input type="text" class="textbox required" maxlength="85" style="width:250px" {formname key=RESOURCE_TYPE_NAME} />
					</td>
					<td>
						<textarea class="textbox" style="width:400px" {formname key=RESOURCE_TYPE_DESCRIPTION}></textarea>
					</td>
				</tr>
			</table>

			<button type="button" class="button save">{html_image src="plus-button.png"} {translate key='AddResourceType'}</button>
		</form>
	</div>
</div>


<input type="hidden" id="activeId" value=""/>

<div id="editDialog" class="dialog" style="display:none;" title="{translate key=Update}">
	<form id="editForm" method="post" ajaxAction="{ManageResourceTypesActions::Update}">
		{translate key='Name'}: <input id="editName" type="text" class="textbox required" maxlength="85"
									   style="width:250px" {formname key=RESOURCE_TYPE_NAME} />
		<br/><br/>

		{translate key=Description}:<br/>
		<textarea id="editDescription" class="textbox" style="width:460px;height:150px;" {formname key=RESOURCE_TYPE_DESCRIPTION}></textarea>
		<br/><br/>

		<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div id="deleteDialog" class="dialog" style="display:none;" title="{translate key=Delete}">
	<form id="deleteForm" method="post" ajaxAction="{ManageResourceTypesActions::Delete}">
		<div class="error" style="margin-bottom: 25px;">
			<h3>{translate key=DeleteWarning}</h3>
		</div>

		<button type="button"
				class="button save">{html_image src="cross-button.png"} {translate key='Delete'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}
{jsfile src="admin/edit.js"}
{jsfile src="admin/resource-types.js"}
{jsfile src="js/jquery.form-3.09.min.js"}

<script type="text/javascript">

	$(document).ready(function ()
	{
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
					name:"{$type->Name()|escape:'javascript'}",
					description:"{$type->Description()|escape:'javascript'}"
				});
		{/foreach}
	})

</script>

{include file='globalfooter.tpl'}