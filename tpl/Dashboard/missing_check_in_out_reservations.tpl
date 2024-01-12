<div class="dashboard upcomingReservationsDashboard" id="upcomingReservationsDashboard">
	<div class="dashboardHeader">
		<div class="pull-left">{translate key="MissingCheckOutReservations"}<span class="badge">{$Total}</span></div>
		<div class="pull-right">
			<a href="#" title="{translate key=ShowHide} {translate key="PastReservations"}">
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
                    {include file='Dashboard/dashboard_reservation.tpl' reservation=$reservation allowCheckin=$allowCheckin allowCheckout=$allowCheckout}
				{/foreach}

				<div class="timespan">
					{translate key="Yesterday"} ({$YesterdayReservations|default:array()|count})
				</div>
				{foreach from=$YesterdayReservations item=reservation}
                    {include file='Dashboard/dashboard_reservation.tpl' reservation=$reservation allowCheckin=$allowCheckin allowCheckout=$allowCheckout}
				{/foreach}

				<div class="timespan">
					{translate key="EarlierThisWeek"} ({$ThisWeeksReservations|default:array()|count})
				</div>
				{foreach from=$ThisWeeksReservations item=reservation}
                    {include file='Dashboard/dashboard_reservation.tpl' reservation=$reservation allowCheckin=$allowCheckin allowCheckout=$allowCheckout}
				{/foreach}

				<div class="timespan">
					{translate key="PreviousWeek"} ({$PreviousWeekReservations|default:array()|count})
				</div>
				{foreach from=$PreviousWeekReservations item=reservation}
                    {include file='Dashboard/dashboard_reservation.tpl' reservation=$reservation allowCheckin=$allowCheckin allowCheckout=$allowCheckout}
				{/foreach}

				<div class="timespan">
					{translate key="Other"} ({$RemainingReservations|default:array()|count})
				</div>
				{foreach from=$RemainingReservations item=reservation}
                    {include file='Dashboard/dashboard_reservation.tpl' reservation=$reservation allowCheckin=$allowCheckin allowCheckout=$allowCheckout}
				{/foreach}
			</div>
		{else}
			<div class="noresults">{translate key="NoMissingCheckOutReservations"}</div>
		{/if}
	</div>

	<form id="form-checkin" method="post">
		<input type="hidden" id="referenceNumber" {formname key=REFERENCE_NUMBER} />
		{csrf_token}
	</form>

    {*<form id="form-checkout" method="post" action="ajax/reservation_checkin.php?action={ReservationAction::Checkout}">*}
		{*<input type="hidden" id="referenceNumber" {formname key=REFERENCE_NUMBER} />*}
		{*{csrf_token}*}
	{*</form>*}
</div>