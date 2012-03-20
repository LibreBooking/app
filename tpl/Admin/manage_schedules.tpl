{*
Copyright 2011-2012 Nick Korbel

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

<h1>{translate key=ManageSchedules}</h1>

<div class="admin">
	<div class="title">
	{translate key=AllSchedules}
	</div>
{foreach from=$Schedules item=schedule}
	{assign var=id value=$schedule->GetId()}
	{assign var=daysVisible value=$schedule->GetDaysVisible()}
	{assign var=dayOfWeek value=$schedule->GetWeekdayStart()}
	{assign var=dayName value=$DayNames[$dayOfWeek]}
	<div class="scheduleDetails">
		<div style="float:left;">
			<input type="hidden" class="id" value="{$id}"/>
			<input type="hidden" class="daysVisible" value="{$daysVisible}"/>
			<input type="hidden" class="dayOfWeek" value="{$dayOfWeek}"/>
			<h4>{$schedule->GetName()}</h4> <a class="update renameButton" href="javascript: void(0);">{translate key=Rename}</a><br/>
			{translate key="LayoutDescription" args="$dayName, $daysVisible"}
			<a class="update changeButton" href="javascript:void(0);">{translate key=Change}</a><br/>
		</div>
		<div class="layout">
			{translate key=ScheduleLayout args=$schedule->GetTimezone()}:<br/>
			<input type="hidden" class="timezone" value="{$schedule->GetTimezone()}"/>
			{translate key=ReservableTimeSlots}
			<div class="reservableSlots">
				{foreach from=$Layouts[$id] item=period}
					{if $period->IsReservable()}
						{formatdate format="H:i" date=$period->Begin()} - {formatdate format="H:i" date=$period->End()}
						{if $period->IsLabelled()}
							{$period->Label()}
						{/if}
						,
					{/if}
					{foreachelse}
					{translate key=None}
				{/foreach}
			</div>
			{translate key=BlockedTimeSlots}
			<div class="blockedSlots">
				{foreach from=$Layouts[$id] item=period}
					{if !$period->IsReservable()}
						{formatdate format="H:i" date=$period->Begin()} - {formatdate format="H:i" date=$period->End()}
						{if $period->IsLabelled()}
							{$period->Label()}
						{/if}
						,
					{/if}
					{foreachelse}
					{translate key=None}
				{/foreach}
			</div>
		</div>
		<div class="actions">
			{if $schedule->GetIsDefault()}
				<span class="note">{translate key=ThisIsTheDefaultSchedule}</span> |
				<span class="note">{translate key=DefaultScheduleCannotBeDeleted}</span> |
			{else}
				<a class="update makeDefaultButton" href="javascript: void(0);">{translate key=MakeDefault}</a> |
				<a class="update deleteScheduleButton" href="#">{translate key=Delete}</a> |
			{/if}
			<a class="update changeLayoutButton" href="javascript: void(0);">{translate key=ChangeLayout}</a> |
			{if $schedule->GetIsCalendarSubscriptionAllowed()}
				<a class="update disableSubscription" href="javascript: void(0);">{translate key=TurnOffSubscription}</a>
			{else}
				<a class="update enableSubscription" href="javascript: void(0);">{translate key=TurnOnSubscription}</a>
			{/if}
		</div>
	</div>
{/foreach}
</div>

<div class="admin" style="margin-top:30px">
	<div class="title">
	{translate key=AddSchedule}
	</div>
	<div>
		<div id="addScheduleResults" class="error" style="display:none;"></div>
		<form id="addScheduleForm" method="post">
			<ul>
				<li>{translate key=Name}<br/> <input type="text" style="width:300px"
													 class="textbox required" {formname key=SCHEDULE_NAME} /></li>
				<li>{translate key=StartsOn}<br/>
					<select {formname key=SCHEDULE_WEEKDAY_START} class="textbox">
					{foreach from=$DayNames item="dayName" key="dayIndex"}
						<option value="{$dayIndex}">{$dayName}</option>
					{/foreach}
					</select>
				</li>
				<li>{translate key=NumberOfDaysVisible}<br/><input type="text" class="textbox required" maxlength="3"
																   size="3" {formname key=SCHEDULE_DAYS_VISIBLE} />
				</li>
				<li>{translate key=UseSameLayoutAs}<br/>
					<select style="width:300px" class="textbox" {formname key=SCHEDULE_ID}>
					{foreach from=$Schedules item=schedule}
						<option value="{$schedule->GetId()}">{$schedule->GetName()}</option>
					{/foreach}
					</select>
				</li>
				<li style="padding-top:5px;">
					<button type="button" class="button save"
							value="submit">{html_image src="plus-button.png"} {translate key=AddSchedule}</button>
				</li>
			</ul>
		</form>
	</div>
</div>

<input type="hidden" id="activeId" value=""/>

<div id="deleteDialog" class="dialog" title="{translate key=Delete}">
	<form id="deleteForm" method="post">
		<div class="error" style="margin-bottom: 25px;">
			<h3>{translate key=DeleteWarning}</h3>
		</div>

		{translate key=MoveResourcesAndReservations}
		<select id="targetScheduleId" {formname key=SCHEDULE_ID} class="required">
			<option value="">-- {translate key=Schedule} --</option>
			{foreach from=$Schedules item=schedule}
			<option value="{$schedule->GetId()}">{$schedule->GetName()}</option>
			{/foreach}
		</select>
		<br/><br/>
		<button type="button" class="button save">{html_image src="cross-button.png"} {translate key=Delete}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key=Cancel}</button>
	</form>
