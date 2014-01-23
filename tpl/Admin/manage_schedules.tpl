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
	{if $dayOfWeek == Schedule::Today}
		{assign var=dayName value=$Today}
	{/if}
    <div class="scheduleDetails">
        <div style="float:left;">
            <input type="hidden" class="id" value="{$id}"/>
            <input type="hidden" class="daysVisible" value="{$daysVisible}"/>
            <input type="hidden" class="dayOfWeek" value="{$dayOfWeek}"/>
            <h4>{$schedule->GetName()}</h4> <a class="update renameButton"
                                               href="javascript: void(0);">{translate key=Rename}</a><br/>
			{translate key="LayoutDescription" args="$dayName, $daysVisible"}
            <a class="update changeButton" href="javascript:void(0);">{translate key=Change}</a><br/>
			{translate key='ScheduleAdministrator'}
			{if $schedule->HasAdminGroup()}
				{$GroupLookup[$schedule->GetAdminGroupId()]->Name}
				{else}
                <span class="note">{translate key='NoScheduleAdministratorLabel'}</span>
			{/if}
			{if $AdminGroups|count > 0}
                <a class="update adminButton" href="javascript: void(0);"
                   adminId="{$schedule->GetAdminGroupId()}">{translate key='Edit'}</a>
			{/if}
        </div>

        <div class="layout">

			{function name="display_periods"}
				{foreach from=$Layouts[$id]->GetSlots($day) item=period}
					{if $period->IsReservable() == $showReservable}
						{$period->Start->Format("H:i")} - {$period->End->Format("H:i")}
						{if $period->IsLabelled()}
							{$period->Label}
						{/if}
                        ,
					{/if}
					{foreachelse}
					{translate key=None}
				{/foreach}
			{/function}

			{translate key=ScheduleLayout args=$schedule->GetTimezone()}:<br/>
            <input type="hidden" class="timezone" value="{$schedule->GetTimezone()}"/>

			{if !$Layouts[$id]->UsesDailyLayouts()}
                <input type="hidden" class="usesDailyLayouts" value="false"/>
				{translate key=ReservableTimeSlots}
                <div class="reservableSlots" id="reservableSlots" ref="reservableEdit">
					{display_periods showReservable=true day=null}
                </div>
				{translate key=BlockedTimeSlots}
                <div class="blockedSlots" id="blockedSlots" ref="blockedEdit">
					{display_periods showReservable=false day=null}
                </div>
			{else}
                <input type="hidden" class="usesDailyLayouts" value="true"/>
				{translate key=LayoutVariesByDay} - <a href="#" class="showAllDailyLayouts">{translate key=ShowHide}</a>
                <div class="allDailyLayouts">
				{foreach from=DayOfWeek::Days() item=day}
					{$DayNames[$day]}
					<div class="reservableSlots" id="reservableSlots_{$day}" ref="reservableEdit_{$day}">
						{display_periods showReservable=true day=$day}
					</div>
					<div class="blockedSlots" id="blockedSlots_{$day}" ref="blockedEdit_{$day}">
						{display_periods showReservable=false day=$day}
					</div>
                {/foreach}
				</div>
			{/if}
        </div>
        <div class="actions">
			<div style="float:left;">
				{if $schedule->GetIsDefault()}
                <span class="note">{translate key=ThisIsTheDefaultSchedule}</span> |
                <span class="note">{translate key=DefaultScheduleCannotBeDeleted}</span> |
				{else}
                <a class="update makeDefaultButton" href="javascript: void(0);">{translate key=MakeDefault}</a> |
                <a class="update deleteScheduleButton" href="#">{translate key=Delete}</a> |
			{/if}
            <a class="update changeLayoutButton" href="javascript: void(0);">{translate key=ChangeLayout}</a> |
			{if $schedule->GetIsCalendarSubscriptionAllowed()}
                <a class="update disableSubscription"
                   href="javascript: void(0);">{translate key=TurnOffSubscription}</a>
				{else}
                <a class="update enableSubscription" href="javascript: void(0);">{translate key=TurnOnSubscription}</a>
			{/if}
			</div>
			<div style="float:right;text-align:center;">
				{if $schedule->GetIsCalendarSubscriptionAllowed()}
					{html_image src="feed.png"} <a target="_blank" href="{$schedule->GetSubscriptionUrl()->GetAtomUrl()}">Atom</a> | <a target="_blank" href="{$schedule->GetSubscriptionUrl()->GetWebcalUrl()}">iCalendar</a>
				{/if}
			</div>
			<div class="clear"></div>
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
                        <option value="{Schedule::Today}">{$Today}</option>
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
					{foreach from=$SourceSchedules item=schedule}
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
	{translate key=StartsOn}:
        <select id="dayOfWeek" {formname key=SCHEDULE_WEEKDAY_START} class="textbox">
            <option value="{Schedule::Today}">{$Today}</option>
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

    <form id="changeLayoutForm" method="post">
        <div class="validationSummary">
            <ul>{async_validator id="layoutValidator" key="ValidLayoutRequired"}
            </ul>
        </div>

        <div class="clear;display:block;" style="height:20px;">
            <label>{translate key=UseSameLayoutForAllDays} <input type="checkbox" id="usesSingleLayout" {formname key=USING_SINGLE_LAYOUT}></label>
        </div>

	{function name=display_slot_inputs}
        <div class="clear" id="{$id}">
			{assign var=suffix value=""}
			{if $day!=null}
				{assign var=suffix value="_$day"}
			{/if}
            <div style="float:left;">
                <h5>{translate key=ReservableTimeSlots}</h5>
                <textarea class="reservableEdit"
                          id="reservableEdit{$suffix}" name="{FormKeys::SLOTS_RESERVABLE}{$suffix}"></textarea>
            </div>
            <div style="float:right;">
                <h5>{translate key=BlockedTimeSlots}</h5>
                <textarea class="blockedEdit" id="blockedEdit{$suffix}" name="{FormKeys::SLOTS_BLOCKED}{$suffix}"></textarea>
            </div>
        </div>
	{/function}
        <div class="clear" id="dailySlots">
            <div class="clear" id="tabs">
                <ul>
                    <li><a href="#tabs-0">{$DayNames[0]}</a></li>
                    <li><a href="#tabs-1">{$DayNames[1]}</a></li>
                    <li><a href="#tabs-2">{$DayNames[2]}</a></li>
                    <li><a href="#tabs-3">{$DayNames[3]}</a></li>
                    <li><a href="#tabs-4">{$DayNames[4]}</a></li>
                    <li><a href="#tabs-5">{$DayNames[5]}</a></li>
                    <li><a href="#tabs-6">{$DayNames[6]}</a></li>
                </ul>
                <div id="tabs-0">
				{display_slot_inputs day='0'}
                </div>
                <div id="tabs-1">
				{display_slot_inputs day='1'}
                </div>
                <div id="tabs-2">
				{display_slot_inputs day='2'}
                </div>
                <div id="tabs-3">
				{display_slot_inputs day='3'}
                </div>
                <div id="tabs-4">
				{display_slot_inputs day='4'}
                </div>
                <div id="tabs-5">
				{display_slot_inputs day='5'}
                </div>
                <div id="tabs-6">
				{display_slot_inputs day='6'}
                </div>
            </div>
        </div>

	{display_slot_inputs id="staticSlots" day=null}

        <div style="clear:both;height:0;">&nbsp</div>
        <div style="margin-top:5px;">
            <h5>
			{translate key=Timezone}
                <select {formname key=TIMEZONE} id="layoutTimezone" class="input">
				{html_options values=$TimezoneValues output=$TimezoneOutput}
                </select>
            </h5>
        </div>
        <div style="margin-top:2px;">
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
                <a href="#" id="createQuickLayout">{translate key=Create}</a>
            </h5>
        </div>
        <div style="margin-top: 5px; padding-top:5px; border-top: solid 1px #f0f0f0;">
            <div>
                <button type="button"
                        class="button save">{html_image src="tick-circle.png"} {translate key=Update}</button>
                <button type="button" class="button cancel">{html_image src="slash.png"} {translate key=Cancel}</button>
            </div>
            <div>
                <p>{translate key=Format}: <span
                        style="font-family:courier new;">HH:MM - HH:MM {translate key=OptionalLabel}</span></p>

                <p>{translate key=LayoutInstructions}</p>
            </div>
        </div>
    </form>
