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
	<style type="text/css">
		td.resdate-custom { background-color:#4279A5; }
		td.today-custom { background-color:#5199d1; }
	</style>

	{assign var=TodaysDate value=Date::Now()}
	<div id="reservations">
		<table class="reservations" border="1" cellpadding="0" style="width:auto;">
			<tr>
				<td rowspan="2">&nbsp;</td>
				{foreach from=$BoundDates item=date}
					{assign var=class value=""}
					{if $TodaysDate->DateEquals($date) eq true}
						{assign var=class value="today-custom"}
					{/if}
					<td class="resdate-custom resdate {$class}"
						colspan="{$DailyLayout->GetPeriods($date)|count}">{formatdate date=$date key="schedule_daily"}</td>
				{/foreach}
			</tr>
			<tr>
				{foreach from=$BoundDates item=date}
					{foreach from=$DailyLayout->GetPeriods($date) item=period}
						<td class="reslabel" colspan="{$period->Span()}">{$period->Label($date)}</td>
					{/foreach}
				{/foreach}
			</tr>

			{foreach from=$Resources item=resource name=resource_loop}
				{assign var=resourceId value=$resource->Id}
				{assign var=href value="{Pages::RESERVATION}?rid={$resource->Id}&sid={$ScheduleId}"}
				<tr class="slots">
					<td class="resourcename">
						{if $resource->CanAccess}
							<a href="{$href}" resourceId="{$resource->Id}"
							   class="resourceNameSelector">{$resource->Name}</a>
						{else}
							{$resource->Name}
						{/if}
					</td>
					{foreach from=$BoundDates item=date}
						{assign var=slots value=$DailyLayout->GetLayout($date, $resourceId)}
						{assign var=href value="{Pages::RESERVATION}?rid={$resource->Id}&sid={$ScheduleId}&rd={formatdate date=$date key=url}"}
						{foreach from=$slots item=slot}
							{assign var=slotRef value="{$slot->BeginDate()->Format('YmdHis')}{$resourceId}"}
							{displaySlot Slot=$slot Href="$href" AccessAllowed=$resource->CanAccess SlotRef=$slotRef}
						{/foreach}
					{/foreach}
				</tr>
			{/foreach}
		</table>
	</div>
{/block}

{block name="scripts"}

{/block}