</div>
<div id="placeholderDialog" style="display:none">
	<form id="placeholderForm" method="post">
	</form>
</div>

<div id="renameDialog" class="dialog" style="display:none;">
	<form id="renameForm" method="post">
	{translate key=Name}: <input type="text" class="textbox required" {formname key=SCHEDULE_NAME} /><br/><br/>
		<button type="button" class="button save">{html_image src="tick-circle.png"} {translate key=Update}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key=Cancel}</button>

	</form>
</div>

<div id="changeSettingsDialog" class="dialog" style="display:none;">
	<form id="settingsForm" method="post">
	{translate key=StartsOn}: <select id="dayOfWeek" {formname key=SCHEDULE_WEEKDAY_START} class="textbox">
	{foreach from=$DayNames item="dayName" key="dayIndex"}
		<option value="{$dayIndex}">{$dayName}</option>
	{/foreach}
	</select>
		<br/>
	{translate key=NumberOfDaysVisible}: <input type="text" class="textbox required" id="daysVisible" maxlength="3"
												size="3" {formname key=SCHEDULE_DAYS_VISIBLE} />
		<br/><br/>
		<button type="button" class="button save">{html_image src="tick-circle.png"} {translate key=Update}</button>
		<button type="button" class="button cancel">{html_image src="slash.png"} {translate key=Cancel}</button>
	</form>
</div>

<div id="changeLayoutDialog" class="dialog" style="display:none;">
	<div>
		<ul>{async_validator id="layoutValidator" key="ValidLayoutRequired"}
		</ul>
	</div>
	<form id="changeLayoutForm" method="post">
		<div style="float:left;">
			<h5>{translate key=ReservableTimeSlots}</h5>
			<textarea id="reservableEdit" {formname key=SLOTS_RESERVABLE}></textarea>
		</div>
		<div style="float:right;">
			<h5>{translate key=BlockedTimeSlots}</h5>
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
		<div>
			<h5>
			{capture name="layoutConfig" assign="layoutConfig"}
				<input type='text' value='30' id='quickLayoutConfig' size=5' />
			{/capture}
			{capture name="layoutStart" assign="layoutStart"}
				<input type='text' value='08:00' id='quickLayoutStart' size='10'/>
			{/capture}
			{capture name="layoutEnd" assign="layoutEnd"}
				<input type='text' value='18:00' id='quickLayoutEnd' size='10'/>
			{/capture}
			{translate key=QuickSlotCreation args="$layoutConfig,$layoutStart,$layoutEnd"}
			</h5>
		</div>
		<div style="margin-top: 5px; padding-top:5px; border-top: solid 1px #f0f0f0;">
			<div>
				<button type="button"
						class="button save">{html_image src="tick-circle.png"} {translate key=Update}</button>
				<button type="button" class="button cancel">{html_image src="slash.png"} {translate key=Cancel}</button>
			</div>
			<div>
				<p>{translate key=Format}: <span style="font-family:courier new;">HH:MM - HH:MM {translate key=OptionalLabel}</span></p>

				<p>{translate key=LayoutInstructions}</p>
			</div>
		</div>
	</form>
</div>

{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}
<script type="text/javascript" src="{$Path}scripts/admin/edit.js"></script>
<script type="text/javascript" src="{$Path}scripts/admin/schedule.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.form-2.43.js"></script>

<script type="text/javascript">

	$(document).ready(function () {

	var opts = {
	submitUrl: '{$smarty.server.SCRIPT_NAME}',
	saveRedirect: '{$smarty.server.SCRIPT_NAME}',
	renameAction: '{ManageSchedules::ActionRename}',
	changeSettingsAction: '{ManageSchedules::ActionChangeSettings}',
	changeLayoutAction: '{ManageSchedules::ActionChangeLayout}',
	addAction: '{ManageSchedules::ActionAdd}',
	makeDefaultAction: '{ManageSchedules::ActionMakeDefault}',
	deleteAction: '{ManageSchedules::ActionDelete}',
	enableSubscriptionAction: '{ManageSchedules::ActionEnableSubscription}',
	disableSubscriptionAction: '{ManageSchedules::ActionDisableSubscription}'
	};

	var scheduleManagement = new ScheduleManagement(opts);
	scheduleManagement.init();
	});

</script>

{include file='globalfooter.tpl'}