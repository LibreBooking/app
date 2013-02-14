{*
Copyright 2011-2013 Nick Korbel

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

{* All of the slot display formatting *}

{function name=displayMyReserved}
	{if $Slot->IsPending()}
		{assign var=class value='pending'}
	{/if}
<td rowspan="{$Slot->PeriodSpan()}" class="reserved {$class} mine clickres slot" resid="{$Slot->Id()}"
    id="{$Slot->Id()}|{$Slot->Date()->Format('Ymd')}">{$Slot->Label()}</td>
{/function}

{function name=displayPastTime}
<td rowspan="{$Slot->PeriodSpan()}" ref="{$SlotRef}" class="pasttime slot">{$Slot->Label()}</td>
{/function}

{function name=displayReservable}
<td rowspan="{$Slot->PeriodSpan()}" ref="{$SlotRef}" class="reservable clickres slot">&nbsp;<input type="hidden"
                                                                                                   class="href"
                                                                                                   value="{$Href}"/><input
        type="hidden" class="start" value="{$Slot->BeginDate()->Format('Y-m-d H:i:s')|escape:url}"/><input type="hidden"
                                                                                                           class="end"
                                                                                                           value="{$Slot->EndDate()->Format('Y-m-d H:i:s')|escape:url}"/>
</td>{/function}

{function name=displayReserved}
	{if $Slot->IsPending()}
		{assign var=class value='pending'}
	{/if}
<td rowspan="{$Slot->PeriodSpan()}" class="reserved {$class} clickres slot" resid="{$Slot->Id()}"
    id="{$Slot->Id()}|{$Slot->Date()->Format('Ymd')}">{$Slot->Label()}</td>
{/function}

{function name=displayRestricted}
<td rowspan="{$Slot->PeriodSpan()}" class="restricted slot">&nbsp;</td>
{/function}

{function name=displayUnreservable}
<td rowspan="{$Slot->PeriodSpan()}" class="unreservable slot">{$Slot->Label()}</td>
{/function}

{function name=displaySlot}
	{call name=$DisplaySlotFactory->GetFunction($Slot, $AccessAllowed) Slot=$Slot Href=$Href SlotRef=$SlotRef}
{/function}

{* End slot display formatting *}

{block name="header"}
{include file='globalheader.tpl' cssFiles='css/schedule.css,css/jquery.qtip.min.css'}
{/block}

<div id="defaultSetMessage" class="success hidden">
{translate key=DefaultScheduleSet}
</div>
{block name="schedule_control"}
<div>
    <div class="schedule_title">
        <span>{$ScheduleName}</span>
		{if $Schedules|@count gt 0}
            <ul class="schedule_drop">
                <li id="show_schedule">{html_image src="down_sm_blue.png" alt="Change Schedule"}</li>
                <ul style="display:none;" id="schedule_list">
					{foreach from=$Schedules item=schedule}
                        <li><a href="#"
                               onclick="ChangeSchedule({$schedule->GetId()}); return false;">{$schedule->GetName()}</a>
                        </li>
					{/foreach}
                </ul>
            </ul>
		{/if}
        <a href="#" id="calendar_toggle">{html_image src="calendar.png" altKey="ShowHideNavigation"}</a>
        <a href="#" id="make_default"
           style="display:none;">{html_image src="tick-white.png" altKey="MakeDefaultSchedule"}</a>
    </div>

	{capture name="date_navigation"}
        <div class="schedule_dates">
			{assign var=FirstDate value=$DisplayDates->GetBegin()}
			{assign var=LastDate value=$DisplayDates->GetEnd()}
            <a href="#" onclick="ChangeDate({formatdate date=$PreviousDate format="Y, m, d"}); return false;"><img
                    src="img/arrow_large_left.png" alt="Back"/></a>
			{formatdate date=$FirstDate} - {formatdate date=$LastDate}
            <a href="#" onclick="ChangeDate({formatdate date=$NextDate format="Y, m, d"}); return false;"><img
                    src="img/arrow_large_right.png" alt="Forward"/></a>

			{if $ShowFullWeekLink}
                <a href="{add_querystring key=SHOW_FULL_WEEK value=1}" id="showFullWeek">({translate key=ShowFullWeek}
                    )</a>
			{/if}
        </div>
	{/capture}

	{$smarty.capture.date_navigation}
</div>

<div type="text" id="datepicker" style="display:none;"></div>

{/block}

<div style="text-align: center; margin: auto;">
    <div class="legend reservable">{translate key=Reservable}</div>
    <div class="legend unreservable">{translate key=Unreservable}</div>
    <div class="legend reserved">{translate key=Reserved}</div>
    <div class="legend reserved mine">{translate key=MyReservation}</div>
    <div class="legend reserved pending">{translate key=Pending}</div>
    <div class="legend pasttime">{translate key=Past}</div>
    <div class="legend restricted">{translate key=Restricted}</div>
</div>

<div style="height:10px">&nbsp;</div>

{block name="reservations"}

	{assign var=TodaysDate value=Date::Now()}
<div id="reservations">
    <table class="reservations" border="1" cellpadding="0" width="100%">
        <tr>
            <td>&nbsp</td>
			{foreach from=$Resources item=resource name=resource_loop}
				{assign var=resourceId value=$resource->Id}
				{assign var=href value="{Pages::RESERVATION}?rid={$resource->Id}&sid={$ScheduleId}"}

                <td class="resourcename" resourceId="{$resource->Id}">
					{if $resource->CanAccess}
                        <a href="{$href}" resourceId="{$resource->Id}"
                           class="resourceNameSelector">{$resource->Name}</a>
						{else}
						{$resource->Name}
					{/if}
                </td>
			{/foreach}
        </tr>

		{foreach from=$BoundDates item=date}
			{if $TodaysDate->DateEquals($date)}
                <tr class="today">{else}
            <tr>{/if}

            <td class="resdate" colspan="{$Resources|@count+1}">{formatdate date=$date key="schedule_daily"}</td></tr>
			{foreach from=$DailyLayout->GetPeriods($date) item=period name=period_loop}
                <tr class="slots" id="{$period->BeginDate()->Timestamp()}">
                    <td class="reslabel">{$period->Label()}</td>
                </tr>
			{/foreach}
		{/foreach}
    </table>
</div>

<input type="hidden" value="{$ScheduleId}" id="scheduleId"/>

{/block}

{$smarty.capture.date_navigation}

{block name="scripts"}

<script type="text/javascript" src="{$Path}scripts/js/jquery.qtip.min.js"></script>
<script type="text/javascript" src="{$Path}scripts/schedule.js"></script>
<script type="text/javascript" src="{$Path}scripts/resourcePopup.js"></script>

<script type="text/javascript">

    $(document).ready(function ()
    {
        var scheduleOpts = {
            reservationUrlTemplate:"{$Path}{Pages::RESERVATION}?{QueryStringKeys::REFERENCE_NUMBER}=[referenceNumber]",
            summaryPopupUrl:"{$Path}ajax/respopup.php",
            setDefaultScheduleUrl:"{$Path}{Pages::PROFILE}?action=changeDefaultSchedule&{QueryStringKeys::SCHEDULE_ID}=[scheduleId]"
        };

        var table = $('#reservations table');
		{foreach from=$Resources item=resource name=resource_loop}
			{foreach from=$BoundDates item=date}
				{assign var=resourceId value=$resource->Id}
				{assign var=slots value=$DailyLayout->GetLayout($date, $resourceId)}
				{assign var=href value="{Pages::RESERVATION}?rid={$resource->Id}&sid={$ScheduleId}&rd={formatdate date=$date key=url}"}

				{foreach from=$slots item=slot name=slot_loop}
					{assign var=slotRef value="{$slot->BeginDate()->Format('YmdHis')}{$resourceId}"}
                    var tr = $('#' +{$slot->BeginDate()->Timestamp()});
                    var td = tr.find('td:last');
					{capture assign="slotContent"}
						{displaySlot Slot=$slot Href="$href" AccessAllowed=$resource->CanAccess SlotRef=$slotRef}
					{/capture}
                    td.after('{$slotContent|trim|regex_replace:"/[\r\t\n]/":" "}');
				{/foreach}
			{/foreach}
		{/foreach}

        var schedule = new Schedule(scheduleOpts);
        schedule.init();
    })
</script>

{/block}

{control type="DatePickerSetupControl"
ControlId='datepicker'
DefaultDate=$FirstDate
NumberOfMonths='3'
ShowButtonPanel='true'
OnSelect='dpDateChanged'
FirstDay=$FirstWeekday}

{include file='globalfooter.tpl'}