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

{extends file="Schedule/schedule.tpl"}

{block name="reservations"}

{assign var=TodaysDate value=Date::Now()}
<div id="reservations">
    <table class="reservations" border="1" cellpadding="0" width="100%">
		{capture name="resources"}
            <tr>
                <td>&nbsp;</td>
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
		{/capture}

		{foreach from=$BoundDates item=date}
			{$smarty.capture.resources}
			{if $TodaysDate->DateEquals($date)}
                <tr class="today">
			{else}
            	<tr>
			{/if}
			<td class="resdate" colspan="{$Resources|@count+1}">{formatdate date=$date key="schedule_daily"}</td></tr>
			{foreach from=$DailyLayout->GetPeriods($date) item=period name=period_loop}
                <tr class="slots" id="{$period->Id()}">
                    <td class="reslabel">{$period->Label($date)}</td>
                </tr>
			{/foreach}
		{/foreach}
    </table>
</div>

{/block}

{block name="scripts"}

<script type="text/javascript">

    $(document).ready(function ()
    {
        var table = $('#reservations').find('table');
		var rows = new Object();
		{foreach from=$Resources item=resource name=resource_loop}
			{foreach from=$BoundDates item=date}
				{assign var=resourceId value=$resource->Id}
				{assign var=slots value=$DailyLayout->GetLayout($date, $resourceId)}
				{assign var=href value="{Pages::RESERVATION}?rid={$resource->Id}&sid={$ScheduleId}&rd={formatdate date=$date key=url}"}

				{foreach from=$slots item=slot name=slot_loop}
					{assign var=slotRef value="{$slot->BeginDate()->Format('YmdHis')}{$resourceId}"}
					{capture assign="slotContent"}
						{displaySlot Slot=$slot Href="$href" AccessAllowed=$resource->CanAccess SlotRef=$slotRef spantype='row'}
					{/capture}
					if (!rows['#{$slot->BeginSlotId()}'])
					{
						rows['#{$slot->BeginSlotId()}'] = [];
                    }
					rows['#{$slot->BeginSlotId()}'].push('{$slotContent|trim|regex_replace:"/[\r\t\n]/":" "}');
				{/foreach}
			{/foreach}
		{/foreach}

		$.each(rows, function(index, item)
		{
			$(index).find('td:last').after(item.join(''));
        });
    })
</script>

{/block}