</div>


<div id="groupAdminDialog" class="dialog" title="{translate key=WhoCanManageThisSchedule}">
    <form method="post" id="groupAdminForm">
        <select id="adminGroupId" {formname key=SCHEDULE_ADMIN_GROUP_ID} class="textbox">
            <option value="">-- {translate key=None} --</option>
		{foreach from=$AdminGroups item=adminGroup}
            <option value="{$adminGroup->Id}">{$adminGroup->Name}</option>
		{/foreach}
        </select>
        <br/><br/>
        <button type="button" class="button save">{html_image src="tick-circle.png"} {translate key='Update'}</button>
        <button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
    </form>
</div>


{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}
{jsfile src="admin/edit.js"}
{jsfile src="admin/schedule.js"}
{jsfile src="js/jquery.form-3.09.min.js"}

<script type="text/javascript">

    $(document).ready(function ()
    {

        var opts = {
            submitUrl:'{$smarty.server.SCRIPT_NAME}',
            saveRedirect:'{$smarty.server.SCRIPT_NAME}',
            renameAction:'{ManageSchedules::ActionRename}',
            changeSettingsAction:'{ManageSchedules::ActionChangeSettings}',
            changeLayoutAction:'{ManageSchedules::ActionChangeLayout}',
            addAction:'{ManageSchedules::ActionAdd}',
            makeDefaultAction:'{ManageSchedules::ActionMakeDefault}',
            deleteAction:'{ManageSchedules::ActionDelete}',
            adminAction:'{ManageSchedules::ChangeAdminGroup}',
            enableSubscriptionAction:'{ManageSchedules::ActionEnableSubscription}',
            disableSubscriptionAction:'{ManageSchedules::ActionDisableSubscription}'
        };

        var scheduleManagement = new ScheduleManagement(opts);
        scheduleManagement.init();
    });

</script>

{include file='globalfooter.tpl'}