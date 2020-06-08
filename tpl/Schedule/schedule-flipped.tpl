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

{function name=displaySlotTall}
    {call name=$DisplaySlotFactory->GetFunction($Slot, $AccessAllowed) Slot=$Slot Href=$Href SlotRef=$SlotRef ResourceId=$ResourceId}
{/function}

{extends file="Schedule/schedule.tpl"}


{block name="reservations"}

    {assign var=TodaysDate value=Date::Now()}

    {capture name="resources"}
		<tr>
			<td class="resourcename">&nbsp;</td>
            {foreach from=$Resources item=resource name=resource_loop}
                {assign var=resourceId value=$resource->Id}
                {assign var=href value="{Pages::RESERVATION}?rid={$resource->Id}&sid={$ScheduleId}"}
				<td class="resourcename" resourceId="{$resource->Id}"
                    {if $resource->HasColor()}style="background-color:{$resource->GetColor()} !important"{/if}>
                    {if $resource->CanAccess}
						<span resourceId="{$resourceId}" class="visible-sm-inline-block hidden-md resourceNameSelector fa fa-info-circle" data-show-event="click"
						                              {if $resource->HasColor()}style="color:{$resource->GetTextColor()} !important"{/if}></span>
						<a href="{$href}" resourceId="{$resourceId}"
						   class="resourceNameSelector"
                           {if $resource->HasColor()}style="color:{$resource->GetTextColor()} !important"{/if}>{$resource->Name}</a>

                    {else}
						<span resourceId="{$resourceId}" class="resourceNameSelector"
                              {if $resource->HasColor()}style="color:{$resource->GetTextColor()} !important"{/if}>{$resource->Name}</span>
                    {/if}
				</td>
            {/foreach}
		</tr>
    {/capture}

    {foreach from=$BoundDates item=date}
        {assign var=ts value=$date->Timestamp()}
        {$periods.$ts = $DailyLayout->GetPeriods($date, false)}
        {assign var=count value=$periods[$ts]|count}
        {if $count== 0}{continue}{*dont show if there are no slots*}{/if}
        {assign var=min value=$periods[$ts][0]->BeginDate()->TimeStamp()}
        {assign var=max value=$periods[$ts][$count-1]->EndDate()->TimeStamp()}
		<table class="reservations" border="1" cellpadding="0" width="100%" data-min="{$min}" data-max="{$max}">
			<thead>
            {if $date->DateEquals($TodaysDate)}
				<tr class="today">
                    {else}
			<tr>
                {/if}
				<td class="resdate" colspan="{$Resources|@count+1}">{formatdate date=$date key="schedule_daily"}</td>
			</tr>
            {$smarty.capture.resources}
			</thead>
			<tbody>
			<!-- tall -->
            {foreach from=$periods.$ts item=period name=period_loop}
				<tr class="slots" id="{$period->Id()}">
					<td class="reslabel">{$period->Label($date)}</td>
                    {foreach from=$Resources item=resource name=resource_loop}
                        {assign var=resourceId value=$resource->Id}
                        {assign var=slotRef value="{$period->BeginDate()->Format('YmdHis')}{$resourceId}"}
                        {assign var=slotHref value="{$CreateReservationPage}?rid={$resourceId}&sid={$ScheduleId}&rd={formatdate date=$date key=url}"}
                        {displaySlotTall Slot=$period Href=$slotHref AccessAllowed=$resource->CanAccess SlotRef=$slotRef ResourceId=$resourceId}
                    {/foreach}
				</tr>
            {/foreach}
			</tbody>
            {$smarty.capture.resources}
		</table>
    {/foreach}

{/block}

{block name="scripts-before"}
{/block}