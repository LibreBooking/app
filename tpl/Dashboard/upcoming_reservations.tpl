{*
Copyright 2011-2015 Nick Korbel

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

{function name=displayReservation}
	<tr class="reservation" id="{$reservation->ReferenceNumber}">
		<td>{$reservation->Title|default:$DefaultTitle}</td>
		<td>{fullname first=$reservation->FirstName last=$reservation->LastName ignorePrivacy=$reservation->IsUserOwner($UserId)} {if !$reservation->IsUserOwner($UserId)}{html_image src="users.png" altKey=Participant}{/if}</td>
		<td>{formatdate date=$reservation->StartDate->ToTimezone($Timezone) key=dashboard}</td>
		<td>{formatdate date=$reservation->EndDate->ToTimezone($Timezone) key=dashboard}</td>
		<td>{$reservation->ResourceName}</td>
	</tr>
{/function}


<div class="dashboard upcomingReservationsDashboard" id="upcomingReservationsDashboard">
	<div class="dashboardHeader">
		<div class="pull-left">{translate key="UpcomingReservations"} <span class="badge">{$Total}</span></div>
		<div class="pull-right">
			<a href="#" title="{translate key=ShowHide} {translate key="UpcomingReservations"}">
				<i class="glyphicon"></i>
			</a>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="dashboardContents">
		{assign var=colspan value="5"}
		{if $Total > 0}
			<table class="table">
				<tr class="timespan">
					<td colspan="{$colspan}">{translate key="Today"} ({$TodaysReservations|count})</td>
				</tr>
				{foreach from=$TodaysReservations item=reservation}
					{displayReservation reservation=$reservation}
				{/foreach}

				<tr class="timespan">
					<td colspan="{$colspan}">{translate key="Tomorrow"} ({$TomorrowsReservations|count})</td>
				</tr>
				{foreach from=$TomorrowsReservations item=reservation}
					{displayReservation reservation=$reservation}
				{/foreach}

				<tr class="timespan">
					<td colspan="{$colspan}">{translate key="LaterThisWeek"} ({$ThisWeeksReservations|count})</td>
				</tr>
				{foreach from=$ThisWeeksReservations item=reservation}
					{displayReservation reservation=$reservation}
				{/foreach}

				<tr class="timespan">
					<td colspan="{$colspan}">{translate key="NextWeek"} ({$NextWeeksReservations|count})</td>
				</tr>
				{foreach from=$NextWeeksReservations item=reservation}
					{displayReservation reservation=$reservation}
				{/foreach}
			</table>
		{else}
			<div class="noresults">{translate key="NoUpcomingReservations"}</div>
		{/if}
	</div>
</div>
