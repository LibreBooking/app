{include file='globalheader.tpl' cssFiles='css/admin.css'}

<h1>{translate key=ManageAnnouncements}</h1>

<table class="list">
	<tr>
		<th class="id">&nbsp;</th>
		<th>{translate key='Announcement'}</th>
		<th>{translate key='Priority'}</th>
		<th>{translate key='BeginDate'}</th>
		<th>{translate key='EndDate'}</th>
		<th>{translate key='Actions'}</th>
	</tr>
{foreach from=$announcements item=announcement}
	{cycle values='row0,row1' assign=rowCss}
	<tr class="{$rowCss}">
		<td class="id"><input type="hidden" class="id" value="{$announcement->Id()}"/></td>
		<td style="width:300px;">{$announcement->Text()|nl2br}</td>
		<td>{$announcement->Priority()}</td>
		<td style="width: 100px;">{formatdate date=$announcement->Start()->ToTimezone($timezone)}</td>
		<td style="width: 100px;">{formatdate date=$announcement->End()->ToTimezone($timezone)}</td>
		<td align="center"><a href="#" class="update edit">{translate key='Edit'}</a> | <a href="#" class="update delete">{translate key='Delete'}</a></td>
	</tr>
{/foreach}
</table>

<input type="hidden" id="activeId" />

<div id="deleteDialog" class="dialog" style="display:none;" title="{translate key=Delete}">
	<form id="deleteForm" method="post">
		<div class="error" style="margin-bottom: 25px;">
			<h3>{translate key=DeleteWarning}</h3>
		</div>
		<button type="button" class="button save">{html_image src="cross-button.png"} {translate key='Delete'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div id="editDialog" class="dialog" style="display:none;" title="{translate key=Edit}">
	<form id="editForm" method="post">
		{translate key=Announcement}<br/>
        <textarea id="editText" class="textbox required" style="width:500px" {formname key=ANNOUNCEMENT_TEXT}></textarea><br/>
        {translate key='BeginDate'}<br/>
        <input type="text" id="editBegin" class="textbox" {formname key=ANNOUNCEMENT_START} /><br/>
        {translate key='EndDate'}<br/>
        <input type="text" id="editEnd" class="textbox" {formname key=ANNOUNCEMENT_END} /><br/>
        {translate key='Priority'} <br/>
        <select id="editPriority" class="textbox" {formname key=ANNOUNCEMENT_PRIORITY}>
            <option value="">---</option>
            {html_options values=$priorities output=$priorities}
        </select><br/>
		<button type="button" class="button save">{html_image src="disk-black.png"} {translate key='Update'}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
	</form>
</div>

<div class="admin" style="margin-top:30px">
	<div class="title">
		{translate key=AddAnnouncement}
	</div>
	<div>
		<div id="addResults" class="error" style="display:none;"></div>
		<form id="addForm" method="post">
			<table>
				<tr>
					<th>{translate key='Announcement'}</th>
					<th>{translate key='BeginDate'}</th>
					<th>{translate key='EndDate'}</th>
					<th>{translate key='Priority'}</th>
					<th>&nbsp;</th>
				</tr>
				<tr>
					<td>
						<textarea class="textbox required" style="width:500px" {formname key=ANNOUNCEMENT_TEXT}></textarea>
					</td>
					<td>
						<input type="text" id="BeginDate" class="textbox" {formname key=ANNOUNCEMENT_START} />
					</td>
                    <td>
						<input type="text" id="EndDate" class="textbox" {formname key=ANNOUNCEMENT_END} />
					</td>
                    <td>
                        <select class="textbox" {formname key=ANNOUNCEMENT_PRIORITY}>
                            <option value="">---</option>
                            {html_options values=$priorities output=$priorities}
                        </select>
					</td>
					<td>
						<button type="button" class="button save">{html_image src="plus-button.png"} {translate key=AddAnnouncement}</button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>

{control type="DatePickerSetupControl" ControlId="BeginDate"}
{control type="DatePickerSetupControl" ControlId="EndDate"}
{control type="DatePickerSetupControl" ControlId="editBegin"}
{control type="DatePickerSetupControl" ControlId="editEnd"}

{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}

<script type="text/javascript" src="{$Path}scripts/admin/edit.js"></script>
<script type="text/javascript" src="{$Path}scripts/admin/announcement.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.form-2.43.js"></script>

<script type="text/javascript">
	$(document).ready(function() {

	var actions = {
		add: '{ManageAnnouncementsActions::Add}',
		edit: '{ManageAnnouncementsActions::Change}',
		delete: '{ManageAnnouncementsActions::Delete}'
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
        '{$announcement->Text()|regex_replace:"/[\n]/":"\\n"}',
        '{formatdate date=$announcement->Start()->ToTimezone($timezone)}',
        '{formatdate date=$announcement->End()->ToTimezone($timezone)}',
        '{$announcement->Priority()}'
    );
	{/foreach}
	
	});
</script>
{include file='globalfooter.tpl'}