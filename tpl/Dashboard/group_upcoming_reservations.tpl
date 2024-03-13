<div class="upcomingReservationsDashboard accordion-item shadow mb-2" id="upcomingReservationsDashboard">
	<div class="accordion-header dashboardHeader">
		<button class="accordion-button collapsed link-primary fw-bold" type="button" data-bs-toggle="collapse"
			data-bs-target="#groupUpcomingReservationsDashboardContents" aria-expanded="false"
			aria-controls="groupUpcomingReservationsDashboardContents">
			{translate key="GroupUpcomingReservations"}<span class="badge bg-primary ms-1">{$Total}</span>
		</button>
	</div>
	<div id="groupUpcomingReservationsDashboardContents" class="accordion-collapse collapse">
		<div class="accordion-body">
			{if $Total > 0}
				<div>
					<div class="timespan bg-warning border-bottom p-1 fw-medium fst-italic">
						{translate key="Today"} ({$TodaysReservations|default:array()|count})
					</div>
					{foreach from=$TodaysReservations item=reservation}
						{include file='Dashboard/dashboard_reservation.tpl' reservation=$reservation allowCheckin=$allowCheckin allowCheckout=$allowCheckout}
					{/foreach}

					<div class="timespan bg-warning border-bottom p-1 fw-medium fst-italic">
						{translate key="Tomorrow"} ({$TomorrowsReservations|default:array()|count})
					</div>
					{foreach from=$TomorrowsReservations item=reservation}
						{include file='Dashboard/dashboard_reservation.tpl' reservation=$reservation allowCheckin=$allowCheckin allowCheckout=$allowCheckout}
					{/foreach}

					<div class="timespan bg-warning border-bottom p-1 fw-medium fst-italic">
						{translate key="LaterThisWeek"} ({$ThisWeeksReservations|default:array()|count})
					</div>
					{foreach from=$ThisWeeksReservations item=reservation}
						{include file='Dashboard/dashboard_reservation.tpl' reservation=$reservation allowCheckin=$allowCheckin allowCheckout=$allowCheckout}
					{/foreach}

					<div class="timespan bg-warning border-bottom p-1 fw-medium fst-italic">
						{translate key="NextWeek"} ({$NextWeeksReservations|default:array()|count})
					</div>
					{foreach from=$NextWeeksReservations item=reservation}
						{include file='Dashboard/dashboard_reservation.tpl' reservation=$reservation allowCheckin=$allowCheckin allowCheckout=$allowCheckout}
					{/foreach}
				</div>
			{else}
				<div class="noresults text-center fst-italic fs-5">{translate key="NoGroupUpcomingReservations"}</div>
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
</div>