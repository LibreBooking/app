{include file='globalheader.tpl'}
<style type="text/css">
	@import url({$Path}css/admin.css);
</style>

<h1>Manage Schedules</h1>

<table class="admin">
	<tr class="title">
		<td colspan="1">All Schedules</td>
	</tr>
{foreach $Schedules item=schedule}
	{assign var=id value=$schedule->GetId()}
	<tr>
		<td>
			<input type="hidden" class="id" value="{$schedule->GetId()}" />
			<h4>{$schedule->GetName()}</h4> <a class="update renameButton" href="javascript: void(0);">Rename</a><br/>
			Starts on Sunday, showing 7 days at a time <a class="update changeButton" href="javascript:void(0);">Change</a><br/>
			00:00 - 06:00 (no label) Available
			06:00 - 12:00 First Period Available
			12:00 - 04:00 (no label) Blocked
			<br/>
			{if $schedule->GetIsDefault()}
				<span class="note">This is the default schedule</span> |
				<span class="note">Default schedule cannot be made unavailable</span>
			{else}
				<a class="update makeDefaultButton" href="javascript: void(0);">Make Default</a> |
				<a class="update makeUnavailableButton" href="javascript: void(0);">Make Unavailable</a>
			{/if}
			|
			<a href="javascript: manageSchedule({$id}); void(0);">Change Layout</a>
	</tr>
{/foreach}
</table>

<div class="admin" style="margin-top:30px">
	<div class="title">
		Add New Schedule
	</div>
	<div>
		<form id="addScheduleForm" method="post">
			<ul>
				<li>Name<br/><input type="text" class="textbox required" /></li>
				<li>Starts on<br/><input type="text" class="textbox required" /></li>
				<li>Number of days to show<br/><input type="text" class="textbox required" /></li>
				<li>Use same layout at<br/>
					<select class="textbox">
					{foreach $Schedules item=schedule}
						<option value="{$schedule->GetId()}">{$schedule->GetName()}</option>
					{/foreach}
					</select>
				</li>
				<li><button type="button" class="button save">{html_image src="disk-black.png"} Add Schedule</button></li>
			</ul>
		</form>
	</div>
</div>

<input type="hidden" id="activeId" value="" />

<div id="renameDialog" class="dialog" style="display:none;">
	<form id="renameForm" method="post">
		New Name: <input type="text" class="textbox required" {formname key=SCHEDULE_NAME} /><br/><br/>
		<button type="button" class="button save">{html_image src="disk-black.png"} Update</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} Cancel</button>
		
	</form>
</div>

<div id="changeSettingsDialog" class="dialog" style="display:none;">
	<form>
		New Name: <input type="text" class="textbox required" /><br/><br/>
		<button type="button" class="button save">{html_image src="disk-black.png"} Update</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} Cancel</button>
	</form>
</div>

{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}
<script type="text/javascript" src="{$Path}scripts/admin/schedule.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.form-2.43.js"></script>

<script type="text/javascript">

$(document).ready(function() {

	var opts = {
			submitUrl: '{$smarty.server.SCRIPT_NAME}',
			saveRedirect: '{$smarty.server.SCRIPT_NAME}',
			renameAction: 'rename'
	};

	var scheduleManagement = new ScheduleManagement(opts);
	scheduleManagement.init();
});

</script>


{include file='globalfooter.tpl'}