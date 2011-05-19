{include file='globalheader.tpl' cssFiles='css/admin.css'}

<h1>Manage Schedules</h1>

<div class="admin">
	<div class="title">
		All Schedules
	</div>
	{foreach $Schedules item=schedule}
	{assign var=id value=$schedule->GetId()}
	{assign var=daysVisible value=$schedule->GetDaysVisible()}
	{assign var=dayOfWeek value=$schedule->GetWeekdayStart()}
	{assign var=dayName value=$DayNames[$dayOfWeek]}
	<div class="scheduleDetails">
		<div style="float:left;">
			<input type="hidden" class="id" value="{$id}" />
			<input type="hidden" class="daysVisible" value="{$daysVisible}" />
			<input type="hidden" class="dayOfWeek" value="{$dayOfWeek}" />
			<h4>{$schedule->GetName()}</h4> <a class="update renameButton" href="javascript: void(0);">Rename</a><br/>
			{translate key="LayoutDescription" args="$dayName, $daysVisible"}
			<a class="update changeButton" href="javascript:void(0);">Change</a><br/>
		</div>
		<div class="layout">
			Layout (all times {$schedule->GetTimezone()}):<br/>
			<input type="hidden" class="timezone" value="{$schedule->GetTimezone()}" />
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
		<div class="actions">
			{if $schedule->GetIsDefault()}
				<span class="note">This is the default schedule</span> |
				<span class="note">Default schedule cannot be brought down</span>
			{else}
				<a class="update makeDefaultButton" href="javascript: void(0);">Make Default</a> |
				<a class="update bringDownButton" href="javascript: void(0);">Bring Down</a>
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
		<div id="addScheduleResults" class="error" style="display:none;"></div>
		<form id="addScheduleForm" method="post">
			<ul>
				<li>Name<br/> <input type="text" class="textbox required" {formname key=SCHEDULE_NAME} /></li>
				<li>Starts On<br/> 
				<select {formname key=SCHEDULE_WEEKDAY_START} class="textbox">
					{foreach from=$DayNames item="dayName" key="dayIndex"}
						<option value="{$dayIndex}">{$dayName}</option>
					{/foreach} 
				</select>
				</li>
				<li>Number of Days Visible<br/><input type="text" class="textbox required" maxlength="3" size="3" {formname key=SCHEDULE_DAYS_VISIBLE} /> 
				</li>
				<li>Use Same Layout As<br/>
					<select class="textbox" {formname key=SCHEDULE_ID}>
					{foreach $Schedules item=schedule}
						<option value="{$schedule->GetId()}">{$schedule->GetName()}</option>
					{/foreach}
					</select>
				</li>
				<li>
					<button type="button" class="button save">{html_image src="disk-black.png"} Add Schedule</button>
				</li>
			</ul>
		</form>
	</div>
</div>

<input type="hidden" id="activeId" value="" />

<div id="makeDefaultDialog" style="display:none">
	<form id="makeDefaultForm" method="post">
	</form>
</div>

<div id="renameDialog" class="dialog" style="display:none;">
	<form id="renameForm" method="post">
		New Name: <input type="text" class="textbox required" {formname key=SCHEDULE_NAME} /><br/><br/>
		<button type="button" class="button save">{html_image src="disk-black.png"} Update</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} Cancel</button>
		
	</form>
</div>

<div id="changeSettingsDialog" class="dialog" style="display:none;">
	<form id="settingsForm" method="post">
		Starts On: <select id="dayOfWeek" {formname key=SCHEDULE_WEEKDAY_START} class="textbox">
			{foreach from=$DayNames item="dayName" key="dayIndex"}
				<option value="{$dayIndex}">{$dayName}</option>
			{/foreach} 
		</select>
		<br/>
		Number of Days Visible: <input type="text" class="textbox required" id="daysVisible" maxlength="3" size="3" {formname key=SCHEDULE_DAYS_VISIBLE} /> 
		<br/><br/>
		<button type="button" class="button save">{html_image src="disk-black.png"} Update</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} Cancel</button>
	</form>
</div>

<div id="changeLayoutDialog" class="dialog" style="display:none;">
	<form id="changeLayoutForm" method="post">		
		<div style="float:left;">
			<h5>Reservable Time Slots</h5>
			<textarea id="reservableEdit" {formname key=SLOTS_RESERVABLE}></textarea>
		</div>
		<div style="float:right;">
			<h5>Blocked Time Slots</h5>
			<textarea id="blockedEdit" {formname key=SLOTS_BLOCKED}></textarea>
		</div>
		<div style="clear:both;height:0px;">&nbsp</div>
		<div style="margin-top:5px;">
			<h5>
				{translate key=Timezone} 
				<select {formname key=TIMEZONE} id="layoutTimezone" class="input">
		        	{html_options values=$TimezoneValues output=$TimezoneOutput}
		        </select>
	        </h5>
		</div>
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
	<div id="layoutResults"></div>
</div>

{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}
<script type="text/javascript" src="{$Path}scripts/admin/schedule.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.form-2.43.js"></script>

<script type="text/javascript">

$(document).ready(function() {

	var opts = {
			submitUrl: '{$smarty.server.SCRIPT_NAME}',
			saveRedirect: '{$smarty.server.SCRIPT_NAME}',
			renameAction: '{ManageSchedules::ActionRename}',		
			changeSettingsAction: '{ManageSchedules::ActionChangeSettings}',
			changeLayoutAction: '{ManageSchedules::ActionChangeLayout}',
			addAction: '{ManageSchedules::ActionAdd}',
			makeDefaultAction: '{ManageSchedules::ActionMakeDefault}'
	};

	var scheduleManagement = new ScheduleManagement(opts);
	scheduleManagement.init();
});

</script>

{include file='globalfooter.tpl'}