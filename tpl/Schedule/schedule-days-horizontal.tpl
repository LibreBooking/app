{*
Copyright 2011-2019 Nick Korbel

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
		<table class="reservations" border="1" cellpadding="0" style="width:auto;">
			<tr>
				<td rowspan="2">&nbsp;</td>
				{foreach from=$BoundDates item=date}
					{assign var=class value=""}
					{assign var=ts value=$date->Timestamp()}
					{$periods.$ts = $DailyLayout->GetPeriods($date)}
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

			{foreach from=$Resources item=resource name=resource_loop}
				{assign var=resourceId value=$resource->Id}
				{assign var=href value="{Pages::RESERVATION}?rid={$resource->Id}&sid={$ScheduleId}"}
				<tr class="slots">
					<td class="resourcename" {if $resource->HasColor()}style="background-color:{$resource->GetColor()} !important"{/if}>
						{if $resource->CanAccess}
							<a href="{$href}" resourceId="{$resource->Id}"
							   class="resourceNameSelector" {if $resource->HasColor()}style="color:{$resource->GetTextColor()} !important"{/if}>{$resource->Name}</a>
						{else}
							<span resourceId="{$resourceId}" resourceId="{$resourceId}" class="resourceNameSelector" {if $resource->HasColor()}style="color:{$resource->GetTextColor()} !important"{/if}>{$resource->Name}</span>
						{/if}
					</td>
					{foreach from=$BoundDates item=date}
						{assign var=slots value=$DailyLayout->GetLayout($date, $resourceId)}
						{assign var=href value="{Pages::RESERVATION}?rid={$resource->Id}&sid={$ScheduleId}&rd={formatdate date=$date key=url}"}
						{foreach from=$slots item=slot}
							{assign var=slotRef value="{$slot->BeginDate()->Format('YmdHis')}{$resourceId}"}
							{call displaySlot Slot=$slot Href="$href" AccessAllowed=$resource->CanAccess SlotRef=$slotRef ResourceId=$resourceId}
						{/foreach}
					{/foreach}
				</tr>
			{/foreach}
		</table>
{/block}

{block name="scripts-before"}

{/block}