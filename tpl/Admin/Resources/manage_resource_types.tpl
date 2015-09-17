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
{include file='globalheader.tpl' InlineEdit=true}

<div id="page-manage-resource-types" class="admin-page">

	{include file='Admin/Resources/manage_resource_menu.tpl' ResourcePageTitleKey='ManageResourceTypes'}

	<div id="globalError" class="error" style="display:none"></div>

	<form id="addForm" ajaxAction="{ManageResourceTypesActions::Add}" class="form-inline" role="form" method="post">
		<div class="panel panel-default" id="add-resource-type-panel">
			<div class="panel-heading">{translate key="AddResourceType"} <a href="#"><span
							class="icon black show-hide glyphicon"></span></a></div>
			<div class="panel-body add-contents">
				<div id="addResults" class="error no-show"></div>
				<div class="form-group has-feedback">
					<label for="resourceTypeName">{translate key='Name'}</label>
					<input type="text" class="form-control required" maxlength="85" required
							{formname key=RESOURCE_TYPE_NAME} id="resourceTypeName"/>
					<i class="glyphicon glyphicon-asterisk form-control-feedback"
					   data-bv-icon-for="resourceTypeName"></i>
				</div>
				<div class="form-group">
					<label for="resourceTypeDesc">{translate key='Description'}</label>
					<textarea class="form-control" rows="1" {formname key=RESOURCE_TYPE_DESCRIPTION}
							  id="resourceTypeDesc"></textarea>
				</div>
			</div>
			<div class="panel-footer">
				<button type="button" class="btn btn-success btn-sm save create">
					<span class="glyphicon glyphicon-ok-circle"></span>
					{translate key='Create'}
				</button>
				<button type="reset" class="btn btn-default btn-sm">{translate key=Reset}</button>
				{indicator}
			</div>
		</div>
	</form>

	<table class="table" id="resourceTypes">
		<thead>
		<tr>
			<th>{translate key='Name'}</th>
			<th>{translate key='Description'}</th>
			<th>{translate key='Actions'}</th>
		</tr>
		</thead>
		<tbody>
		{foreach from=$ResourceTypes item=type}
			{cycle values='row0,row1' assign=rowCss}
			{assign var=id value=$type->Id()}
			<tr class="{$rowCss}">
				<td>{$type->Name()}</td>
				<td>{$type->Description()|nl2br}</td>
				<td align="center">
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
			{*{assign var=attributes value=$AttributeList->GetAttributes($id)}*}
			{*{if $attributes|count > 0}*}
			{*<tr>*}
			{*<td colspan="4" class="{$rowCss} customAttributes" resourceTypeId="{$id}">*}
			{*<form method="post" class="attributesForm"*}
			{*ajaxAction="{ManageResourceTypesActions::ChangeAttributes}">*}
			{*<h3>{translate key=AdditionalAttributes} <a href="#"*}
			{*class="changeAttributes"*}
			{*resourceTypeId="{$id}">{translate key=Edit}</a>*}
			{*</h3>*}

			{*<div class="validationSummary">*}
			{*<ul>*}
			{*</ul>*}
			{*<div class="clear">&nbsp;</div>*}
			{*</div>*}

			{*<div>*}
			{*<ul>*}
			{*{foreach from=$attributes item=attribute}*}
			{*<li class="customAttribute" attributeId="{$attribute->Id()}">*}
			{*<div class="attribute-readonly">{control type="AttributeControl" attribute=$attribute readonly=true}</div>*}
			{*<div class="attribute-readwrite hidden">{control type="AttributeControl" attribute=$attribute}*}
			{*</li>*}
			{*{/foreach}*}
			{*</ul>*}
			{*</div>*}

			{*<div class="attribute-readwrite hidden clear" style="height:auto;">*}
			{*<button type="button"*}
			{*class="button save">{html_image src="tick-circle.png"} {translate key='Update'}</button>*}
			{*<button type="button"*}
			{*class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>*}
			{*</div>*}
			{*</form>*}
			{*</td>*}
			{*</tr>*}
			{*{/if}*}
		{/foreach}
		</tbody>
	</table>

	<input type="hidden" id="activeId" value=""/>

	<div id="editDialog" class="dialog" style="display:none;" title="{translate key=Update}">
		<form id="editForm" method="post" ajaxAction="{ManageResourceTypesActions::Update}">
			<label for="editName">{translate key='Name'}:</label>
			<input id="editName" type="text" class="textbox required" maxlength="85"
					{formname key=RESOURCE_TYPE_NAME} />
			<br/><br/>

			<label for="editDescription">{translate key=Description}:</label><br/>
			<textarea id="editDescription" class="textbox"
					{formname key=RESOURCE_TYPE_DESCRIPTION}></textarea>
			<br/><br/>

			<button type="button"
					class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
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
	{jsfile src="ajax-helpers.js"}
	{jsfile src="admin/resource-types.js"}
	{jsfile src="js/jquery.form-3.09.min.js"}

	<script type="text/javascript">

		function hidePopoversWhenClickAway()
		{
			$('body').on('click', function (e)
			{
				$('[rel="popover"]').each(function ()
				{
					if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0)
					{
						$(this).popover('hide');
					}
				});
			});
		}

		function setUpPopovers()
		{
			$('[rel="popover"]').popover({
				container: 'body',
				html: true,
				placement: 'top',
				content: function ()
				{
					var popoverId = $(this).data('popover-content');
					return $(popoverId).html();
				}
			}).click(function (e)
			{
				e.preventDefault();
			}).on('show.bs.popover', function ()
			{

			}).on('shown.bs.popover', function ()
			{
				var trigger = $(this);
				var popover = trigger.data('bs.popover').tip();
				popover.find('.editable-cancel').click(function ()
				{
					trigger.popover('hide');
				});
			});
		}

		function setUpEditables()
		{
			$.fn.editable.defaults.mode = 'popup';
			$.fn.editable.defaults.toggle = 'manual';
			$.fn.editable.defaults.emptyclass = '';

			var updateUrl = '{$smarty.server.SCRIPT_NAME}?action=';

			$('.inlineAttribute').editable({
				url: updateUrl + '{ManageResourceTypesActions::ChangeAttribute}',
				emptytext: '-'
			});

		}

		$(document).ready(function ()
		{
			setUpPopovers();
			hidePopoversWhenClickAway();
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
