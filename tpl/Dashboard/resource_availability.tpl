{*
Copyright 2015 Nick Korbel

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

<div class="dashboard availabilityDashboard" id="availabilityDashboard">
	<div class="dashboardHeader">
		<a href="javascript:void(0);" title="{translate key='ShowHide'}">{translate key="ResourceAvailability"}</a>
	</div>
	<div class="dashboardContents">
		<div class="header">{translate key=Available}</div>
		{foreach from=$Available item=i}
			<div class="availabilityItem">
				<div class="resourceName">
					<a href="#" resource-id="{$i->ResourceId()}" class="resourceNameSelector">{$i->ResourceName()}</a>
				</div>
				<div class="availability">

					{if $i->NextTime() != null}
						{translate key=AvailableUntil}
						{format_date date=$i->NextTime() timezone=$Timezone key=dashboard}
					{else}
						<span class="no-data">{translate key=AllNoUpcomingReservations}</span>
					{/if}
				</div>
				<div class="inline">
					<a href="{$Path}{Pages::RESERVATION}?{QueryStringKeys::RESOURCE_ID}={$i->ResourceId()}">{translate key=CreateReservation}</a>
				</div>
			</div>
			{foreachelse}
			<div class="no-data">{translate key=None}</div>
		{/foreach}

		<div class="header">{translate key=Unavailable}</div>
		{foreach from=$Unavailable item=i}
			<div class="availabilityItem">
				<div class="resourceName">
					<a href="#" resource-id="{$i->ResourceId()}" class="resourceNameSelector">{$i->ResourceName()}</a>
				</div>
				<div class="availability">
					{translate key=AvailableBeginningAt} {format_date date=$i->ReservationEnds() timezone=$Timezone key=dashboard}
				</div>
				<div class="inline">
					<a href="{$Path}{Pages::RESERVATION}?{QueryStringKeys::RESOURCE_ID}={$i->ResourceId()}&{QueryStringKeys::START_DATE}={format_date date=$i->ReservationEnds() timezone=$Timezone key=url_full}">{translate key=CreateReservation}</a>
				</div>
			</div>
			{foreachelse}
			<div class="no-data">{translate key=None}</div>
		{/foreach}

		<div class="header">{translate key=UnavailableAllDay}</div>
		{foreach from=$UnavailableAllDay item=i}
			<div class="availabilityItem">
				<div class="resourceName">
					<a href="#" resource-id="{$i->ResourceId()}" class="resourceNameSelector">{$i->ResourceName()}</a>
				</div>
				<div class="availability">
					Available At {format_date date=$i->ReservationEnds() timezone=$Timezone key=dashboard}
				</div>
				<div class="inline">
					<a href="{$Path}{Pages::RESERVATION}?{QueryStringKeys::RESOURCE_ID}={$i->ResourceId()}&{QueryStringKeys::START_DATE}={format_date date=$i->ReservationEnds() timezone=$Timezone key=url_full}">{translate key=CreateReservation}</a>
				</div>
			</div>
			{foreachelse}
			<div class="no-data">{translate key=None}</div>
		{/foreach}
	</div>
</div>