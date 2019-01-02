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

<div class="dashboard upcomingReservationsDashboard" id="adminUpcomingReservationsDashboard">
    <div class="dashboardHeader">
        <div class="pull-left">{translate key="AllUpcomingReservations"} <span class="badge">{$Total}</span></div>
        <div class="pull-right">
            <a href="#" title="{translate key=ShowHide} {translate key="AllUpcomingReservations"}">
                <i class="glyphicon"></i>
                <span class="no-show">Expand/Collapse</span>
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
                    {include file='Dashboard/dashboard_reservation.tpl' reservation=$reservation}
                {/foreach}

                <div class="timespan">
                    {translate key="Tomorrow"} ({$TomorrowsReservations|count})
                </div>
                {foreach from=$TomorrowsReservations item=reservation}
                    {include file='Dashboard/dashboard_reservation.tpl' reservation=$reservation}
                {/foreach}

                <div class="timespan">
                    {translate key="LaterThisWeek"} ({$ThisWeeksReservations|count})
                </div>
                {foreach from=$ThisWeeksReservations item=reservation}
                    {include file='Dashboard/dashboard_reservation.tpl' reservation=$reservation}
                {/foreach}

                <div class="timespan">
                    {translate key="NextWeek"} ({$NextWeeksReservations|count})
                </div>
                {foreach from=$NextWeeksReservations item=reservation}
                    {include file='Dashboard/dashboard_reservation.tpl' reservation=$reservation}
                {/foreach}
            </div>
        {else}
            <div class="noresults">{translate key="AllNoUpcomingReservations"}</div>
        {/if}
    </div>
</div>
