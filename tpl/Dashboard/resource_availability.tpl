{*
Copyright 2017 Nick Korbel

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

<div class="dashboard dashboard availabilityDashboard" id="availabilityDashboard">
	<div class="dashboardHeader">
		<div class="pull-left">{translate key="ResourceAvailability"}</div>
		<div class="pull-right">
			<a href="#" title="{translate key=ShowHide} {translate key="ResourceAvailability"}">
				<i class="glyphicon"></i>
			</a>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="dashboardContents">
		<div class="header">{translate key=Available}</div>
		{foreach from=$Schedules item=s}
			<h5>{$s->GetName()}</h5>
			{foreach from=$Available[$s->GetId()] item=i}
				<div class="availabilityItem">
					<div class="col-xs-12 col-sm-5">
						<i resource-id="{$i->ResourceId()}" class="resourceNameSelector fa fa-info-circle"></i>
						<div class="resourceName" style="background-color:{$i->GetColor()}">
							<a href="{$Path}{Pages::RESERVATION}?{QueryStringKeys::RESOURCE_ID}={$i->ResourceId()}" resource-id="{$i->ResourceId()}"
							   class="resourceNameSelector" style="color:{$i->GetTextColor()}">{$i->ResourceName()}</a>
						</div>
					</div>
					<div class="availability col-xs-12 col-sm-4">
						{if $i->NextTime() != null}
							{translate key=AvailableUntil}
							{format_date date=$i->NextTime() timezone=$Timezone key=dashboard}
						{else}
							<span class="no-data">{translate key=AllNoUpcomingReservations args=30}</span>
						{/if}
					</div>
					<div class="reserveButton col-xs-12 col-sm-3">
						<a class="btn btn-xs col-xs-12"
						   href="{$Path}{Pages::RESERVATION}?{QueryStringKeys::RESOURCE_ID}={$i->ResourceId()}">{translate key=Reserve}</a>
					</div>
				</div>
				<div class="clearfix"></div>
				{foreachelse}
				<div class="no-data">{translate key=None}</div>
			{/foreach}
		{/foreach}

		<div class="header">{translate key=Unavailable}</div>

		{foreach from=$Schedules item=s}
			<h5>{$s->GetName()}</h5>
			{foreach from=$Unavailable[$s->GetId()] item=i}
				<div class="availabilityItem">
					<div class="col-xs-12 col-sm-5">
						<i resource-id="{$i->ResourceId()}" class="resourceNameSelector fa fa-info-circle"></i>
						<div class="resourceName" style="background-color:{$i->GetColor()}">
							<a href="{$Path}{Pages::RESERVATION}?{QueryStringKeys::RESOURCE_ID}={$i->ResourceId()}" resource-id="{$i->ResourceId()}"
							   class="resourceNameSelector" style="color:{$i->GetTextColor()}">{$i->ResourceName()}</a>
						</div>
					</div>
					<div class="availability col-xs-12 col-sm-4">
						{translate key=AvailableBeginningAt} {format_date date=$i->ReservationEnds() timezone=$Timezone key=dashboard}
					</div>
					<div class="reserveButton col-xs-12 col-sm-3">
						<a class="btn btn-xs col-xs-12"
						   href="{$Path}{Pages::RESERVATION}?{QueryStringKeys::RESOURCE_ID}={$i->ResourceId()}&{QueryStringKeys::START_DATE}={format_date date=$i->ReservationEnds() timezone=$Timezone key=url_full}">{translate key=Reserve}</a>
					</div>
				</div>
                <div class="clearfix"></div>
				{foreachelse}
				<div class="no-data">{translate key=None}</div>
			{/foreach}
		{/foreach}

		<div class="header">{translate key=UnavailableAllDay}</div>
		{foreach from=$Schedules item=s}
			<h5>{$s->GetName()}</h5>
			{foreach from=$UnavailableAllDay[$s->GetId()] item=i}
				<div class="availabilityItem">
					<div class="col-xs-12 col-sm-5">
						<i resource-id="{$i->ResourceId()}" class="resourceNameSelector fa fa-info-circle"></i>
						<div class="resourceName" style="background-color:{$i->GetColor()}">
							<a href="{$Path}{Pages::RESERVATION}?{QueryStringKeys::RESOURCE_ID}={$i->ResourceId()}" resource-id="{$i->ResourceId()}"
							   class="resourceNameSelector" style="color:{$i->GetTextColor()}">{$i->ResourceName()}</a>
						</div>
					</div>
					<div class="availability col-xs-12 col-sm-4">
						Available At {format_date date=$i->ReservationEnds() timezone=$Timezone key=dashboard}
					</div>
					<div class="reserveButton col-xs-12 col-sm-3">
						<a class="btn btn-xs col-xs-12"
						   href="{$Path}{Pages::RESERVATION}?{QueryStringKeys::RESOURCE_ID}={$i->ResourceId()}&{QueryStringKeys::START_DATE}={format_date date=$i->ReservationEnds() timezone=$Timezone key=url_full}">{translate key=Reserve}</a>
					</div>
				</div>
                <div class="clearfix"></div>
				{foreachelse}
				<div class="no-data">{translate key=None}</div>
			{/foreach}
		{/foreach}
	</div>
</div>