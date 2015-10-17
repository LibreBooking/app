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
{include file='globalheader.tpl'}

<div id="page-manage-announcements" class="admin-page">
	<h1>{translate key=ManageAnnouncements}</h1>

	<form id="addForm" class="form-inline" role="form" method="post">
		<div class="panel panel-default" id="add-announcement-panel">
			<div class="panel-heading">{translate key="AddAnnouncement"} {showhide_icon}</div>
			<div class="panel-body add-contents">
				<div id="addResults" class="error no-show"></div>
				<div class="form-group has-feedback">
					<label for="addAnnouncement">{translate key='Announcement'}</label>
					<textarea class="form-control required" rows="1" {formname key=ANNOUNCEMENT_TEXT} id="addAnnouncement"></textarea>
					<i class="glyphicon glyphicon-asterisk form-control-feedback" data-bv-icon-for="addAnnouncement"></i>
				</div>
				<div class="form-group">
					<label for="BeginDate">{translate key='BeginDate'}</label>
					<input type="text" id="BeginDate" class="form-control" {formname key=ANNOUNCEMENT_START} />
					<input type="hidden" id="formattedBeginDate" {formname key=ANNOUNCEMENT_START} />
				</div>
				<div class="form-group">
					<label for="EndDate">{translate key='EndDate'}</label>
					<input type="text" id="EndDate" class="form-control" {formname key=ANNOUNCEMENT_END} />
					<input type="hidden" id="formattedEndDate" {formname key=ANNOUNCEMENT_END} />
				</div>
				<div class="form-group">
					<label for="addPriority">{translate key='Priority'}</label>
					<select class="form-control" {formname key=ANNOUNCEMENT_PRIORITY} id="addPriority">
						<option value="">---</option>
						{html_options values=$priorities output=$priorities}
					</select>
				</div>
			</div>
			<div class="panel-footer">
			 	{add_button class="btn-sm"}
				{reset_button class="btn-sm"}
				{indicator}
			</div>
		</div>
	</form>

	<table class="table" id="announcementList">
		<thead>
		<tr>
			<th>{translate key='Announcement'}</th>
			<th>{translate key='Priority'}</th>
			<th>{translate key='BeginDate'}</th>
			<th>{translate key='EndDate'}</th>
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
				<td class="action announcementActions">
					<a href="#" class="update edit"><span class="fa fa-pencil-square-o icon"></a> |
					<a href="#" class="update delete"><span class="fa fa-trash icon remove"></span></a>
				</td>
			</tr>
		{/foreach}
		</tbody>
	</table>

	<input type="hidden" id="activeId"/>

	<div class="modal fade" id="deleteDialog" tabindex="-1" role="dialog" aria-labelledby="deleteDialogLabel" aria-hidden="true">
		<div class="modal-dialog">
			<form id="deleteForm" method="post">
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

	<div class="modal fade" id="editDialog" tabindex="-1" role="dialog" aria-labelledby="editDialogLabel" aria-hidden="true">
		<div class="modal-dialog">
			<form id="editForm" method="post">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="editDialogLabel">{translate key=Edit}</h4>
					</div>
					<div class="modal-body">
						<div class="form-group has-feedback">
							<label for="editText">{translate key=Announcement}</label><br/>
							<textarea id="editText" class="form-control required" {formname key=ANNOUNCEMENT_TEXT}></textarea>
							<i class="glyphicon glyphicon-asterisk form-control-feedback" data-bv-icon-for="editText"></i>
						</div>
						<div class="form-group">
							<label for="editBegin">{translate key='BeginDate'}</label><br/>
							<input type="text" id="editBegin" class="form-control"/>
							<input type="hidden" id="formattedEditBegin" {formname key=ANNOUNCEMENT_START} />
						</div>
						<div class="form-group">
							<label for="editEnd">{translate key='EndDate'}</label><br/>
							<input type="text" id="editEnd" class="form-control"/>
							<input type="hidden" id="formattedEditEnd" {formname key=ANNOUNCEMENT_END} />
						</div>
						<div class="form-group">
							<label for="editPriority">{translate key='Priority'}</label> <br/>
							<select id="editPriority" class="form-control" {formname key=ANNOUNCEMENT_PRIORITY}>
								<option value="">---</option>
								{html_options values=$priorities output=$priorities}
							</select>
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

			var actions = {
				add: '{ManageAnnouncementsActions::Add}',
				edit: '{ManageAnnouncementsActions::Change}',
				deleteAnnouncement: '{ManageAnnouncementsActions::Delete}'
			};

			var accessoryOptions = {
				submitUrl: '{$smarty.server.SCRIPT_NAME}',
				saveRedirect: '{$smarty.server.SCRIPT_NAME}',
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
					'{$announcement->Priority()}'
			);
			{/foreach}

			$('#add-announcement-panel').showHidePanel();
		});
	</script>
</div>
{include file='globalfooter.tpl'}
