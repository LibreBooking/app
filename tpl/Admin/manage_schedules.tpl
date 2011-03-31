{include file='globalheader.tpl'}
<style type="text/css">
	@import url({$Path}css/admin.css);
</style>

<h1>Manage Schedules</h1>

<div class="admin">
	<div class="title">
		All Schedules
	</div>
	{foreach $Schedules item=schedule}
	{assign var=id value=$schedule->GetId()}
	<div class="scheduleDetails">
		<div style="float:left;">
			<input type="hidden" class="id" value="{$id}" />
			<h4>{$schedule->GetName()}</h4> <a class="update renameButton" href="javascript: void(0);">Rename</a><br/>
			Starts on Sunday, showing 7 days at a time <a class="update changeButton" href="javascript:void(0);">Change</a><br/>
		</div>
		<div style="border-left:solid 1px #f0f0f0;float:right;width:550px;">
			Layout (all times {$schedule->GetTimezone()}):<br/>
			Reservable Time Slots
			<div class="reservableSlots">
			{foreach $Layouts[$id] item=period}
				{if $period->IsReservable()}
					{formatdate format="H:i" date=$period->Begin()} - {formatdate format="H:i" date=$period->End()}
					{if $period->IsLabelled()}
						{$period->Label()}
					{/if}
					,
				{/if}
			{foreachelse}
				None
			{/foreach}
			</div>
			Blocked Time Slots
			<div class="blockedSlots">
			{foreach $Layouts[$id] item=period}
				{if !$period->IsReservable()}
					{formatdate format="H:i" date=$period->Begin()} - {formatdate format="H:i" date=$period->End()}
					{if $period->IsLabelled()}
						{$period->Label()}
					{/if}
					,
				{/if}
			{foreachelse}
				None
			{/foreach}	
			</div>		
		</div>
		<div style="clear:both;border-top:solid 1px #f0f0f0;">
			{if $schedule->GetIsDefault()}
				<span class="note">This is the default schedule</span> |
				<span class="note">Default schedule cannot be made unavailable</span>
			{else}
				<a class="update makeDefaultButton" href="javascript: void(0);">Make Default</a> |
				<a class="update makeUnavailableButton" href="javascript: void(0);">Make Unavailable</a>
			{/if}
			|
			<a class="update changeLayoutButton" href="javascript: void(0);">Change Layout</a>
		</div>
	</div>
	{/foreach}
</div>

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

<div id="changeLayoutDialog" class="dialog" style="display:none;">
	<form id="changeLayoutForm" method="post">
		<div style="float:left;">
			<h5>Reservable Time Slots</h5>
			<textarea id="reservableEdit"></textarea>
		</div>
		<div style="float:right;">
			<h5>Blocked Time Slots</h5>
			<textarea id="blockedEdit"></textarea>
		</div>
		<div style="clear:both;height:0px;">&nbsp</div>
		<div style="margin-top: 5px; padding-top:5px; border-top: solid 1px #f0f0f0;">
			<div style="float:left;">
				<button type="button" class="button save">{html_image src="disk-black.png"} Update</button>
				<button type="button" class="button cancel">{html_image src="slash.png"} Cancel</button>
			</div>
			<div style="float:right;">
				<p>Format: <span style="font-family:courier new;">HH:MM - HH:MM Optional Label</span></p>
				<p>Enter one slot per line.  Slots must be provided for all 24 hours of the day.</p>
			</div>
		</div>
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
			renameAction: 'rename',
			changeLayoutAction: 'changeLayout'
	};

	var scheduleManagement = new ScheduleManagement(opts);
	scheduleManagement.init();
});

</script>

{include file='globalfooter.tpl'}