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
{include file='globalheader.tpl' InlineEdit=true}

<div id="page-manage-resource-types" class="admin-page">

	{include file='Admin/Resources/manage_resource_menu.tpl' ResourcePageTitleKey='ManageResourceTypes'}

	<div id="globalError" class="error" style="display:none"></div>

	<form id="addForm" ajaxAction="{ManageResourceTypesActions::Add}" class="form-inline" role="form" method="post">
		<div class="panel panel-default" id="add-resource-type-panel">
			<div class="panel-heading">{translate key="AddResourceType"} {showhide_icon}</div>
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

	<div class="modal fade" id="editDialog" tabindex="-1" role="dialog" aria-labelledby="editDialogLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<form id="editForm" method="post" ajaxAction="{ManageResourceTypesActions::Update}">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="editDialogLabel">{translate key=Edit}</h4>
					</div>
					<div class="modal-body">
						<div class="form-group has-feedback">
							<label for="editName">{translate key=Name}</label><br/>
							<input type="text" id="editName"
								   class="form-control required" required="required"
								   maxlength="85" {formname key=RESOURCE_TYPE_NAME} />
							<i class="glyphicon glyphicon-asterisk form-control-feedback"
							   data-bv-icon-for="editName"></i>
						</div>
						<div class="form-group">
							<label for="editDescription">{translate key='Description'}</label><br/>
							<textarea class="form-control" rows="1" {formname key=RESOURCE_TYPE_DESCRIPTION}
									  id="editDescription"></textarea>
						</div>
					</div>
					<div class="modal-footer">
						{cancel_button}
						{update_button}
						{indicator}
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="modal fade" id="deleteDialog" tabindex="-1" role="dialog" aria-labelledby="deleteDialogLabel"
		 aria-hidden="true">
		<div class="modal-dialog">
			<form id="deleteForm" method="post" ajaxAction="{ManageResourceTypesActions::Delete}">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="deleteDialogLabel">{translate key=Delete}</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-warning">
							<div>{translate key=DeleteWarning}</div>
						</div>
					</div>
					<div class="modal-footer">
						{cancel_button}
						{delete_button}
						{indicator}
					</div>
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
					if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0)
					{
						$(this).popover('hide');
					}
				});
			});
		}

		function setUpPopovers() {
			$('[rel="popover"]').popover({
				container: 'body',
				html: true,
				placement: 'top',
				content: function () {
					var popoverId = $(this).data('popover-content');
					return $(popoverId).html();
				}
			}).click(function (e) {
				e.preventDefault();
			}).on('show.bs.popover', function () {

			}).on('shown.bs.popover', function () {
				var trigger = $(this);
				var popover = trigger.data('bs.popover').tip();
				popover.find('.editable-cancel').click(function () {
					trigger.popover('hide');
				});
			});
		}

		function setUpEditables() {
			$.fn.editable.defaults.mode = 'popup';
			$.fn.editable.defaults.toggle = 'manual';
			$.fn.editable.defaults.emptyclass = '';
			$.fn.editable.defaults.params = function(params) {
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
