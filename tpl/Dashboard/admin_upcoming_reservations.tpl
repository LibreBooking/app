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
                    {translate key="Today"} ({$TodaysReservations|default:array()|count})
                </div>
                {foreach from=$TodaysReservations item=reservation}
                    {include file='Dashboard/dashboard_reservation.tpl' reservation=$reservation}
                {/foreach}

                <div class="timespan">
                    {translate key="Tomorrow"} ({$TomorrowsReservations|default:array()|count})
                </div>
                {foreach from=$TomorrowsReservations item=reservation}
                    {include file='Dashboard/dashboard_reservation.tpl' reservation=$reservation}
                {/foreach}

                <div class="timespan">
                    {translate key="LaterThisWeek"} ({$ThisWeeksReservations|default:array()|count})
                </div>
                {foreach from=$ThisWeeksReservations item=reservation}
                    {include file='Dashboard/dashboard_reservation.tpl' reservation=$reservation}
                {/foreach}

                <div class="timespan">
                    {translate key="NextWeek"} ({$NextWeeksReservations|default:array()|count})
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
