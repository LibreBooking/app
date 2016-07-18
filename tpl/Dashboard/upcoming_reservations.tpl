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
	<div class="reservation row" id="{$reservation->ReferenceNumber}">
		<div class="col-sm-3 col-xs-12">{$reservation->Title|default:$DefaultTitle}</div>
		<div class="col-sm-2 col-xs-12">{fullname first=$reservation->FirstName last=$reservation->LastName ignorePrivacy=$reservation->IsUserOwner($UserId)} {if !$reservation->IsUserOwner($UserId)}{html_image src="users.png" altKey=Participant}{/if}</div>
		<div class="col-sm-2 col-xs-6">{formatdate date=$reservation->StartDate->ToTimezone($Timezone) key=dashboard}</div>
		<div class="col-sm-2 col-xs-6">{formatdate date=$reservation->EndDate->ToTimezone($Timezone) key=dashboard}</div>
		<div class="col-sm-3 col-xs-12">{$reservation->ResourceName}</div>
	</div>
    <div class="clearfix"></div>
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
			<div>
				<div class="timespan">
					{translate key="Today"} ({$TodaysReservations|count})
				</div>
				{foreach from=$TodaysReservations item=reservation}
					{displayReservation reservation=$reservation}
				{/foreach}

				<div class="timespan">
					{translate key="Tomorrow"} ({$TomorrowsReservations|count})
				</div>
				{foreach from=$TomorrowsReservations item=reservation}
					{displayReservation reservation=$reservation}
				{/foreach}

				<div class="timespan">
					{translate key="LaterThisWeek"} ({$ThisWeeksReservations|count})
				</div>
				{foreach from=$ThisWeeksReservations item=reservation}
					{displayReservation reservation=$reservation}
				{/foreach}

				<div class="timespan">
					{translate key="NextWeek"} ({$NextWeeksReservations|count})
				</div>
				{foreach from=$NextWeeksReservations item=reservation}
					{displayReservation reservation=$reservation}
				{/foreach}
			</div>
		{else}
			<div class="noresults">{translate key="NoUpcomingReservations"}</div>
		{/if}
	</div>
</div>
