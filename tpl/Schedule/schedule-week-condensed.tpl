{*
Copyright 2011-2017 Nick Korbel

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

{block name="legend"}{/block}

{block name="reservations"}

{function name=displayGeneralReservedCondensed}
	{if $Slot->IsPending()}
		{assign var=class value='pending'}
	{/if}
	{if $Slot->HasCustomColor()}
		{assign var=color value='style="background-color:'|cat:$Slot->Color()|cat:' !important;color:'|cat:$Slot->TextColor()|cat:' !important;"'}
	{/if}
	<div class="reserved {$class} {$OwnershipClass} clickres"
		resid="{$Slot->Id()}" {$color}
		id="{$Slot->Id()}|{$Slot->Date()->Format('Ymd')}">
		{formatdate date=$Slot->BeginDate() key=period_time} - {formatdate date=$Slot->EndDate() key=period_time}
		{$Slot->Label($SlotLabelFactory)|escapequotes}</div>
{/function}

{function name=displayMyReservedCondensed}
	{call name=displayGeneralReservedCondensed Slot=$Slot Href=$Href OwnershipClass='mine'}
{/function}

{function name=displayMyParticipatingCondensed}
	{call name=displayGeneralReservedCondensed Slot=$Slot Href=$Href OwnershipClass='participating'}
{/function}

{function name=displayReservedCondensed}
	{call name=displayGeneralReservedCondensed Slot=$Slot Href=$Href OwnershipClass=''}
{/function}

{function name=displayPastTimeCondensed}
	&nbsp;
{/function}

{function name=displayReservableCondensed}
	&nbsp;
{/function}

{function name=displayRestrictedCondensed}
	&nbsp;
{/function}

{function name=displayUnreservableCondensed}
	&nbsp;<div class="unreservable"
               resid="{$Slot->Id()}" {$color}
               id="{$Slot->Id()}|{$Slot->Date()->Format('Ymd')}">
    {formatdate date=$Slot->BeginDate() key=period_time} - {formatdate date=$Slot->EndDate() key=period_time}
    {$Slot->Label($SlotLabelFactory)|escapequotes}</div>
{/function}

{function name=displaySlotCondensed}
	{call name=$DisplaySlotFactory->GetFunction($Slot, $AccessAllowed, 'Condensed') Slot=$Slot Href=$Href}
{/function}

	{assign var=TodaysDate value=Date::Now()}
	<div id="reservations">
		<table class="reservations condensed" border="1" cellpadding="0" style="width:100%;">
			<tr>
				<td>&nbsp;</td>
				{foreach from=$BoundDates item=date}
					{assign var=class value=""}
					{assign var=ts value=$date->Timestamp()}
					{$periods.$ts = $DailyLayout->GetPeriods($date)}
					{if $periods[$ts]|count == 0}{continue}{*dont show if there are no slots*}{/if}
					{if $date->DateEquals($TodaysDate)}
						{assign var=class value="today"}
					{/if}
					<td class="resdate-custom resdate {$class}">{formatdate date=$date key="schedule_daily"}</td>
				{/foreach}
			</tr>

			{foreach from=$Resources item=resource name=resource_loop}
				{assign var=resourceId value=$resource->Id}
				{assign var=href value="{Pages::RESERVATION}?rid={$resourceId}&sid={$ScheduleId}"}
				<tr class="slots">
					<td class="resourcename" {if $resource->HasColor()}style="background-color:{$resource->GetColor()} !important{/if}>
						{if $resource->CanAccess}
							<a href="{$href}" resourceId="{$resourceId}"
							   class="resourceNameSelector" {if $resource->HasColor()}style="color:{$resource->GetTextColor()} !important"{/if}>{$resource->Name}</a>
						{else}
							<span resourceId="{$resource->Id}" resourceId="{$resource->Id}" class="resourceNameSelector" {if $resource->HasColor()}style="color:{$resource->GetTextColor()} !important"{/if}>{$resource->Name}</span>
						{/if}
					</td>
					{foreach from=$BoundDates item=date}
						{assign var=ts value=$date->Timestamp()}
						{if $periods[$ts]|count == 0}{continue}{*dont show if there are no slots*}{/if}
						{assign var=resourceId value=$resource->Id}
						{assign var=href value="{Pages::RESERVATION}?rid={$resourceId}&sid={$ScheduleId}"}
						{assign var=slots value=$DailyLayout->GetLayout($date, $resourceId)}
						{assign var=summary value=$DailyLayout->GetSummary($date, $resourceId)}
						{if $summary->NumberOfReservations() > 0}
							<td class="reservable clickres slot" ref="{$href}&rd={formatdate date=$date key=url}" data-href="{$href}" data-start="{$date->Format('Y-m-d H:i:s')|escape:url}" data-end="{$date->Format('Y-m-d H:i:s')|escape:url}">
								<input type="hidden" class="href" value="{$href}"/>
								{foreach from=$slots item=slot}
									{call name=displaySlotCondensed Slot=$slot Href="$href" AccessAllowed=$resource->CanAccess}
								{/foreach}
							</td>
						{else}
							{assign var=href value="{Pages::RESERVATION}?rid={$resource->Id}&sid={$ScheduleId}&rd={formatdate date=$date key=url}"}
							<td class="reservable clickres slot" ref="{$href}" data-href="{$href}" data-start="{$date->Format('Y-m-d H:i:s')|escape:url}" data-end="{$date->Format('Y-m-d H:i:s')|escape:url}">
								&nbsp;
								<input type="hidden" class="href" value="{$href}"/>
							</td>
						{/if}
					{/foreach}
				</tr>
			{/foreach}
		</table>
	</div>
{/block}

{block name="scripts"}
	<script type="text/javascript">
		$(document).ready(function ()
		{
			var $td = $('td.reserved', $('#reservations'));
			$td.unbind('click');

			$td.click(function (e)
			{
				e.stopPropagation();
				var date = $(this).attr('date').split('-');
				var year = date[0];
				var month = date[1];
				var day = date[2];
				var resourceId = $(this).attr('resourceId');

				window.location = "{Pages::CALENDAR}?{QueryStringKeys::CALENDAR_TYPE}=day&{QueryStringKeys::RESOURCE_ID}=" + resourceId + "&y=" + year + "&m=" + month + "&d=" + day;
			});
		});
	</script>
{/block}