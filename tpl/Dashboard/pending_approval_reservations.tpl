<div class="dashboard upcomingReservationsDashboard" id="upcomingReservationsDashboard">
	<div class="dashboardHeader">
		<div class="pull-left">{translate key="PendingApprovalReservations"}<span class="badge">{$Total}</span></div>
		<div class="pull-right">
			<a href="#" title="{translate key=ShowHide} {translate key="PendingApprovalReservations"}">
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
				{assign var=orangePending value=false}
				<div class="timespan">
					{translate key="Today"} ({$TodaysReservations|default:array()|count})
				</div>
				{foreach from=$TodaysReservations item=reservation}
					{include file='Dashboard/dashboard_reservation.tpl' reservation=$reservation allowCheckin=$allowCheckin allowCheckout=$allowCheckout orangePending=$orangePending}
				{/foreach}

				<div class="timespan">
					{translate key="Tomorrow"} ({$TomorrowsReservations|default:array()|count})
				</div>
				{foreach from=$TomorrowsReservations item=reservation}
					{include file='Dashboard/dashboard_reservation.tpl' reservation=$reservation allowCheckin=$allowCheckin allowCheckout=$allowCheckout orangePending=$orangePending}
				{/foreach}

				<div class="timespan">
					{translate key="LaterThisWeek"} ({$ThisWeeksReservations|default:array()|count})
				</div>
				{foreach from=$ThisWeeksReservations item=reservation}
					{include file='Dashboard/dashboard_reservation.tpl' reservation=$reservation allowCheckin=$allowCheckin allowCheckout=$allowCheckout orangePending=$orangePending}
				{/foreach}

				<div class="timespan">
					{translate key="NextWeek"} ({$NextWeeksReservations|default:array()|count})
				</div>
				{foreach from=$NextWeeksReservations item=reservation}
					{include file='Dashboard/dashboard_reservation.tpl' reservation=$reservation allowCheckin=$allowCheckin allowCheckout=$allowCheckout orangePending=$orangePending}
				{/foreach}

				<div class="timespan">
					{translate key="LaterThisMonth"} ({$T|default:array()|count})
				</div>
				{foreach from=$ThisMonthsReservations item=reservation}
					{include file='Dashboard/dashboard_reservation.tpl' reservation=$reservation allowCheckin=$allowCheckin allowCheckout=$allowCheckout orangePending=$orangePending}				
				{/foreach}

				<div class="timespan">
					{translate key="LaterThisYear"} ({$T|default:array()|count})
				</div>
				{foreach from=$ThisYearsReservations item=reservation}
					{include file='Dashboard/dashboard_reservation.tpl' reservation=$reservation allowCheckin=$allowCheckin allowCheckout=$allowCheckout orangePending=$orangePending}
				{/foreach}

				<div class="timespan">
					{translate key="Other"} ({$T|default:array()|count})
				</div>
				{foreach from=$RemainingReservations item=reservation}
					{include file='Dashboard/dashboard_reservation.tpl' reservation=$reservation allowCheckin=$allowCheckin allowCheckout=$allowCheckout orangePending=$orangePending}
				{/foreach}
			</div>
		{else}
			<div class="noresults">{translate key="NoPendingApprovalReservations"}</div>
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
