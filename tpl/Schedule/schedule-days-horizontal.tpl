{*
Copyright 2011-2020 Nick Korbel

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

{function name=displaySlot}
    {call name=$DisplaySlotFactory->GetFunction($Slot, $AccessAllowed) Slot=$Slot Href=$Href SlotRef=$SlotRef ResourceId=$ResourceId}
{/function}

{block name="reservations"}
    {assign var=TodaysDate value=Date::Now()}
    <table class="reservations" border="1" cellpadding="0" style="width:auto;" data-min="0" data-max="999999999999999">
        <thead>
        <tr>
            <td rowspan="2">&nbsp;</td>
            {foreach from=$BoundDates item=date}
                {assign var=class value=""}
                {assign var=ts value=$date->Timestamp()}
                {$periods.$ts = $DailyLayout->GetPeriods($date, false)}
                {$slots.$ts = $DailyLayout->GetPeriods($date, false)}
                {if $periods[$ts]|count == 0}{continue}{*dont show if there are no slots*}{/if}
                {if $date->DateEquals($TodaysDate)}
                    {assign var=class value="today"}
                {/if}
                <td class="resdate {$class}"
                    colspan="{$periods[$ts]|count}">{formatdate date=$date key="schedule_daily"}</td>
            {/foreach}
        </tr>
        <tr>
            {foreach from=$BoundDates item=date}
                {assign var=ts value=$date->Timestamp()}
                {assign var=datePeriods value=$periods[$ts]}
                {foreach from=$datePeriods item=period}
                    <td class="reslabel" colspan="{$period->Span()}">{$period->Label($date)}</td>
                {/foreach}
            {/foreach}
        </tr>
        </thead>
        <tbody>

        {foreach from=$Resources item=resource name=resource_loop}
            {assign var=resourceId value=$resource->Id}
            {assign var=href value="{Pages::RESERVATION}?rid={$resource->Id}&sid={$ScheduleId}"}
            <tr class="slots">
                <td class="resourcename"
                    {if $resource->HasColor()}style="background-color:{$resource->GetColor()} !important"{/if}>
                    {if $resource->CanAccess}
                        <a href="{$href}" resourceId="{$resource->Id}"
                           class="resourceNameSelector"
                           {if $resource->HasColor()}style="color:{$resource->GetTextColor()} !important"{/if}>{$resource->Name}</a>
                    {else}
                        <span resourceId="{$resourceId}" resourceId="{$resourceId}" class="resourceNameSelector"
                              {if $resource->HasColor()}style="color:{$resource->GetTextColor()} !important"{/if}>{$resource->Name}</span>
                    {/if}
                </td>
                {foreach from=$BoundDates item=date}
                    {assign var=ts value=$date->Timestamp()}
                    {foreach from=$slots.$ts item=Slot}
                        {assign var=href value="{Pages::RESERVATION}?rid={$resource->Id}&sid={$ScheduleId}&rd={formatdate date=$date key=url}"}
                        {assign var=slotRef value="{$Slot->BeginDate()->Format('YmdHis')}{$resourceId}"}
                        {displaySlot Slot=$Slot Href="$href" AccessAllowed=$resource->CanAccess SlotRef=$slotRef ResourceId=$resourceId}
                    {/foreach}
                {/foreach}
            </tr>
        {/foreach}
        </tbody>
    </table>
{/block}

{block name="scripts-before"}

{/block}