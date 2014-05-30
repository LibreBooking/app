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
	<table class="reservations" border="1" cellpadding="0" style="width:100%;">

		{foreach from=$BoundDates item=date}
			<tr>
				{assign var=class value=""}
				{if $TodaysDate->DateEquals($date) eq true}
					{assign var=class value="today today-custom"}
				{/if}
				<td class="resdate resdate-custom {$class}" colspan="{$Resources|count+1}">{formatdate date=$date key="schedule_daily"}</td>
			</tr>
			{foreach from=$Resources item=resource name=resource_loop}
				<tr>
					{assign var=resourceId value=$resource->Id}
					{assign var=href value="{Pages::RESERVATION}?rid={$resourceId}&sid={$ScheduleId}"}

					<td class="resourcename">
						{if $resource->CanAccess}
							<a href="{$href}" resourceId="{$resourceId}">{$resource->Name}</a>
							<span class="resourceNameSelector glyphicon glyphicon-new-window"></span>
						{else}
							{$resource->Name}
						{/if}
					</td>

					{assign var=summary value=$DailyLayout->GetSummary($date, $resourceId)}
					{if $summary->NumberOfReservations() > 0}
						<td class="slot">
							{foreach from=$summary->Reservations() item=reservation}
								<div>
									<a href="{$Path}reservation.php?rn={$reservation->ReferenceNumber()}">
									{if $date->DateEquals($reservation->StartDate())}
										{format_date date=$reservation->StartDate() key=period_time}
									{else}
										{format_date date=$reservation->StartDate() key=mobile_reservation_date}
									{/if}
										-
									{if $date->DateEquals($reservation->EndDate())}
										{format_date date=$reservation->EndDate() key=period_time}
									{else}
										{format_date date=$reservation->EndDate() key=mobile_reservation_date}

									{/if}
									</a>
								</div>
							{/foreach}
						</td>
					{else}
						{assign var=href value="{Pages::RESERVATION}?rid={$resource->Id}&sid={$ScheduleId}&rd={formatdate date=$date key=url}"}
						<td class="reservable clickres slot" ref="{$href}">
							&nbsp;
							<input type="hidden" class="href" value="{$href}"/>
						</td>
					{/if}
				</tr>
			{/foreach}
		{/foreach}
	</table>
{/block}

{block name="scripts-before"}
{/block}