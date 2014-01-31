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

{block name="legend"}{/block}

{block name="reservations"}
	{assign var=TodaysDate value=Date::Now()}
	<div id="reservations">
		<table class="reservations" border="1" cellpadding="0" style="width:auto;">
			<tr>
				<td>&nbsp;</td>
				{foreach from=$BoundDates item=date}
					{assign var=class value=""}
					{if $TodaysDate->DateEquals($date) eq true}
						{assign var=class value="today-custom"}
					{/if}
					<td class="resdate-custom resdate {$class}">{formatdate date=$date key="schedule_daily"}</td>
				{/foreach}
			</tr>

			{foreach from=$Resources item=resource name=resource_loop}
				{assign var=resourceId value=$resource->Id}
				{assign var=href value="{Pages::RESERVATION}?rid={$resourceId}&sid={$ScheduleId}"}
				<tr class="slots">
					<td class="resourcename">
						{if $resource->CanAccess}
							<a href="{$href}" resourceId="{$resourceId}"
							   class="resourceNameSelector">{$resource->Name}</a>
						{else}
							{$resource->Name}
						{/if}
					</td>
					{foreach from=$BoundDates item=date}
						{assign var=summary value=$DailyLayout->GetSummary($date, $resourceId)}
						{if $summary->NumberOfReservations() > 0}
							<td class="reserved clickres slot" date="{formatdate date=$date key=url}" resourceId="{$resourceId}" resid="{$summary->FirstReservation()->ReferenceNumber()}">
								{$summary->NumberOfReservations()} {if $summary->NumberOfReservations()==1}{translate key=reservation}{else}{translate key=reservations}{/if}
							</td>
						{else}
							{assign var=href value="{Pages::RESERVATION}?rid={$resource->Id}&sid={$ScheduleId}&rd={formatdate date=$date key=url}"}
							<td class="reservable clickres slot" ref="{$href}">
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